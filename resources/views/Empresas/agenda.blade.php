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

@section('content')
@if (session('sinacceso'))
    <div id="prefix_1329875903354" class="custom-alerts alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        {{ session('sinacceso') }}
    </div>
@endif
<label id="lblidempresa" style="display: none;">{{ $idempresa }}</label>
<div class="row">
    <div class="col-md-12">
    	<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-blue">
                    <span class="caption-subject bold uppercase"> Agenda de {{$EmpresaNombre}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        @if($access!="consulta")
                            <a class="btn green-haze btn-outline btn-circle btn-sm" id="btnguardar" data-idus="0">
                                <i class="fa fa-check"></i>
                                Guardar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="portlet-body form">
            	<h4 class="bold font-blue">Datos de la Empresa</h4>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtnombemp" placeholder="nombre de la empresa" class="form-control"></textarea>
                                    <label for="txtnombemp"><span class="campoObligatorio font-red">*</span> Nombre:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtnitemp" placeholder="numero de NIT de la Empresa" class="form-control"></textarea>
                                    <label for="txtnitemp"><span class="campoObligatorio font-red">*</span> NIT:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtsigla" placeholder="Sigla de la Empresa" class="form-control"></textarea>
                                    <label for="txtsigla"><span class="campoObligatorio font-red">*</span> Sigla:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txttelemp" placeholder="Telefono de la Empresa" class="form-control"></textarea>
                                    <label for="txttelemp">Telefono:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtmailemp" placeholder="Correo de la Empresa" class="form-control"></textarea>
                                    <label for="txtmailemp">Correo:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtdiremp" placeholder="Direccion de la Empresa" class="form-control"></textarea>
                                    <label for="txtdiremp">Direccion:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="bold font-blue">Datos del Representante legal</h4>
                <label id="perrep" style="display: none;"></label>
                @if($access!="consulta")
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <label class="btn btn-transparent green btn-outline btn-circle btn-sm active rdreplbl" id="editarlblrep">
                        <input type="radio" name="options" class="toggle rdrep" id="editarrep" value="editar" checked="checked">Editar</label>

                    <label class="btn btn-transparent green btn-outline btn-circle btn-sm rdreplbl" id="crearlblrep">
                        <input type="radio" name="options" class="toggle rdrep" id="cambiarrep" value="crear">Cambiar</label>
                </div>
                @endif       
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtnomrep" placeholder="Nombres del Representante Legal" class="form-control"></textarea>
                                    <label for="txtnomrep"><span class="campoObligatorio font-red">*</span> Nombres:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtaprep" placeholder="Apellidos del Representante Legal" class="form-control"></textarea>
                                    <label for="txtaprep"><span class="campoObligatorio font-red">*</span> Apellidos:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtcirep" placeholder="CI del Representante Legal" class="form-control"></textarea>
                                    <label for="txtcirep"><span class="campoObligatorio font-red">*</span> CI:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtnitrep" placeholder="NIT del Representante Legal" class="form-control"></textarea>
                                    <label for="txtnitrep"><span class="campoObligatorio font-red">*</span> NIT:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtmailrep" placeholder="E-Mail del Representante Legal" class="form-control"></textarea>
                                    <label for="txtmailrep"><span class="campoObligatorio font-red">*</span> E-Mail:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txttelrep" placeholder="Telefono del Representante Legal" class="form-control"></textarea>
                                    <label for="txttelrep">Telefono:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtcelrep" placeholder="Celular del Representante Legal" class="form-control"></textarea>
                                    <label for="txtcelrep"><span class="campoObligatorio font-red">*</span> Celular:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtdirrep" placeholder="Direccion del Representante Legal" class="form-control"></textarea>
                                    <label for="txtdirrep">Direccion:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <input  id="txtfncrep" type="date" class="form-control" style="margin-top: 5.5%;" />
                                    <label for="txtfncrep" >Fecha de Nacimiento:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="bold font-blue">Datos del Contacto de la empresa</h4>
                <label id="percon" style="display: none;"></label>
                @if($access!="consulta")
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <label class="btn btn-transparent green btn-outline btn-circle btn-sm active rdconlbl" id="editarlblcon">
                        <input type="radio" name="options1" class="toggle rdcon" id="editarcon" value="editar" checked="checked">Editar</label>
                    <label class="btn btn-transparent green btn-outline btn-circle btn-sm rdconlbl" id="crearlblcon">
                        <input type="radio" name="options1" class="toggle rdcon" id="cambiarcon" value="crear">Cambiar</label>
                </div>
                @endif
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtnomcon" placeholder="Nombres del Contacto" class="form-control"></textarea>
                                    <label for="txtnomcom"><span class="campoObligatorio font-red">*</span> Nombres:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtapcon" placeholder="Apellidos del Contacto" class="form-control"></textarea>
                                    <label for="txtapcon"><span class="campoObligatorio font-red">*</span> Apellidos:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtcicon" placeholder="CI del Contacto" class="form-control"></textarea>
                                    <label for="txtcicon"><span class="campoObligatorio font-red">*</span> CI:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtnitcon" placeholder="NIT del Contacto" class="form-control"></textarea>
                                    <label for="txtnitcon"><span class="campoObligatorio font-red">*</span> NIT:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtmailcon" placeholder="E-Mail del Contacto" class="form-control"></textarea>
                                    <label for="txtmailcon"><span class="campoObligatorio font-red">*</span> E-Mail:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txttelcon" placeholder="Telefono del Contacto" class="form-control"></textarea>
                                    <label for="txttelcon">Telefono:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtcelcon" placeholder="Celular del Contacto" class="form-control"></textarea>
                                    <label for="txtcelcon"><span class="campoObligatorio font-red">*</span> Celular:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <textarea id="txtdircon" placeholder="Direccion del Contacto" class="form-control"></textarea>
                                    <label for="txtdircon">Direccion:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-success">
                                <div class="input-icon">
                                    <input  id="txtfnccon" type="date" class="form-control" style="margin-top: 5.5%;" />
                                    <label for="txtfnccon" >Fecha de Nacimiento:</label>
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
@endsection


