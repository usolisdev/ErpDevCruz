@extends('layouts.app')

@section('title')
	<title>Dosificacion | {{$PfacNombre . ' - ' .$EmpresaNombre}}</title>
@endsection

@section('links')
		<link rel="stylesheet" type="text/css" href="{{ asset('css/otros.css') }}">
	    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

	   <!--  <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> -->
	    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	    <!-- <link href="{{ asset('assets/global/css/components-rounded.min.css ') }}" rel="stylesheet" id="style_components" type="text/css" /> -->
	    <link href="{{ asset('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
	    <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>


	    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
	    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
	    <script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" ></script>
	    <script src="{{ asset('js/general.js')}}"></script>

	    <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
	    
    
	{{--<script src="{{ asset('js/tablas.js') }}"></script>--}}
	<script src="{{ asset('js/dosificacionsuc.js') }}"></script>
@endsection

@section('Pagetitle')

    <h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Listado de dosificacion</h1>
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-8 my-1">
        <li class="breadcrumb-item text-dark">Empresas</li>
        <li class="breadcrumb-item text-dark">Sucursales</li>
        <li class="breadcrumb-item text-dark">puntos de facturizacion</li>
        <li class="breadcrumb-item text-muted">Dosificaciones</li>
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
        <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Chat App">
            <span class="menu-icon me-0">
                <i class="bi bi-chat-square-text fs-2"></i>
            </span>
        </span>
        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4" style="">
            <div class="menu-item">
                <div class="menu-content">
                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">Chat</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/apps/chat/private.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Private Chat</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/apps/chat/group.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Group Chat</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="../../demo4/dist/apps/chat/drawer.html">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Drawer Chat</span>
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
	<div class="row">
        <div class="col-md-12">
			@if (session('sinacceso'))
		        <div id="prefix_1329875903354" class="custom-alerts alert alert-danger fade in">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		            {{ session('sinacceso') }}
		        </div>
		    @endif
			<label id="lblidempresa" style="display: none;">{{ $idempresa }}</label>
			<label id="lblidsucursal" style="display: none;">{{ $idsucursal }}</label>
			<label id="access" style="display: none;">{{$access}}</label>
			<label id="lblidpfacturacion" style="display: none;">{{$idpfacturacionl}}</label>
			<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" data-select2-id="select2-data-75-yznj" style="background-color: #D6DBDF;background-size: auto 100%;">
			<div style="height: 100%;" class="card-body container-xxl pt-10 pb-8" data-select2-id="select2-data-74-kxv9">
				<div class="card portlet light bordered">
					<div class="card-header border-0 pt-5">
					    <h3 class="card-title align-items-start flex-column">
					        <span class="card-label fw-bolder fs-3 mb-1">Dosificacion de {{$PfacNombre . ' - ' .$EmpresaNombre}}</span>
					    </h3>
		                <div class="actions">
		                	@if($access!="consulta")
		                        <button type="button" class="btn btn-primary me-5" id="btn-adddos" data-bs-toggle="modal" data-bs-target="#modaladddos">Agregar Dosificacion</button>
								<button type="button" class="btn btn-warning" id="idrtexcel">Excel</button>
								<button type="button" class="btn  btn-danger" onclick="javascript:window.open('http://localhost:8000/sucursales/repsucursal/{{$idempresa}}','','width=900,height=500,left=50,top=50');">PDF</button>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="card-body container-xxl pt-0 pb-8" data-select2-id="select2-data-74-kxv9">
				<div class="row">
					<div class="col-md-12">
						<div class="card portled light bordered">
							<div class="card-body py-3">
								<div id="tabla" class="table-responsive" >
									<table id="tabladosificacion" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
										<thead>
											<tr class="fw-bolder text-muted">
												<th>n° tramite</th>
												<th>n° Autorizacion</th>
												<th>n° de factura restantes</th>
												<th>Sistema facturacion</th>
												<th>fecha limite de emision</th>
												<th>Opciones</th>
											</tr>
										</thead>

										<tbody>
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
	<div id="modaladddos" class="modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered mw-650px">
			<div class="modal-content">
				<form class="form" action="#" id="formulario" data-kt-redirect="">
					<div class="modal-header">
						<h3 class="modal-title" id="tituloModaldos"> Añadir Dosificacion</h3>
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
					</div>
					<div class="modal-body">
						<div class="row g-9 mb-7">	
							<div class="col-md-6 fv-row">
								<label for="txtntramite" class="required fs-6 fw-bold mb-2">N° de Tramite:</label>
								<input class="form-control form-control-solid" type="text" id="txtntramite"/>
							</div>
							<div class="col-md-6 fv-row">
								<label for="txtnauth" class="required fs-6 fw-bold mb-2">N° de Autorizacion:</label>
								<input class="form-control form-control-solid" type="text" id="txtnauth"/>
							</div>
						</div>
						<div class="row g-9 mb-7">
							<div class="col-md-6 fv-row">
								<label for="txtnfac" class="required fs-6 fw-bold mb-2">Cantidad de Facturas:</label>
								<input class="form-control form-control-solid" type="text" id="txtnfac"/>
							</div>
							<div id="divcomes" class="col-md-6 fv-row">
								<label for="txtfle" class="required fs-6 fw-bold mb-2">Fecha Limite de Emision:</label>
								<input class="form-control form-control-solid" type="date" id="txtfle"/>
							</div>
						</div>	
						<div class="row g-9 mb-7">
							<div id="divcomes" class="col-md-6 fv-row">
								<label for="txtfle" class="required fs-6 fw-bold mb-2">Fecha Limite de Emision:</label>
								<input class="form-control form-control-solid" type="date" id="txtfle"/>
							</div>
							<div class="col-md-6 fv-row" >
								<label for="comboley" class="required fs-6 fw-bold mb-2">Leyenda:</label>
								<select id="comboley" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Opciones" data-hide-search="true">
									@if (!empty($ley))
										@foreach($ley as $s)
											<option value=""></option>
											<option class="leyenda" value="{{$s->id}}">{{ $s->ley }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="row g-9 mb-7">		
							<div class="col-md-6 fv-row">
								<label for="txttday" class="required fs-6 fw-bold mb-2">Tiempo de Emision en dias:</label>
								<input class="form-control form-control-solid" type="text" id="txttday"/>
							</div>
							<div class="col-md-6 fv-row" >
								<label for="combosisfac" class="required fs-6 fw-bold mb-2">sistema de Facturacion:</label>
								<select id="combosisfac" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Opciones" data-hide-search="true">
									@if (!empty($sistemafac))
										@foreach($sistemafac as $s)
											<option value=""></option>
											<option class="sisfac" value="{{$s->id}}">{{ $s->sistemafacturacion }}</option>	
										@endforeach
						            @endif
								</select>
							</div>
						</div>	
						<div class="row g-9 mb-7">
							<div class="col-md-6 fv-row" id="idtxtclave">
								<label for="txtclave" class="required fs-6 fw-bold mb-2">Clave:</label>
								<input class="form-control form-control-solid" type="text" id="txtclave"/>
							</div>
							<div class="col-md-6 fv-row position-relative" >
								<label for="combohab" class="required fs-6 fw-bold mb-2">Estado:</label>
								<select id="combohab" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Opciones" data-hide-search="true">
									<option value=""></option>
									<option value="0">Deshabilitado</option>
									<option value="1">Habilitado</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer flex-center">
						<button type="button" class="btn btn-info" id="btnAceptaradddos">Aceptar</button>
						<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="modaladvertencia" class="modal fade" role="dialog">
		<div class="modal-dialog">		
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="tituloModal">Advertencia</h3>
				</div>

				<div class="modal-body">
					<h4 id="mensajeadver">¿Esta Seguro de Querer Eliminar este Registro?</h4>
				</div>
					
				<div class="modal-footer">
					<button type="button" class="btn btn-info" id="btnacepadv">Aceptar</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
				</div>
			</div>

		</div>
	</div>
@endsection
