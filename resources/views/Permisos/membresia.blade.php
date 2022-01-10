@extends('layouts.app')

@section('title')
    @if(!empty($EmpresaNombre))
        <title>Membresia | {{$EmpresaNombre}}</title>
    @else
        <title>Membresia</title>
    @endif
@endsection

@section('links')
@endsection

@section('scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/membresia.js') }}"></script>
@endsection

@section('content')
    @if (session('sinacceso'))
        <div id="prefix_1329875903354" class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{ session('sinacceso') }}
        </div>
    @endif
    @if (Auth::user()->TipoUsuario == "1")
        <label id="idempresa" style="display: none;">{{$idempresa}}</label>
        <div class="row">
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
        </div>

        <!-- Modal Agregar - Editar -->
        <div id="modaladdmem" class="modal fade" role="dialog">
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
        </div>
        <!-- Modal advertencia-->
        <div id="modaladvertencia" class="modal fade" role="dialog">
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
        </div>
    @endif
@endsection