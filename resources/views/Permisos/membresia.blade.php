@extends('layouts.app')

@section('title')
    @if(!empty($EmpresaNombre))
        <title>Membresia | {{$EmpresaNombre}}</title>
    @else
        <title>Membresia</title>
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
    <!-- importo la libreria moments -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.0/moment.min.js"></script>
    <!-- importo todos los idiomas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.0/moment-with-locales.min.js"></script> --}}

    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/jstree/jstree.bundle.js')}}"></script>
    <script src="{{ asset('js/membresia.js') }}"></script>
    <!--end::Javascript-->
@endsection

@section('Pagetitle')

    <h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Listado de Membresias</h1>
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-8 my-1">
        <li class="breadcrumb-item text-muted">Gestion</li>
        <li class="breadcrumb-item text-dark">Membresias</li>
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

    @if ($idempresa != 0)
        <div class="menu-item py-3">
            <a class="menu-link menu-center" href="{{ route('gotomenu', $idempresa) }}" title="DashBoard" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                <span class="menu-icon me-0">
                    <i class="fas fa-chart-line fs-1"></i>
                </span>
            </a>
        </div>
    @endif

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

            @if($idempresa != 0)
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
                    <a class="menu-link active" href="{{ route('lmembresias', $idempresa) }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                        <span class="menu-icon">
                            <i class="las la-ticket-alt fs-1"></i>
                        </span>
                        <span class="menu-title">Membresias</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('listar-permisos', $idempresa) }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                        <span class="menu-icon">
                            <i class="las la-key fs-1"></i>
                        </span>
                        <span class="menu-title">Accesos</span>
                    </a>
                </div>
            @else
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('usuarios') }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                        <span class="menu-icon">
                            <i class="las la-users fs-1"></i>
                        </span>
                        <span class="menu-title">Usuarios</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link active" href="{{ route('lmembresias') }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                        <span class="menu-icon">
                            <i class="las la-ticket-alt fs-1"></i>
                        </span>
                        <span class="menu-title">Membresias</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('listar-permisos') }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                        <span class="menu-icon">
                            <i class="las la-key fs-1"></i>
                        </span>
                        <span class="menu-title">Accesos</span>
                    </a>
                </div>
            @endif
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
    @if (Auth::user()->TipoUsuario == "1")

        <input name="idempresa" value="{{$idempresa}}" hidden/>

        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Container-->
            <div class="container-xxl" id="kt_content_container">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
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
                                <input type="text" data-kt-membresia-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Buscar Membresia" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-membresias-table-toolbar="base">

                                <button id="btnAddmembresia" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_membresia">Agregar</button>
                                <!--end::Add customer-->
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-membresias-table-toolbar="selected">

                                <div class="fw-bolder me-5">
                                    <span class="me-2" data-kt-membresias-table-select="selected_count"></span> Seleccionado
                                </div>

                                <div class="fw-bolder me-5">
                                <button type="button" class="btn btn-warning" data-kt-membresias-table-select="delete_selected">Cancelar</button>
                            </div>
                            <!--end::Group actions-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">

                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_membresias">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    {{-- <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_membresias .form-check-input" value="1" />
                                        </div>
                                    </th> --}}
                                    <th class="min-w-80px">Empresa</th>
                                    <th class="min-w-80px">Estado</th>
                                    <th class="min-w-50px">Fecha Inicio</th>
                                    <th class="min-w-50px">Fecha Fin</th>
                                    <th class="text-end min-w-70px">Acciones</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">

                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Modals-->
                <!--begin::Modal - Customers - Add-->
                <div class="modal fade" id="kt_modal_add_membresia" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Form-->
                            <form class="form" action="#" id="kt_modal_add_membresia_form" data-kt-redirect="">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_membresia_header">
                                    <!--begin::Modal title-->
                                    <h2 name="TitleModal" class="fw-bolder"></h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div id="kt_modal_add_membresia_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body py-10 px-lg-17">
                                    <!--begin::Scroll-->
                                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">

                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Empresa</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid" data-control="select2" id="kt_select_ComboEmpresa" name="ComboEmpresa" data-hide-search="true">
                                                @if (!empty($empresas))
                                                    @foreach($empresas as $e)
                                                        <option value="{{$e->id}}">{{ $e->Nombre }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2 required">Fecha</label>
                                            <input class="form-control form-control-solid" placeholder="" id="kt_date_range" name="DateRange"/>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Scroll-->
                                </div>
                                <!--end::Modal body-->
                                <!--begin::Modal footer-->
                                <div class="modal-footer flex-center">
                                    <!--begin::Button-->
                                    <button type="reset" id="kt_modal_add_membresia_cancel" class="btn btn-light me-3">Cancelar</button>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="kt_modal_add_membresia_submit" class="btn btn-primary" value="">
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
                <!--end::Modal - Customers - Add-->
                <!--begin::Modal - Adjust Balance-->
                <!--end::Modal - New Card-->
                <!--end::Modals-->
            </div>
            <!--end::Container-->
        </div>

        {{-- <label id="idempresa" style="display: none;">{{$idempresa}}</label> --}}
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-users font-dark"></i>
                            <span class="caption-subject bold uppercase"> Membresias</span>
                        </div>
                        <div class="actions">
                            <button type="button" class="btn dark btn-outline" id="idrtexcel">Excel</button>
                            @if($idempresa!=0)
                                <button type="button" class="btn green btn-outline" onclick="javascript:window.open('http://localhost:9595/seguridadmem/repmemb/'+{{$idempresa}},'','width=900,height=500,left=50,top=50');">PDF</button>
                            @else
                                <button type="button" class="btn green btn-outline" onclick="javascript:window.open('http://localhost:9595/seguridadmem/repmemb','','width=900,height=500,left=50,top=50');">PDF</button>
                            @endif
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="button" class="btn blue btn-circle" id="btn-addmem" data-toggle="modal" data-target="#modaladdmem">Agregar Membresia</button>
                                </div>
                                <!-- <div class="col-md-2">
                                    <button type="button" class="btn blue btn-circle" id="btn-repem" onclick="javascript:window.open('http://localhost:9595/ReporteFinal/index.php','','width=900,height=500,left=50,top=50');">Reporte Usuarios</button>
                                </div> -->
                            </div>
                        </div>
                        <div class="dataTables_wrapper no-footer">
                            <div id="tabla" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" style="display: none;" >
                                <table id="tablamembresias" class="table table-striped table-bordered table-hover display" >
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Estado</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
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
        </div> --}}

        <!-- Modal Agregar - Editar -->
        {{-- <div id="modaladdmem" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h3 class="modal-title" id="tituloModalmem"> Agregar Membresia</h3>
                    </div>

                    <div class="modal-body">
                            <form action="" method="post" id="formulario">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <label for="comboenter">Empresa:</label>
                                                <select class="form-control" id="comboenter">
                                                    @if (!empty($empresas))
                                                        @foreach($empresas as $e)
                                                            <option value="{{$e->id}}">{{ $e->Nombre }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <!-- <div class="col-md-6 ">
                                                <label for="comboenter">Estado:</label>
                                                <select class="form-control" id="comboenter">
                                                    <option value="1">habilitado</option>
                                                    <option value="0">Cancelada</option>
                                                </select>
                                            </div> -->
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="txtfecini">Fecha Inicio: <span class="campoObligatorio">*</span></label>
                                                    <input class="form-control" type="date" id="txtfecini" name="txtfecini" />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="txtfecfin">Fecha Fin:  <span class="campoObligatorio">*</span></label>
                                                    <input class="form-control" type="date" id="txtfecfin" name="txtfecfin" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="btnAceptaraddmem">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>

            </div>
        </div> --}}
        <!-- Modal advertencia-->
        {{-- <div id="modaladvertencia" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="tituloModal">Advertencia !!!</h4>
                    </div>

                    <div class="modal-body">
                        <p id="mensajeadver">¿Esta Seguro de Querer Eliminar este Registro?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="btnacepadv">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btndecliadv">Cancelar</button>
                    </div>
                </div>

            </div>
        </div> --}}
    @endif
@endsection
