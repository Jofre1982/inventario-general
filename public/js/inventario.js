/* Utilidades compartidas: formato de pesos y editor de líneas para ventas y compras. */
(function (window, $) {
    'use strict';

    var fmt = new Intl.NumberFormat('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 2 });

    function money(value) {
        return '$ ' + fmt.format(Math.round((Number(value) || 0) * 100) / 100);
    }

    function escapeHtml(text) {
        return String(text).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    /**
     * Editor de líneas con búsqueda por código de barras o nombre.
     *
     * opts.mode: 'sale' (precio fijo, descuento, valida stock) o 'purchase' (precio de compra editable)
     * opts.lookupUrl: URL de products.lookup
     */
    function LineEditor(opts) {
        this.mode = opts.mode;
        this.lookupUrl = opts.lookupUrl;
        this.$scan = $(opts.scan);
        this.$results = $(opts.results);
        this.$body = $(opts.body);
        this.$tax = $(opts.tax);
        this.$submit = $(opts.submit);
        this.$subtotal = $(opts.subtotal);
        this.$taxAmount = $(opts.taxAmount);
        this.$total = $(opts.total);
        this.lines = {};
        this.index = 0;
        this.found = [];
        this.selected = -1;
        this.timer = null;
        this.bind();
        this.render();
    }

    LineEditor.prototype.bind = function () {
        var self = this;

        // Los lectores de código de barras "escriben" el código y envían Enter.
        this.$scan.on('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (self.selected >= 0 && self.found[self.selected]) {
                    self.add(self.found[self.selected]);
                } else {
                    self.search(true);
                }
            } else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                if (!self.found.length) return;
                self.selected = (self.selected + (e.key === 'ArrowDown' ? 1 : -1) + self.found.length) % self.found.length;
                self.showResults();
            } else if (e.key === 'Escape') {
                self.hideResults();
            }
        });

        this.$scan.on('input', function () {
            clearTimeout(self.timer);
            self.timer = setTimeout(function () { self.search(false); }, 250);
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest(self.$results.add(self.$scan)).length) self.hideResults();
        });

        this.$results.on('click', '[data-i]', function () {
            self.add(self.found[$(this).data('i')]);
        });

        this.$body.on('input change', 'input[data-field]', function () {
            var key = $(this).closest('tr').data('key');
            var field = $(this).data('field');
            var value = parseFloat($(this).val());
            self.lines[key][field] = isNaN(value) ? 0 : value;
            self.updateTotals();
        });

        this.$body.on('click', '[data-remove]', function () {
            delete self.lines[$(this).closest('tr').data('key')];
            self.render();
            self.$scan.focus();
        });

        this.$tax.on('input change', function () { self.updateTotals(); });

        this.$submit.closest('form').on('submit', function (e) {
            var error = self.validate();
            if (error) {
                e.preventDefault();
                Swal.fire({ icon: 'error', text: error });
            } else {
                self.$submit.prop('disabled', true);
            }
        });
    };

    LineEditor.prototype.search = function (exact) {
        var self = this;
        var term = $.trim(this.$scan.val());
        if (!term) { this.hideResults(); return; }

        $.getJSON(this.lookupUrl, { q: term }).done(function (products) {
            if ($.trim(self.$scan.val()) !== term) return; // llegó tarde
            self.found = products;
            self.selected = products.length ? 0 : -1;

            // Código de barras exacto: se agrega directo.
            if (exact && products.length === 1) {
                self.add(products[0]);
                return;
            }
            if (exact && !products.length) {
                Swal.fire({ icon: 'warning', text: 'No se encontró ningún producto con "' + term + '".', timer: 2500 });
            }
            self.showResults();
        });
    };

    LineEditor.prototype.showResults = function () {
        var self = this;
        if (!this.found.length) { this.hideResults(); return; }
        this.$results.html(this.found.map(function (p, i) {
            var extra = self.mode === 'sale'
                ? money(p.sell_price) + ' · stock ' + p.stock + (p.active ? '' : ' · INACTIVO')
                : 'stock ' + p.stock;
            return '<a class="list-group-item' + (i === self.selected ? ' active' : '') + '" data-i="' + i + '">'
                + '<b>' + escapeHtml(p.name) + '</b> <small class="float-right">' + escapeHtml(p.code || '') + ' · ' + extra + '</small></a>';
        }).join('')).show();
    };

    LineEditor.prototype.hideResults = function () {
        this.$results.hide().empty();
        this.found = [];
        this.selected = -1;
    };

    LineEditor.prototype.add = function (product) {
        if (!product) return;
        if (this.mode === 'sale') {
            if (!product.active) {
                Swal.fire({ icon: 'error', text: 'El producto "' + product.name + '" está desactivado.' });
                return;
            }
            if (product.stock <= 0) {
                Swal.fire({ icon: 'error', text: 'No hay stock de "' + product.name + '".' });
                return;
            }
        }

        var key = 'p' + product.id;
        if (this.lines[key]) {
            this.lines[key].quantity += 1;
        } else {
            this.lines[key] = {
                index: this.index++,
                product: product,
                quantity: 1,
                price: this.mode === 'sale' ? Number(product.sell_price) : 0,
                discount: 0
            };
        }

        this.$scan.val('');
        this.hideResults();
        this.render();

        // En compras el cursor salta al precio de compra del producto recién agregado.
        var $row = this.$body.find('tr[data-key="' + key + '"]');
        if (this.mode === 'purchase' && !this.lines[key].price) {
            $row.find('input[data-field="price"]').focus().select();
        } else {
            this.$scan.focus();
        }
    };

    LineEditor.prototype.render = function () {
        var self = this;
        var keys = Object.keys(this.lines);

        if (!keys.length) {
            this.$body.html('<tr class="empty"><td colspan="7" class="text-center text-muted py-4">Escanee un código de barras o escriba el nombre del producto.</td></tr>');
            this.updateTotals();
            return;
        }

        this.$body.html(keys.map(function (key) {
            var l = self.lines[key];
            var n = 'items[' + l.index + ']';
            var html = '<tr data-key="' + key + '">'
                + '<td><input type="hidden" name="' + n + '[product_id]" value="' + l.product.id + '">'
                + '<b>' + escapeHtml(l.product.name) + '</b><br><small class="text-muted">' + escapeHtml(l.product.code || '') + ' · stock ' + l.product.stock + '</small></td>'
                + '<td><input type="number" class="form-control" min="1" step="1" name="' + n + '[quantity]" data-field="quantity" value="' + l.quantity + '"></td>';

            if (self.mode === 'sale') {
                html += '<td class="text-right">' + money(l.price) + '</td>'
                    + '<td><input type="number" class="form-control" min="0" max="100" step="0.01" name="' + n + '[discount]" data-field="discount" value="' + l.discount + '"></td>';
            } else {
                html += '<td><input type="number" class="form-control" min="0" step="any" name="' + n + '[price]" data-field="price" value="' + (l.price || '') + '" placeholder="Costo unitario"></td>';
            }

            return html + '<td class="text-right" data-subtotal></td>'
                + '<td class="text-right"><button type="button" class="btn btn-link btn-danger btn-sm" data-remove title="Quitar"><i class="tim-icons icon-simple-remove"></i></button></td></tr>';
        }).join(''));

        this.updateTotals();
    };

    LineEditor.prototype.lineSubtotal = function (l) {
        var gross = l.quantity * l.price;
        return this.mode === 'sale' ? gross - gross * l.discount / 100 : gross;
    };

    LineEditor.prototype.updateTotals = function () {
        var self = this;
        var subtotal = 0;

        Object.keys(this.lines).forEach(function (key) {
            var value = self.lineSubtotal(self.lines[key]);
            subtotal += value;
            self.$body.find('tr[data-key="' + key + '"] [data-subtotal]').text(money(value));
        });

        var tax = parseFloat(this.$tax.val()) || 0;
        var taxAmount = subtotal * tax / 100;

        this.$subtotal.text(money(subtotal));
        this.$taxAmount.text(money(taxAmount));
        this.$total.text(money(subtotal + taxAmount));
        this.$submit.prop('disabled', !Object.keys(this.lines).length);
    };

    LineEditor.prototype.validate = function () {
        var self = this;
        var keys = Object.keys(this.lines);
        if (!keys.length) return 'Agregue al menos un producto.';

        for (var i = 0; i < keys.length; i++) {
            var l = self.lines[keys[i]];
            if (!(l.quantity >= 1) || Math.floor(l.quantity) !== l.quantity) return 'La cantidad de "' + l.product.name + '" debe ser un número entero mayor que cero.';
            if (self.mode === 'sale' && l.quantity > l.product.stock) return 'Solo hay ' + l.product.stock + ' unidades de "' + l.product.name + '".';
            if (self.mode === 'sale' && (l.discount < 0 || l.discount > 100)) return 'El descuento de "' + l.product.name + '" debe estar entre 0 y 100.';
            if (self.mode === 'purchase' && !(l.price > 0)) return 'Escriba el costo unitario de "' + l.product.name + '".';
        }
        return null;
    };

    window.Inventario = { money: money, LineEditor: LineEditor };
})(window, jQuery);
