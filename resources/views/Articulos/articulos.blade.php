@extends('layouts.app')

@section('title')
	<title>Acticulos | {{$EmpresaNombre}}</title>
@endsection

@section('links')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/otros.css') }}">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

   <!--  <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> -->
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('assets/global/css/components-rounded.min.css ') }}" rel="stylesheet" id="style_components" type="text/css" /> -->
    <link href="{{ asset('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.autocomplete {
		  position: relative;
		  display: inline-block;
		  width: 100%;
		}
		.autocomplete-items {
		  position: absolute;
		  border: 1px solid #d4d4d4;
		  border-bottom: none;
		  border-top: none;
		  z-index: 99;
		  top: 100%;
		  left: 0;
		  right: 0;
		}
		.autocomplete-items div {
		  padding: 10px;
		  cursor: pointer;
		  cursor: hand;
		  background-color: #fff; 
		  border-bottom: 1px solid #d4d4d4; 
		}
		.autocomplete-items div:hover {
		  background-color: #e9e9e9; 
		}
		.autocomplete-active {
		  background-color: DodgerBlue !important; 
		  color: #ffffff; 
		}
		@media screen and (max-width: 1400px) {
			#dialmodal {
				width: 850px !important;
			}
			#lbltipocom{
				font-size: 10px !important;
			}
			#lbltipocamb{
				font-size: 11px !important;
			}
		}
		@media screen and (max-width: 851px) {
			#dialmodal {
				width: 600px !important;
			}
		}
		@media screen and (max-width: 600px) {
			#dialmodal {
				width: 400px !important;
			}
		}
		@media screen and (max-width: 400px) {
			#dialmodal {
				width: 300px !important;
			}
		}
	</style>
@endsection

@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" ></script>
    <script src="{{ asset('js/general.js')}}"></script>

    <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    
	<script src="{{ asset('js/tablas.js') }}"></script>
	<script src="{{ asset('js/articulo.js') }}"></script>
@endsection

