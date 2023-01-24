<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('MENU') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('DESCRIPCION ') }}</a>
        </div>

        <ul class="nav">
            <div class="collapse show" id="inicio">
                <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                    <a href="{{ route('home') }}">
                        <i class="tim-icons icon-chart-pie-36"></i>
                        <p>{{ __('Inicio') }}</p>
                    </a>
                </li>
            </div>

            <li>
                <a data-toggle="collapse" href="#personas" aria-expanded="true">
                    <i class="tim-icons icon-single-02"></i>
                    <span class="nav-link-text">{{ __('PERSONAS') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="personas">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='profile' ) class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('USUARIO') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='clients' ) class="active " @endif>
                            <a href="{{ route('clients.index')  }}">
                                <i class="tim-icons icon-user-run"></i>
                                <p>{{ __('CLIENTES') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#elementos" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('ELEMENTOS') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="elementos">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='categories' ) class="active " @endif>
                            <a href="{{ route('categories.index')  }}">
                                <i class="tim-icons icon-single-copy-04"></i>
                                <p>{{ __('CATEGORIAS') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug=='products' ) class="active " @endif>
                            <a href="{{ route('products.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('PRODUCTOS') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li>
                <a data-toggle="collapse" href="#transacciones" aria-expanded="true">
                    <i class="tim-icons icon-cart"></i>
                    <span class="nav-link-text">{{ __('TRANSACCIONES') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="transacciones">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='purchases' ) class="active " @endif>
                            <a href="{{ route('purchases.index')  }}">
                                <i class="tim-icons icon-cart"></i>
                                <p>{{ __('COMPRAS') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='sales' ) class="active " @endif>
                            <a href="{{ route('sales.index')  }}">
                                <i class="tim-icons icon-money-coins"></i>
                                <p>{{ __('VENTAS') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>