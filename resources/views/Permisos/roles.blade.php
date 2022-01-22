@extends('layouts.app')

@section('title')
    @if(!empty($EmpresaNombre))
    <title>Permisos | {{$EmpresaNombre}}</title>
    @else
    <title>permisos</title>
    @endif
@endsection

@section('links')

    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/jstree/jstree.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->

@endsection

@section('scripts')

    <!--begin::Javascript-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/jstree/jstree.bundle.js')}}"></script>
    <script src="{{ asset('js/roles.js') }}"></script>
    <!--end::Javascript-->

@endsection

@section('Pagetitle')

    <h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Permisos de Acceso</h1>
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-8 my-1">
        <li class="breadcrumb-item text-muted">Gestion</li>
        <li class="breadcrumb-item text-dark">Accesos</li>
        {{-- <li class="breadcrumb-item text-muted">Entradas</li>
        <li class="breadcrumb-item text-muted">Multimedia</li> --}}
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
        <span class="menu-link active menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Gestion">
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
            <div class="menu-item">
                <a class="menu-link" href="" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
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
                <a class="menu-link active" href="{{ route('listar-permisos') }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                    <span class="menu-icon">
                        <i class="las la-key fs-1"></i>
                    </span>
                    <span class="menu-title">Accesos</span>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-3" style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('{{asset('assets/media/illustrations/sketchy-1/4.png')}}')">
                <!--begin::Card header-->
                <div class="card-header pt-10">
                    <div class="d-flex align-items-center">
                        <!--begin::Icon-->
                        <div class="symbol symbol-circle me-5">
                            <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs020.svg-->
                                <span class="svg-icon svg-icon-2x svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M17.302 11.35L12.002 20.55H21.202C21.802 20.55 22.202 19.85 21.902 19.35L17.302 11.35Z" fill="black"></path>
                                        <path opacity="0.3" d="M12.002 20.55H2.802C2.202 20.55 1.80202 19.85 2.10202 19.35L6.70203 11.45L12.002 20.55ZM11.302 3.45L6.70203 11.35H17.302L12.702 3.45C12.402 2.85 11.602 2.85 11.302 3.45Z" fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Title-->
                        <div class="d-flex flex-column">

                             <!--begin::Card title-->
                             <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-usuarios-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Buscar Usuario" />
                                </div>
                                <!--end::Search-->

                                @if($access!="consulta")
                                   <!--begin::Button-->
                                    <button type="" id="kt_save_config_submit" class="btn btn-primary ms-10" value="">
                                        <span class="indicator-label">Guardar Configuracion</span>
                                        <span class="indicator-progress">Espere por favor...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                @endif

                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pb-0">

                    <!--begin::Navs-->
                    <!--begin::Navs-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card body-->

            <!--begin::Card-->
            <div class="card mb-4">
                <!--begin::Card header-->

                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">

                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_usuarios">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-80px">Usuario</th>
                                <th class="min-w-80px">Nombre</th>
                                <th class="min-w-50px">Apellido</th>
                                <th class="min-w-50px">Email</th>
                                <th class="min-w-50px">Empresa</th>
                                <th class="text-end min-w-70px">Acciones</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @if (!empty($usuarios))
                                @foreach($usuarios as $u)
                                    <tr id="{{$u->id}}">
                                        <td >{{$u->name}}</td>
                                        <td >{{$u->nombre}}</td>
                                        <td >{{$u->apellido}}</td>
                                        <td >{{$u->email}}</td>
                                        <td >
                                            @foreach($empresas as $e)
                                                @if($e->id == $u->idempresa)
                                                    {{$e->Nombre}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a data-kt-action="usuario_select" class="boton-op btn-select" data-idus="{{$u->id}}" style="cursor: hand;cursor:pointer;">
                                                <span class="fa fa-check"></span>
                                                Seleccionar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <!--begin::Card-->
            <div class="row g-5">

                <!-- Roles -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Accesos Predeterminados</h3>
                        </div>
                        <div class="card-body p-0">

                            <ul class="nav nav-tabs nav-pills flex-row border-0 me-5 mb-3 mb-md-1 mt-2 ms-4 fs-6">
                                <li class="nav-item me-2 mb-md-2" id="rcustomer" data-kt-action="Acceso_select">
                                    <a class="nav-link active btn btn-flex btn-light-danger px-9" data-bs-toggle="tab">
                                        <i class="bi bi-ui-checks fs-2"></i>
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="fs-4">Personalizado</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item me-2 mb-md-2" id="radmin" data-kt-action="Acceso_select">
                                    <a class="nav-link btn btn-flex btn-light-warning px-9" data-bs-toggle="tab">
                                        <i class="las la-user-tie fs-1"></i>
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="fs-4">Administrador</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item me-2 mb-md-2" id="rvendedor" data-kt-action="Acceso_select">
                                    <a class="nav-link btn btn-flex btn-light-success px-9" data-bs-toggle="tab">
                                        <i class="las la-cash-register fs-1"></i>
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="fs-4">Vendedor</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

                <!-- configuracion -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Configuracion</h3>
                            <div class="card-toolbar">

                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm1" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm1" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_configuracion"></div>
                        </div>
                    </div>
                </div>

                <!-- mi empresa -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Mi Empresa</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm2" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm2" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_miempresa"></div>
                        </div>
                    </div>
                </div>

                <!-- contabilidad -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Contabilidad</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm3" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm3" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_contabilidad"></div>
                        </div>
                    </div>
                </div>

                <!-- compras -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Compras</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm4" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm4" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_compras"></div>
                        </div>
                    </div>
                </div>

                <!-- ventas -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Ventas</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm5" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm5" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_ventas"></div>
                        </div>
                    </div>
                </div>

                <!-- RRHH -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Recursos Humanos</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm6" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm6" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_rrhh"></div>
                        </div>
                    </div>
                </div>

                <!-- CRM -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Customer Relation Managment (CRM)</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm7" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm7" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_crm"></div>
                        </div>
                    </div>
                </div>

                <!-- activos fijos -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Activos Fijos</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm8" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm8" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_activos"></div>
                        </div>
                    </div>
                </div>

                <!-- Produccion -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Produccion</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 me-n7 mb-3 mb-md-0 mt-0 fs-6">
                                    <li class="nav-item me-2 mb-md-2" id="rsm9" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Seleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item me-2 mb-md-2" id="rdm9" data-kt-action="Modulo_select">
                                        <a href="#" class="btn btn-icon btn-light-danger me-1" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Deseleccionar todo">
                                            <i class="bi bi-ui-checks fs-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0 me-5 mb-3 mb-md-1 mt-2 ms-4">
                            <div id="tree_produccion"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

@endsection
