@extends('layouts.app')

@section('title')
	<title>Empresas</title>
@endsection

@section('links')
	<!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
@endsection

@section('scripts')
	<!--begin::Javascript-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{ asset('js/empresa.js')}}"></script>
    <!--end::Javascript-->
@endsection

@section('content')

@section('Pagetitle')

<h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Listado de Empresas</h1>
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-bold fs-8 my-1">
    <li class="breadcrumb-item text-dark">Empresas</li>
    {{-- <li class="breadcrumb-item text-muted">Entradas</li>
    <li class="breadcrumb-item text-muted">Multimedia</li> --}}
</ul>
<!--end::Breadcrumb-->
@endsection

@section('MenuPrimary')

<div class="menu-item py-3">
    <a class="menu-link active menu-center" href="" title="Empresas" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
        <span class="menu-icon me-0">
            <i class="las la-home fs-1"></i>
        </span>
    </a>
</div>

{{-- <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3 menu-dropdown">
    <span class="menu-link menu-center" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Pagina">
        <span class="menu-icon me-0">
            <i class="bi bi-layers fs-2"></i>
        </span>
    </span>
    <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4" style="z-index: 105; position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate(100px, 234px);" data-popper-placement="right-start">
        <div class="menu-item">
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1">Contenido Pagina</span>
            </div>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Sectores</span>
            </a>
        </div>
    </div>
</div>

<div class="menu-item py-3">
    <a class="menu-link menu-center" href="" title="Configuracion" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
        <span class="menu-icon me-0">
            <i class="fas fa-cogs fs-1"></i>
        </span>
    </a>
</div> --}}

@endsection

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
                    <input type="text" data-kt-sectores-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Buscar Empresa" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-sectores-table-toolbar="base">

                    <button id="btnAddsector" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_sector">Agregar</button>
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-sectores-table-toolbar="selected">

                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-sectores-table-select="selected_count"></span> Seleccionado
                    </div>

                    <div class="fw-bolder me-5">
                    <button type="button" class="btn btn-danger" data-kt-sector-table-select="delete_selected">Eliminar</button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">

            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_empresas">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_empresas .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-80px">Nombre</th>
                        <th class="min-w-80px">Nit</th>
                        <th class="min-w-50px">Sigla</th>
                        <th class="min-w-50px">Niveles</th>
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
    <div class="modal fade" id="kt_modal_add_sector" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="#" id="kt_modal_add_sector_form" data-kt-redirect="">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_add_customer_header">
                        <!--begin::Modal title-->
                        <h2 name="TitleModal" class="fw-bolder"></h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_modal_add_sector_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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

                            <div class="row g-9 mb-7">
                                <!--begin::Col-->
                                <div class="col-md-5 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-bold mb-2">Nombre</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="" name="TxtNombre" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-5 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-bold mb-2">Titulo</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="" name="TxtTitulo" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                  <!--begin::Col-->
                                  <div class="col-md-2 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-2">Orden</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input id="kt_inputmask_orden" class="form-control form-control-solid" placeholder="" name="TxtOrden" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Texto</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="text" class="form-control form-control-solid" placeholder="" name="TxtTexto" /> --}}
                                <!--end::Input-->
                                <textarea class="form-control form-control-solid mb-8" rows="3" name="TxtTexto"></textarea>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_add_sector_cancel" class="btn btn-light me-3">Cancelar</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_modal_add_sector_submit" class="btn btn-primary" value="">
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
@endsection