@section('Pagetitle')

    <h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Listado de catalogo</h1>
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-8 my-1">
        <li class="breadcrumb-item text-dark">Empresas</li>
        <li class="breadcrumb-item text-muted">Catalogo</li>
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('MenuPrimary')

    <div class="menu-item py-3">
        <a class="menu-link menu-center" href="/" title="Empresas" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
            <span class="menu-icon me-0">
                <i class="las la-home fs-1"></i>
            </span>
        </a>
    </div>

    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
        <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Gestion">
            <span class="menu-icon me-0">
                <i class="bi bi-gear fs-2"></i>
            </span>
        </span>
        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4">
            <div class="menu-item">
                <div class="menu-content">
                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">Gestionar</span>
                </div>
            </div>
            <div class="menu-item" id="viewagendaadmin">
                <a href="{{ route('Agendaadmin', $idempresa) }}" class="menu-link" href="" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                    <span class="menu-icon">
                        <i class="las la-key fs-1"></i>
                    </span>
                    <span class="menu-title">Agenda</span>
                </a>
            </div>
            <div class="menu-item" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" id="viewparametros">
                <span class="menu-link py-3">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                           <i class="las la-stopwatch fs-1"></i>
                        </span>
                    </span>
                    <span class="menu-title">Parametrizacion</span>
                    <span class="selected"></span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                    <div data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion" id="view2sucursales">
                        <a href="{{ route('listar-sucursal', $idempresa) }}" class="menu-link py-3">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <i class="las la-city fs-1"></i>
                                </span>
                            </span>
                            <span class="menu-title">Sucursales</span>
                        </a>
                    </div>
                    <div data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion" id="view2gestiones">
                        <a href="{{ route('listar-gestion', $idempresa) }}" class="menu-link py-3">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <i class="lab la-buffer fs-1"></i>
                                </span>
                            </span>
                            <span class="menu-title">Gestiones</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{ route('usuarios', $idempresa) }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                    <span class="menu-icon">
                        <i class="las la-users fs-1"></i>
                    </span>
                    <span class="menu-title">Usuarios</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                    <span class="menu-icon">
                        <i class="las la-ticket-alt fs-1"></i>
                    </span>
                    <span class="menu-title">Membresias</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                    <span class="menu-icon">
                        <i class="las la-key fs-1"></i>
                    </span>
                    <span class="menu-title">Accesos</span>
                </a>
            </div>
            {{-- <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/documentation/getting-started/changelog.html">
                    <span class="menu-icon">
                        <i class="bi bi-card-text fs-3"></i>
                    </span>
                    <span class="menu-title">Changelog v8.0.24</span>
                </a>
            </div> --}}
        </div>
    </div>
    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
        <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Authentication Pages">
            <span class="menu-icon me-0">
                <i class="bi bi-file-earmark-lock fs-2"></i>
            </span>
        </span>
        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4" style="">
            <div class="menu-item">
                <div class="menu-content">
                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">Authentication</span>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Basic</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion" kt-hidden-height="189" style="display: none; overflow: hidden;">
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/flows/basic/sign-in.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Sign-in</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/flows/basic/sign-up.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Sign-up</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/flows/basic/two-steps.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Two-steps</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/flows/basic/password-reset.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Password Reset</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/flows/basic/new-password.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">New Password</span>
                        </a>
                    </div>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Extended</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/extended/multi-steps-sign-up.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Multi-steps Sign-up</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/extended/free-trial-sign-up.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Free Trial Sign-up</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/extended/coming-soon.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Coming Soon</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/verify-email.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Verify Email</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/password-confirmation.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Password Confirmation</span>
                        </a>
                    </div>
                </div>
            </div>
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">General</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-sub-lg-dropdown w-lg-225px px-lg-1 py-lg-4" style="">
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/welcome.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Welcome</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/verify-email.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Verify Email</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/password-confirmation.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Password Confirmation</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/close-account.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Close Account</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/error-404.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Error 404</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/general/error-500.html">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Error 500</span>
                        </a>
                    </div>
                </div>
            </div>
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Email</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-sub-lg-dropdown w-lg-225px px-lg-1 py-lg-4" style="">
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/email/verify-email.html" target="blank">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Verify Email</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/email/password-reset.html" target="blank">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Password Reset</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="../../demo4/dist/authentication/email/password-change.html" target="blank">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Password Change</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
        <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Account Pages">
            <span class="menu-icon me-0">
                <i class="bi bi-shield-check fs-2"></i>
            </span>
        </span>
        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4" style="">
            <div class="menu-item">
                <div class="menu-content">
                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">Account</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/account/overview.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Overview</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/account/settings.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Settings</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/account/security.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Security</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/account/billing.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Billing</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/account/statements.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Statements</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/account/referrals.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Referrals</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/account/api-keys.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">API Keys</span>
                </a>
            </div>
        </div>
    </div>
    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
        <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Compras">
            <span class="menu-icon me-0">
                <i class="las la-shopping-cart fs-1"></i>
            </span>
        </span>
        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4" style="">
            <div class="menu-item">
                <div class="menu-content">
                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">Compras</span>
                </div>
            </div>
            <div class="menu-item" id="viewcatalogocampras">
                <a class="menu-link" href="{{ route('listar-articulos', $idempresa) }}">
                    <span class="menu-bullet">
                       <i class="lab la-readme fs-2"></i>
                    </span>
                    <span class="menu-title">Catalogo</span>
                </a>
            </div>
        </div>
    </div>
    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
        <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Customers App">
            <span class="menu-icon me-0">
                <i class="bi bi-people fs-2"></i>
            </span>
        </span>
        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4" style="">
            <div class="menu-item">
                <div class="menu-content">
                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">Customers</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/apps/customers/getting-started.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Getting Started</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/apps/customers/list.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Customer Listing</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/apps/customers/view.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Customer Details</span>
                </a>
            </div>
        </div>
    </div>
    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
        <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="General Pages">
            <span class="menu-icon me-0">
                <i class="bi bi-file-text fs-2"></i>
            </span>
        </span>
        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4">
            <div class="menu-item">
                <div class="menu-content">
                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">General</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/pages/company/about.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">About Us</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/pages/company/pricing.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pricing</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/pages/company/contact.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Contact Us</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/pages/company/team.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Our Team</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/pages/company/licenses.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Licenses</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/pages/company/sitemap.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Sitemap</span>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('content')
	@if (session('sinacceso'))
        <div id="prefix_1329875903354" class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{ session('sinacceso') }}
        </div>
    @endif
	@if (Auth::check())
		<!-- <center><h2>Catálogo</h2></center> -->
	    <label id="lblidempresa" style="display: none;">{{ $idempresa }}</label>
	    <div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" data-select2-id="select2-data-75-yznj" style="background-color: #D6DBDF;background-size: auto 100%;">
	    	<div style="height: 100%;" class="card-body container-xxl pt-10 pb-8" data-select2-id="select2-data-74-kxv9">
	    		<div class="card portlet light bordered">
					<div class="card-header border-0 pt-5">
						<h3 class="caption font-dark">
	                        <!-- <i class="icon-bar-chart font-dark"></i> -->
	                        <span class="card-label fw-bolder fs-3 mb-1">Catálogo de {{$EmpresaNombre}}</span>
	                    </h3>
	                    <div class="actions">
	               			<button type="button" class="btn btn-primary me-5" id="btn-addart" >Agregar Articulo</button> 
	               			<button type="button" class="btn btn-warning" id="btn-repem"onclick="javascript: window.open('http://localhost:9595/ReporteFinal/Articulo.php','','width=900,height=500,left=50,top=50');">Reporte Articulos</button>       
	                    </div>
					</div>
					<div class="card-body container-xxl pt-0 pb-8" data-select2-id="select2-data-74-kxv9">
				        <div class="row">
				            <div class="col-md-12">
								<div class="card portled light bordered">
									<div class="card-body py-3">
										<div id="tabla" class="table-responsive">
											<table id="tablaarticulos" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
												<thead>
													<tr class="fw-bolder text-muted">
														<th>Codigo</th>
														<th>Nombre</th>
														<th>Unidad de medida</th>
														<th>Cantidad</th>
														<th>Precio Venta</th>
														<th>Precio Intermedio</th>
														<th>Precio por Mayor</th>
														<!-- <th>Costo Orden</th> -->
														<!-- <th>Costo Inventario</th> -->
														<!-- <th>Punto Nuevo Pedido</th> -->
														<th>Categoria</th>
														<th>Codigo QR/barras/Ntfs</th>
														<th>Cuenta</th>
														<th>Opciones</th>
													</tr>
												</thead>

												<tbody>
								                    @if (!empty($articulos))
														@foreach($articulos as $a)
															<tr>
																<td class="datcodigo" data-idart="{{$a->id}}">{{$a->codigo}}</td>
																<td class="datnombre" data-idart="{{$a->id}}">{{$a->nombre}}</td>
																<td class="datdes" data-idart="{{$a->id}}">{{$a->descripcion}}</td>
																<td class="datcant" data-idart="{{$a->id}}">{{$a->cantidad}}</td>
																<td class="datprice" data-idart="{{$a->id}}">{{$a->precioventa}}</td>
																<td class="datpriceinter" data-idart="{{$a->id}}">{{$a->preciointermedio}}</td>
																<td class="datpricemary" data-idart="{{$a->id}}">{{$a->preciomayorista}}</td>
																<!-- <td class="datdem" data-idart="{{$a->id}}">{{$a->demanda}}</td> -->
																<!-- <td class="dattime" data-idart="{{$a->id}}">{{date('Y-m-d', strtotime($a->tiempoespera))}}</td> -->
																<!-- <td class="datcosto" data-idart="{{$a->id}}">{{$a->costoorden}}</td> -->
																<!-- <td class="datcostoinv" data-idart="{{$a->id}}">{{$a->costoinventario}}</td> -->
																<!-- <td class="datpoint" data-idart="{{$a->id}}">{{$a->puntonuevopedido}}</td> -->
																<td class="datcat" data-idart="{{$a->id}}" data-idcat="{{$a->idcat}}">{{$a->nombrecat}}</td>
																<td class="datcodigobuscar" data-idart="{{$a->id}}">{{$a->CodigoBuscar}}</td>
																@if($a->idcuenta==null)
																	<td class="datcuenta" data-idart="{{$a->id}}">-</td>
																@else
																	<td class="datcuenta" data-idart="{{$a->id}}">{{$a->idcuenta}}</td>
																@endif
																<td>
																	<a style="" title="Editar" data-idart="{{$a->id}}" data-bs-toggle="tooltip" class=" btn-bg-light btn-active-color-primary me-1 btn-editart">
							                                            <span class="svg-icon svg-icon-5" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
							                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
							                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
							                                                </svg>
							                                            </span>
							                                        </a>
																	<a style="" title="Eliminar" data-idart="{{$a->id}}" data-bs-toggle="tooltip" class=" btn-bg-light btn-active-color-primary me-1 btn-eliminarart" >
							                                            <span class="svg-icon svg-icon-5">
							                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							                                                  <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
							                                                  <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
							                                                  <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
							                                              </svg>
							                                            </span>
							                                        </a>
																	 <a style="" class=" btn-bg-light btn-active-color-primary me-1 btn-goptf" data-bs-toggle="tooltip" data-bs-placement="top" title="Puntos de facturacion">
							                                            <span class="svg-icon svg-icon-5">
							                                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							                                                    <path d="M12 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V2.40002C0 3.00002 0.4 3.40002 1 3.40002H12C12.6 3.40002 13 3.00002 13 2.40002V1.40002C13 0.800024 12.6 0.400024 12 0.400024Z" fill="black"/>
							                                                    <path opacity="0.3" d="M15 8.40002H1C0.4 8.40002 0 8.00002 0 7.40002C0 6.80002 0.4 6.40002 1 6.40002H15C15.6 6.40002 16 6.80002 16 7.40002C16 8.00002 15.6 8.40002 15 8.40002ZM16 12.4C16 11.8 15.6 11.4 15 11.4H1C0.4 11.4 0 11.8 0 12.4C0 13 0.4 13.4 1 13.4H15C15.6 13.4 16 13 16 12.4ZM12 17.4C12 16.8 11.6 16.4 11 16.4H1C0.4 16.4 0 16.8 0 17.4C0 18 0.4 18.4 1 18.4H11C11.6 18.4 12 18 12 17.4Z" fill="black"/>
							                                                </svg>
							                                            </span>
							                                        </a>
																</td>
															</tr>
														@endforeach
						                            @endif
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<!-- Modal Agregar - Editar -->
		<div id="modaladdart"class="modal fade" role="dialog">
			<div class="modal-dialog">
				
				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="tituloModal">Crear Articulo</h3>
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						    <span class="svg-icon svg-icon-1">
						        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
						            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
						        </svg>
						    </span>
						</div>
					</div>

					<div class="modal-body" id="formulario">
						<div class="row g-9 mb-7">
							<div class="col-md-6 fv-row">	
								<label for="txtNombre" class="required fs-6 fw-bold mb-2">Nombre:</label>
								<input class="form-control form-control-solid" type="text" id="txtNombre" name="txtNombre"/>
							</div>
							<div class="col-md-6 fv-row">
								<label for="txtdes" class="required fs-6 fw-bold mb-2">Unidad de medida:</label>
								<input class="form-control form-control-solid" type="text" id="txtdes"name="txtdes"/>
							</div>
						</div>
						<div class="row g-9 mb-7">
							<div class="col-md-6 fv-row">	
								<label for="txtprice" class="required fs-6 fw-bold mb-2">Precio Venta:</label>
								<input class="form-control form-control-solid" type="text" id="txtprice" name="txtprice"/>
							</div>
							<div class="col-md-6 fv-row">
								<label for="txtfecin" class="required fs-6 fw-bold mb-2">Precio venta intermedio:</label>
								<input class="form-control form-control-solid" type="text" id="txtpriceinter" name="txtpriceinter"/>
							</div>
						</div>
						<div class="row g-9 mb-7">
							<div class="col-md-6 fv-row">	
								<label for="txtpricemay" class="required fs-6 fw-bold mb-2">Precio por Mayor:</label>
								<input class="form-control form-control-solid" type="text" id="txtpricemay" name="txtpricemay"/>
							</div>
							<div class="col-md-6 fv-row">
								<label for="cmbcat" class="required fs-6 fw-bold mb-2">Categoria:</label>
								<input class="form-control form-control-solid" type="text" id="cmbcat" name="cmbcat"/>
							</div>
						</div>
						<label id="poolcategorias" style="display: none;">
							@if (!empty($categorias))
								@foreach($categorias as $c)
									{{ '|' . $c->id  . '/' . $c->nombre }}
								@endforeach
				            @endif
				        </label>
						<div class="row g-9 mb-7">
							<div class="col-md-6 fv-row">
								<label for="txtcodebus" class="required fs-6 fw-bold mb-2">codigo Busqueda:</label>
								<input class="form-control form-control-solid" type="text" id="txtcodebus" name="txtcodebus"/>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-info"  id="btnAceptaraddedit">Aceptar</button>
						<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
					</div>
				</div>

			</div>
		</div>
		<!-- Modal advertencia-->
		<div id="modaladvertencia" class="modal fade" role="dialog">
			<div class="modal-dialog">		
				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="tituloModal">Advertencia</h4>
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						    <span class="svg-icon svg-icon-1">
						        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
						            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
						        </svg>
						    </span>
						</div>
					</div>

					<div class="modal-body">
						<h5 id="mensajeadver">¿Esta Seguro de Querer Eliminar este Articulo?</h5>
					</div>
						
					<div class="modal-footer">
						<button type="button" class="btn btn-info" id="btnacepadv">Aceptar</button>
						<button type="button" class="btn btn-default" data-bs-dismiss="modal" id="btndecliadv">Cancelar</button>
					</div>
				</div>

			</div>
		</div>
    @endif    


@endsection


