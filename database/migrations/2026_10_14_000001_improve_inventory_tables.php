<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Ajustes para que el sistema funcione con pesos colombianos y con el control de stock:
 *  - Montos con 12 dígitos (antes el máximo era 999.999,99).
 *  - Stock mínimo por producto (alertas de stock bajo en el inicio).
 *  - Datos de conexión de la impresora de tickets.
 *  - Campos opcionales de la empresa (logo, descripción).
 */
return new class extends Migration
{
    public function up()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE sales MODIFY tax DECIMAL(5,2) NOT NULL DEFAULT 0, MODIFY total DECIMAL(14,2) NOT NULL');
            DB::statement('ALTER TABLE purchases MODIFY tax DECIMAL(5,2) NOT NULL DEFAULT 0, MODIFY total DECIMAL(14,2) NOT NULL');
            DB::statement('ALTER TABLE sale_details MODIFY price DECIMAL(12,2) NOT NULL, MODIFY discount DECIMAL(5,2) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE purchase_details MODIFY price DECIMAL(12,2) NOT NULL');
            DB::statement('ALTER TABLE businesses MODIFY description VARCHAR(255) NULL, MODIFY logo VARCHAR(255) NULL, MODIFY mail VARCHAR(255) NULL, MODIFY address VARCHAR(255) NULL');
        }

        Schema::table('products', function (Blueprint $table) {
            $table->integer('min_stock')->default(5)->after('stock');
        });

        Schema::table('printers', function (Blueprint $table) {
            // windows: nombre compartido de la impresora (ej. TM20)
            // network: IP de una impresora de red (puerto 9100)
            // cups:    nombre de la impresora en Linux / macOS
            $table->string('connector')->default('windows')->after('name');
            $table->string('host')->nullable()->after('connector');
            $table->unsignedInteger('port')->default(9100)->after('host');
            $table->unsignedTinyInteger('width')->default(42)->after('port'); // caracteres por línea (80mm = 42/48, 58mm = 32)
        });
    }

    public function down()
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->dropColumn(['connector', 'host', 'port', 'width']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('min_stock');
        });
    }
};
