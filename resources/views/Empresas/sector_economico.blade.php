@extends('layouts.app')

@section('title')
    <title>Sector Economico | {{$EmpresaNombre}}</title>
@endsection

@section('links')
@endsection

@section('scripts')
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jstree/dist/jstree.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sectoreco.js') }}"></script>
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
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <!-- <i class="fa fa-sticky-note font-green-sharp"></i> -->
                        <span class="caption-subject font-green-sharp bold uppercase">Sector Economico - {{$EmpresaNombre}}</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            @if($access!="consulta")
                                <a class="btn green-haze btn-outline btn-circle btn-sm" id="btnguardar">
                                    <i class="fa fa-check"></i>
                                    Guardar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                        <label id="idsector" style="display: none;">{{$sector}}</label>
                        <div class="form-body">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="title">Fecha Inicio:</label>
                                    @if($fi!=0)
                                    <div class="col-md-5">
                                        <input id="txtfi" type="text" class="form-control input-medium" placeholder="Fecha inicio" disabled="disabled" value="{{$fi}}">
                                    </div>
                                    @else
                                    <div class="col-md-5">
                                        <input id="txtfi" type="text" class="form-control input-medium" placeholder="Fecha inicio" disabled="disabled">
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="title">Año:</label>
                                    <div class="col-md-5">
                                        <input id="txtyear" type="text" class="form-control input-medium" placeholder="Año" disabled="disabled" value="{{$year}}"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="title">Mes de Cierre:</label>
                                    <div class="col-md-5">
                                        <select id="combocierre" class="form-control input-medium">
                                            <!-- <option value="1">Enero</option>
                                            <option value="2">Febrero</option> -->
                                            <option value="3">Marzo</option>
                                            <!-- <option value="4">Abril</option>
                                            <option value="5">Mayo</option> -->
                                            <option value="6">Junio</option>
                                            <!-- <option value="7">Julio</option>
                                            <option value="8">Agosto</option> -->
                                            <option value="9">Septiembre</option>
                                            <!-- <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option> -->
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="title">Desde:</label>
                                    <div class="col-md-5">
                                        <input id="txtffi" type="text" class="form-control input-medium" placeholder="Desde" disabled="disabled"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="title">Hasta:</label>
                                    <div class="col-md-5">
                                        <input id="txtff" type="text" class="form-control input-medium" placeholder="Hasta" disabled="disabled"> </div>
                                </div>
                                <div class="form-group">
                                    <!-- <label class="col-md-3 control-label" for="title">Sectores:</label> -->
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-6">
                                        <div id="optsectores" class="btn-group btn-group-devided" data-toggle="buttons">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                            
                </div>
            </div>
        </div>
    </div>
@endsection