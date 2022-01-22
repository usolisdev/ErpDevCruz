@extends('layouts.app')

@section('title')
	<title>Sucursales | {{$EmpresaNombre}}</title>
@endsection

@section('links')
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/panel.css') }}"> -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}"> -->
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
        <script src="{{ asset('js/sucursal.js') }}"></script>

@endsection

@section('Pagetitle')

    <h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Listado de Sucursales</h1>
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-8 my-1">
        <li class="breadcrumb-item text-dark">Empresas</li>
        <li class="breadcrumb-item text-dark">Parametrizacion</li>
        <li class="breadcrumb-item text-muted">Sucursales</li>
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
			<label id="access" style="display: none;">{{$access}}</label>
			<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" data-select2-id="select2-data-75-yznj" style="background-color: #D6DBDF;background-size: auto 100%;">
			    <div style="height: 100%;" class="card-body container-xxl pt-10 pb-8" data-select2-id="select2-data-74-kxv9">
			        <div class="row">
			            <div class="col-md-12">
							<div class="card portlet light bordered">
								<div class="card-header border-0 pt-5">
								    <h3 class="card-title align-items-start flex-column">
								        <span class="card-label fw-bolder fs-3 mb-1">Sucursal de {{$EmpresaNombre}}</span>
								    </h3>
				                    <div class="actions">
				                    	@if($access!="consulta")
                                            <button type="button" class="btn btn-primary me-5" id="btn-addsuc" data-bs-toggle="modal" data-bs-target="#modaladdsuc">Agregar Sucursal</button>
				    						<button type="button" class="btn btn-warning" id="idrtexcel">Excel</button>
				    						<button type="button" class="btn  btn-danger" onclick="javascript:window.open('http://localhost:8000/sucursales/repsucursal/{{$idempresa}}','','width=900,height=500,left=50,top=50');">PDF</button>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body container-xxl pt-0 pb-8" data-select2-id="select2-data-74-kxv9">
			        <div class="row">
			            <div class="col-md-12">
							<div class="card portlet light bordered">
								<!-- <div class="card-header border-0">
								    <div class="d-flex align-items-center position-relative my-1">
								        <span class="svg-icon svg-icon-1 position-absolute ms-6">
								            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
								                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
								            </svg>
								        </span>
								        <input type="text" data-kt-empresas-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Buscar Sucursal" />
								    </div>
				                    <div class="actions">
				                    	@if($access!="consulta")
				    						<button id="btnAddempresa" type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#kt_modal_add_empresa">Agregar</button>
										@endif
									</div>
								</div> -->
								<div class="card-body py-3">
									<div id="tabla" class="table-responsive">
										<table id="tablasucursales" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
											<thead>
												<tr class="fw-bolder text-muted">
													<th class="min-w-150px">Alias</th>
													<th class="min-w-140px">Direccion</th>
													<th class="min-w-120px">Contacto</th>
													<th class="min-w-100px text-end">Actions</th>
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
            <div id="modaladdsuc" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content">
                        <form class="form" action="#" id="" data-kt-redirect="">
                            <div class="modal-header">
                                <h2 class="fw-bolder" id="tituloModalsuc"> Crear Sucursal</h2>
                            </div>

                            <div class="modal-body">
                                  <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">

                                    <div id="rowcomplete" class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Alias de la Sucursal</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtalias" class="form-control form-control-solid" placeholder="" name="TxtNombre" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Direccion</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder="" id="txtdirsuc"/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Telefono</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txttelsuc" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Email</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtmailsuc" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-header" id="kt_modal_add_customer_header">
                                <!--begin::Modal title-->
                                <h2 name="TitleModal" class="fw-bolder">Contacto</h2>
                            </div>
                            <div class="modal-body py-10 px-lg-17">
                                <!--begin::Scroll-->
                                <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">

                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">CI</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtci" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">NIT</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder="" id="txtnit"/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Nombres</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtnombres" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Apellidos</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtapellidos" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Email</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtmail" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Celular</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtcel" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Telefono</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txttel" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Direccion</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtdir" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Fecha de Nacimiento</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="txtfecnac" type="date" class="form-control form-control-solid" placeholder=""/>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Scroll-->
                            </div>

                            <div class="modal-footer flex-center">
                                <button type="button" class="btn btn-info" id="btnAceptaraddsuc">Aceptar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
			<div class="modal fade" id="kt_modal_add_empresa" tabindex="-1" aria-hidden="true">
			    <!--begin::Modal dialog-->
			    <div class="modal-dialog modal-dialog-centered mw-650px">
			        <!--begin::Modal content-->
			        <div class="modal-content">
			            <!--begin::Form-->
			            <form class="form" action="#" id="kt_modal_add_empresa_form" data-kt-redirect="">
			                <!--begin::Modal header-->
			                <div class="modal-header" id="kt_modal_add_customer_header">
			                    <!--begin::Modal title-->
			                    <h2 name="TitleModal" class="fw-bolder">Agregar Sucursal</h2>
			                    <!--end::Modal title-->
			                    <!--begin::Close-->
			                    <div id="kt_modal_add_empresa_close" class="btn btn-icon btn-sm btn-active-icon-primary">
			                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
			                        <span class="svg-icon svg-icon-1">
			                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
			                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
			                            </svg>
			                        </span>
			                        <!--end::Svg Icon-->
			                    </div>
			                    <!--end::Close-->
			                </div>
			                <div class="modal-body py-10 px-lg-17">
			                    <!--begin::Scroll-->
			                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">

			                        <div class="row g-9 mb-7">
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="required fs-6 fw-bold mb-2">Alias de la Sucursal</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtNombre" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="required fs-6 fw-bold mb-2">Direccion</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" id="kt_inputmask_nit" name="TxtNit" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                        </div>

			                        <div class="row g-9 mb-7">
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="required fs-6 fw-bold mb-2">Telefono</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtSigla" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="fs-6 fw-bold mb-2">Email</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtTelefono" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                        </div>
			                    </div>
			                    <!--end::Scroll-->
			                </div>
			                <div class="modal-header" id="kt_modal_add_customer_header">
			                    <!--begin::Modal title-->
			                    <h2 name="TitleModal" class="fw-bolder">Contacto</h2>
			                </div>
			                <div class="modal-body py-10 px-lg-17">
			                    <!--begin::Scroll-->
			                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">

			                        <div class="row g-9 mb-7">
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="required fs-6 fw-bold mb-2">CI</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtNombre" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="required fs-6 fw-bold mb-2">NIT</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" id="kt_inputmask_nit" name="TxtNit" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                        </div>

			                        <div class="row g-9 mb-7">
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="required fs-6 fw-bold mb-2">Nombres</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtSigla" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="fs-6 fw-bold mb-2">Apellidos</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtTelefono" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                        </div>

			                        <div class="row g-9 mb-7">
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="fs-6 fw-bold mb-2">Email</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtCorreo" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="fs-6 fw-bold mb-2">Celular</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtDireccion" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                        </div>

			                        <div class="row g-9 mb-7">
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="required fs-6 fw-bold mb-2">Telefono</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtSigla" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="fs-6 fw-bold mb-2">Direccion</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input class="form-control form-control-solid" placeholder="" name="TxtTelefono" />
			                                <!--end::Input-->
			                            </div>
			                            <!--end::Col-->
			                        </div>

			                        <div class="row g-9 mb-7">
			                            <!--begin::Col-->
			                            <div class="col-md-6 fv-row">
			                                <!--begin::Label-->
			                                <label class="fs-6 fw-bold mb-2">Fecha de Nacimiento</label>
			                                <!--end::Label-->
			                                <!--begin::Input-->
			                                <input type="date" class="form-control form-control-solid" placeholder="" name="TxtCorreo" />
			                                <!--end::Input-->
			                            </div>
			                        </div>
			                    </div>
			                    <!--end::Scroll-->
			                </div>
			                <!--end::Modal body-->
			                <!--begin::Modal footer-->
			                <div class="modal-footer flex-center">
			                    <!--begin::Button-->
			                    <button type="reset" id="kt_modal_add_empresa_cancel" class="btn btn-light me-3">Cancelar</button>
			                    <!--end::Button-->
			                    <!--begin::Button-->
			                    <button type="submit" id="kt_modal_add_empresa_submit" class="btn btn-primary" value="">
			                        <span class="indicator-label">Guardar</span>
			                        <span class="indicator-progress">Espere por favor...
			                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
			                    </button>
			                    <!--end::Button-->
			                </div>
			                <!--end::Modal footer-->
			            </form>
			            <!--end::Form-->
			        </div>
			    </div>
			</div>
		</div>
	</div>
	
@endsection


