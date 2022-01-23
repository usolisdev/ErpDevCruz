@extends('layouts.app')

@section('title')
	<title>Dosificacion | {{$PfacNombre . ' - ' .$EmpresaNombre}}</title>
@endsection

@section('links')
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/panel.css') }}"> -->
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}"> -->
	<style type="text/css">
		select {
			width: 100%;
			padding: 6px 12px;
		}
		td{
			word-wrap: break-word;
		}
	</style>
@endsection

@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
	    <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    
	{{--<script src="{{ asset('js/tablas.js') }}"></script>--}}
	<script src="{{ asset('js/dosificacionsuc.js') }}"></script>
@endsection

@section('content')
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

	<div class="row">
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-dark">
                        <i class="icon-bar-chart font-dark"></i>
                        <span class="caption-subject bold uppercase">Dosificacion de {{$PfacNombre . ' - ' .$EmpresaNombre}}</span>
                    </div>
                    <div class="actions">
						<button type="button" class="btn dark btn-outline" id="idrtexcel">Excel</button>
						<button type="button" class="btn green btn-outline" onclick="javascript:window.open('http://localhost:9595/sucursales/repdosificacion/{{$idempresa}}/{{$idsucursal}}/{{$idpfacturacionl}}','','width=900,height=500,left=50,top=50');">PDF</button>

					</div>
				</div>
				<div class="portlet-body">
					<div class="table-toolbar">
						<div class="row">
							@if($access=="total")
								<div class="col-md-2">
									<button type="button" class="btn blue btn-circle" id="btn-adddos" data-toggle="modal" data-target="#modaladddos">Agregar Dosificacion</button>
								</div>
							@endif
					        <!-- <div class="col-md-2">
								<button type="button" class="btn blue btn-circle" id="btn-repem"onclick="javascript: window.open('http://localhost:9595/ReporteFinal/Gestion.php','','width=900,height=500,left=50,top=50');">Reporte Gestion</button>
							</div> -->
						</div>
					</div>
					<div class="dataTables_wrapper no-footer">
						<div id="tabla" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" style="display: none;" >
							<table id="tabladosificacion" class="table table-striped table-bordered table-hover order-column display" style="width: 100% !important;">
								<thead>
									<tr>
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
	<!-- Modal Agregar - Editar -->
		<div id="modaladddos" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<h3 class="modal-title" id="tituloModaldos"> Añadir Dosificacion</h3>
					</div>
					<div class="modal-body">
							<form action="" method="post" id="formulario">
								<div class="row">

									<div class="col-md-12"> 							

										<input type="hidden" name="_token" value="{{ csrf_token() }}">

										<div class="row">
											<div class="col-md-6 col-xs-12">	
												<div class="form-group">
													<label for="txtntramite">N° de Tramite: <span class="campoObligatorio">*</span></label>
													<input class="form-control" type="text" id="txtntramite"/>
												</div>
											</div>

											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<label for="txtnauth">N° de Autorizacion: <span class="campoObligatorio">*</span></label>
													<input class="form-control" type="text" id="txtnauth"/>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<label for="txtnfac">Cantidad de Facturas:</label>
													<input class="form-control" type="text" id="txtnfac"/>
												</div>
											</div>

											<div class="col-md-6 ">
												<div id="divcomes" class="form-group">
													<label for="txtfle">Fecha Limite de Emision: <span class="campoObligatorio">*</span></label>
													<input class="form-control" type="date" id="txtfle"/>
												</div>
											</div>
										</div>

										<div class="row">
											{{--<div class="col-md-6 col-xs-12">--}}
												{{--<div class="form-group">--}}
													{{--<label for="txtley">Leyenda: <span class="campoObligatorio">*</span></label>--}}
													{{--<input class="form-control" type="text" id="txtley"/>--}}
												{{--</div>--}}
											{{--</div>--}}

											<div class="col-md-6 ">
												<div class="form-group" >
													<label for="comboley">Leyenda:</label>
													<select id="comboley">
														@if (!empty($ley))
															@foreach($ley as $s)
																<option class="leyenda" value="{{$s->id}}">{{ $s->ley }}</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>

											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<label for="txttday">Tiempo de Emision en dias: <span class="campoObligatorio">*</span></label>
													<input class="form-control" type="text" id="txttday"/>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 ">
												<div class="form-group" >
													<label for="combosisfac">sistema de Facturacion:</label>
													<select id="combosisfac">
														@if (!empty($sistemafac))
															@foreach($sistemafac as $s)
																<option class="sisfac" value="{{$s->id}}">{{ $s->sistemafacturacion }}</option>	
															@endforeach
											            @endif
													</select>
												</div>
											</div>
											<div class="col-md-6 col-xs-12" id="idtxtclave">
												<div class="form-group">
													<label for="txtclave">Clave:</label>
													<input class="form-control" type="text" id="txtclave"/>
												</div>
											</div>
											{{--<div class="col-md-6 ">--}}
												{{--<div class="form-group" >--}}
													{{--<label for="combotifac">Tipo de Facturacion:</label>--}}
													{{--<select id="combotifac">--}}
														{{--@if (!empty($tipofac))--}}
															{{--@foreach($tipofac as $t)--}}
																{{--<option class="tifac" value="{{$t->id}}">{{ $t->tipofacturacion }}</option>	--}}
															{{--@endforeach--}}
											            {{--@endif--}}
													{{--</select>--}}
												{{--</div>--}}
											{{--</div>--}}
										</div>

										<div class="row">
											<div class="col-md-6 ">
												<div class="form-group" >
													<label for="combohab">Habilitado:</label>
													<select id="combohab">
														<option value="0">Deshabilitado</option>
														<option value="1">Habilitado</option>
													</select>
												</div>
											</div>
											{{--<div class="col-md-6 ">--}}
												{{--<div class="form-group" >--}}
													{{--<label for="combosm">Marca Serie:</label>--}}
													{{--<select id="combosm">--}}
														{{--@if (!empty($seriemarca))--}}
															{{--@foreach($seriemarca as $s)--}}
																{{--<option class="sm" value="{{$s->id}}">{{ $s->seriemarca }}</option>	--}}
															{{--@endforeach--}}
											            {{--@endif--}}
													{{--</select>--}}
												{{--</div>--}}
											{{--</div>--}}

										</div>

										{{--<div class="row">--}}

										{{--</div>--}}

									</div>
								</div>

							</form>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-info" id="btnAceptaradddos">Aceptar</button>
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
