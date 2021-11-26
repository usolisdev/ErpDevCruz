@extends('layouts.app')

@section('title')
	<title>Sucursales | {{$EmpresaNombre}}</title>
@endsection

@section('links')
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/panel.css') }}"> -->
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}"> -->
	
@endsection

@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
	    <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    
	<script src="{{ asset('js/tablas.js') }}"></script>
	<script src="{{ asset('js/sucursal.js') }}"></script>
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
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-dark">
                        <i class="icon-bar-chart font-dark"></i>
                        <span class="caption-subject bold uppercase">Sucursales de {{$EmpresaNombre}}</span>
                    </div>
                    <div class="actions">
						<button type="button" class="btn dark btn-outline" id="idrtexcel">Excel</button>
						<button type="button" class="btn green btn-outline" onclick="javascript:window.open('http://localhost:9595/sucursales/repsucursal/{{$idempresa}}','','width=900,height=500,left=50,top=50');">PDF</button>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-toolbar">
						<div class="row">
							@if($access=="total")
								<div class="col-md-2">
									<button type="button" class="btn blue btn-circle" id="btn-addsuc" data-toggle="modal" data-target="#modaladdsuc">Agregar Sucursal</button>
								</div>
							@endif
						</div>
					</div>
					<div class="dataTables_wrapper no-footer">
						<div id="tabla" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" style="display: none;" >
							<table id="tablasucursales" class="table table-striped table-bordered table-hover display">
								<thead>
									<tr>
										<th>Alias</th>
										<th>Direccion</th>
										<th>Contacto</th>
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
		<div id="modaladdsuc" class="modal fade" role="dialog">
			<div class="modal-dialog">
				
				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<h3 class="modal-title" id="tituloModalsuc"> Crear Sucursal</h3>
					</div>

					<div class="modal-body">
						<div class="row">
							<div class="col-md-12"> 							
								<div class="row">
									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtalias">Alias de la Sucursal: <span class="campoObligatorio">*</span></label>
											<input class="form-control" type="text" id="txtalias"/>
										</div>
									</div>

									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label for="txtdirsuc">Direccion: <span class="campoObligatorio">*</span></label>
											<input class="form-control" type="text" id="txtdirsuc"/>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label for="txttelsuc">Telefono: <span class="campoObligatorio">*</span></label>
											<input class="form-control" type="text" id="txttelsuc" />
										</div>
									</div>

									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label for="txtmailsuc">Email: <span class="campoObligatorio">*</span></label>
											<input class="form-control" type="text" id="txtmailsuc"/>
										</div>
									</div>
								</div>

								<label id="personaoc" style="display: none;"></label>
								<h4>Contacto</h4>

								<div class="col-md-12" id="optionscon" style="display: none;">
									<div class="row">
										<div class="col-md-6 col-xs-12">
											<div class="btn-group btn-group-devided" data-toggle="buttons">
								                <label class="btn btn-transparent green btn-outline btn-circle btn-sm active rdconlbl" id="editarlblcon">
								                    <input type="radio" name="optioncon" class="toggle rdcon" id="editarcon" value="editar" checked="checked">Editar</label>

								                <label class="btn btn-transparent green btn-outline btn-circle btn-sm rdconlbl" id="crearlblcon">
								                    <input type="radio" name="optioncon" class="toggle rdcon" id="cambiarcon" value="crear">Cambiar</label>
								            </div>
								        </div>
							        </div>
								</div>
								<br/>
								<br/>

								<div class="row">
									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtci">CI: <span class="campoObligatorio">*</span></label>
											<input class="form-control" type="text" id="txtci" name="txtci"/>
										</div>
									</div>

									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtnit">NIT: <span class="campoObligatorio">*</span></label>
											<input class="form-control" type="text" id="txtnit" name="txtnit"/>
										</div>
									</div>
								</div>	

								<div class="row">
									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtnombres">Nombres:</label>
											<input class="form-control" type="text" id="txtnombres" name="txtnombres"/>
										</div>
									</div>

									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtapellidos">Apellidos:</label>
											<input class="form-control" type="text" id="txtapellidos" name="txtapellidos" />
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtmail">Email:</label>
											<input class="form-control" type="text" id="txtmail" name="txtmail"/>
										</div>
									</div>

									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtcel">Celular:</label>
											<input class="form-control" type="text" id="txtcel" name="txtcel" />
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txttel">Telefono:</label>
											<input class="form-control" type="text" id="txttel" name="txttel"/>
										</div>
									</div>

									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtdir">Direccion: </label>
											<input class="form-control" type="text" id="txtdir" name="txtdir" />
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6 col-xs-12">	
										<div class="form-group">
											<label for="txtfecnac">Fecha de Nacimiento:</label>
											<input class="form-control" type="date" id="txtfecnac" name="txtfecnac"/>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-info" id="btnAceptaraddsuc">Aceptar</button>
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
						<h4 class="modal-title" id="tituloModal">Advertencia</h4>
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
@endsection


