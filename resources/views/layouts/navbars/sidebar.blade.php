<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-normal">
            <i class="tim-icons icon-align-left-2"></i>
                {{ __('MENU ') }}</a>
        </div>

        <ul class="nav">
            <li>
                <a data-toggle="collapse" href="#principal" aria-expanded="true">
                    <i class="tim-icons icon-tap-02"></i>
                    <span class="nav-link-text">{{ __('PRINCIPAL') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="principal">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                            <a href="{{ route('home') }}">
                                <i class="tim-icons icon-laptop"></i>
                                <p>{{ __('INICIO') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='profile' ) class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-satisfied"></i>
                                <p>{{ __('USUARIO') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#personas" aria-expanded="true">
                    <i class="tim-icons icon-single-02"></i>
                    <span class="nav-link-text">{{ __('PERSONAS') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="personas">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='clients' ) class="active " @endif>
                            <a href="{{ route('clients.index')  }}">
                                <i class="tim-icons icon-user-run"></i>
                                <p>{{ __('CLIENTES') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='providers' ) class="active " @endif>
                            <a href="{{ route('providers.index')  }}">
                                <i class="tim-icons icon-bus-front-12"></i>
                                <p>{{ __('PROVEEDORES') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#elementos"aria-expanded="true">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <span class="nav-link-text">{{ __('ELEMENTOS') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="elementos">
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
                    <i class="tim-icons icon-coins"></i>
                    <span class="nav-link-text">{{ __('TRANSACCIONES') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="transacciones">
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