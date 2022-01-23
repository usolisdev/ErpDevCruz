@extends('layouts.app')

@section('title')
	<title>Agenda | {{$EmpresaNombre}}</title>
@endsection

@section('links')
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/panel.css') }}"> -->
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}"> -->
@endsection

@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
	    <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    
	<script src="{{ asset('js/tablas.js') }}"></script>
	<script src="{{ asset('js/agenda.js') }}"></script>
@endsection

@section('Pagetitle')
    <h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Agenda</h1>
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-8 my-1">
        <li class="breadcrumb-item text-dark">Empresas</li>
        <li class="breadcrumb-item text-muted">Agenda</li>
        <!-- <li class="breadcrumb-item text-muted">Multimedia</li> -->
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
                <a class="menu-link" href="" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
                    <span class="menu-icon">
                        <i class="las la-key fs-1"></i>
                    </span>
                    <span class="menu-title">Agenda</span>
                    <span class="selected"></span>
                </a>
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
                <a class="menu-link" href="{{ route('listar-permisos') }}" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="">
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
@if (session('sinacceso'))
    <div id="prefix_1329875903354" class="custom-alerts alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        {{ session('sinacceso') }}
    </div>
@endif
<label id="lblidempresa" style="display: none;">{{ $idempresa }}</label>
<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #D6DBDF;background-size: auto 100%; background-image: url(assets/media/misc/taieri.svg)" data-select2-id="select2-data-75-yznj">
    <div class="card-body container-xxl pt-10 pb-8" data-select2-id="select2-data-74-kxv9">
        <div class="row">
            <div class="col-md-12">
            	<div class="card portlet light bordered">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Agenda de {{$EmpresaNombre}}</span>
                        </h3>
                        <div class="card-toolbar">
                            @if($access!="consulta")
                                <a class="btn btn-sm btn-dark" id="btnguardar" data-idus="0">Guardar</a>
                             @endif
                        </div>
                    </div>
                    <div class="card-body form">
                    	<h4 class="link-primary bold font-blue">Datos de la Empresa</h4>
                        <div class="form-body mb-6">
                            <div class="row mt-10">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtnombemp">Nombre:</label>
                                            <input id="txtnombemp" placeholder="nombre de la empresa" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtnitemp">NIT:</label>
                                            <input id="txtnitemp" placeholder="numero de NIT de la Empresa" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtsigla">Sigla:</label>
                                            <input id="txtsigla" placeholder="Sigla de la Empresa" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txttelemp">Telefono:</label>
                                            <input id="txttelemp" placeholder="Telefono de la Empresa" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txtmailemp">Correo:</label>
                                            <input id="txtmailemp" placeholder="Correo de la Empresa" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txtdiremp">Direccion:</label>
                                            <input id="txtdiremp" placeholder="Direccion de la Empresa" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="link-primary bold font-blue">Datos del Representante legal</h4>
                        <label id="perrep" style="display: none;"></label>
                        @if($access!="consulta")
                        <div style="background-color: #D6DBDF;background-size: auto 100%;" class="nav-group d-inline-flex mt-3" data-kt-buttons="true">
                            <a class="btn btn-color-gray-600 btn-active btn-active-primary px-6 py-1 me-2 active rdreplbl" id="editarlblrep">
                                <input style="display: none;" type="radio" name="options" class="toggle rdrep" data-bs-toggle="tab" id="editarrep" value="editar" checked="checked">Editar</a>
                            <a class="btn btn-color-gray-600 btn-active btn-active-primary px-6 py-1 rdreplbl" id="crearlblrep">
                                <input style="display: none;" type="radio" name="options" class="toggle rdrep" data-bs-toggle="tab" id="cambiarrep" value="crear">Cambiar</a>
                        </div>
                        @endif       
                        <div class="form-body mb-6">
                            <div class="row mt-6">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtnomrep">Nombres:</label>
                                            <input id="txtnomrep" placeholder="Nombres del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtaprep">Apellidos:</label>
                                            <input id="txtaprep" placeholder="Apellidos del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtcirep">CI:</label>
                                            <input id="txtcirep" placeholder="CI del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtnitrep">NIT:</label>
                                            <input id="txtnitrep" placeholder="NIT del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtmailrep">E-Mail:</label>
                                            <input id="txtmailrep" placeholder="E-Mail del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txttelrep">Telefono:</label>
                                            <input id="txttelrep" placeholder="Telefono del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtcelrep">Celular:</label>
                                            <input id="txtcelrep" placeholder="Celular del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txtdirrep">Direccion:</label>
                                            <input id="txtdirrep" placeholder="Direccion del Representante Legal" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txtfncrep" >Fecha de Nacimiento:</label>
                                            <input  id="txtfncrep" type="date" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="link-primary bold font-blue">Datos del Contacto de la empresa</h4>
                        <label id="percon" style="display: none;"></label>
                        @if($access!="consulta")
                        <div style="background-color: #D6DBDF;background-size: auto 100%;" class="nav-group  d-inline-flex mt-3" data-kt-buttons="true">
                            <a class="btn btn-color-gray-600 btn-active btn-active-primary px-6 py-1 me-2 active rdconlbl" id="editarlblcon">
                                <input style="display: none;" type="radio" name="options" class="toggle rdrep" data-bs-toggle="tab" id="editarcon" value="editar" checked="checked">Editar</a>
                            <a class="btn btn-color-gray-600 btn-active btn-active-primary px-6 py-1 rdconlbl" id="crearlblcon">
                                <input style="display: none;" type="radio" name="options" class="toggle rdrep" data-bs-toggle="tab" id="cambiarcon" value="crear">Cambiar</a>
                        </div>
                        @endif
                        <div class="form-body mb-6">
                            <div class="row mt-6">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtnomcom">Nombres:</label>
                                            <input id="txtnomcon" placeholder="Nombres del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtapcon">Apellidos:</label>
                                            <input id="txtapcon" placeholder="Apellidos del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtcicon">CI:</label>
                                            <input id="txtcicon" placeholder="CI del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtnitcon">NIT:</label>
                                            <input id="txtnitcon" placeholder="NIT del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtmailcon">E-Mail:</label>
                                            <input id="txtmailcon" placeholder="E-Mail del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txttelcon">Telefono:</label>
                                            <input id="txttelcon" placeholder="Telefono del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="required fs-6 fw-bold form-label mb2" for="txtcelcon">Celular:</label>
                                            <input id="txtcelcon" placeholder="Celular del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txtdircon">Direccion:</label>
                                            <input id="txtdircon" placeholder="Direccion del Contacto" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-7">
                                    <div class="form-group form-md-line-input has-success">
                                        <div class="input-icon">
                                            <label class="fs-6 fw-bold form-label mb2" for="txtfnccon" >Fecha de Nacimiento:</label>
                                            <input id="txtfnccon" type="date" class="form-control form-control-solid"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="float: left;"><span class="campoObligatorio font-red">*</span> Estos Campos son obligatorios</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


