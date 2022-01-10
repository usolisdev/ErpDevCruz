@extends('layouts.app')

@section('title')
    <title>Modulos | {{$EmpresaNombre}}</title>
@endsection

@section('links')
    <link href="{{ asset('assets/global/plugins/jstree/dist/themes/default/style.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jstree/dist/jstree.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modulos.js') }}"></script>
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
                        <i class="fa fa-sticky-note font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Modulos {{$EmpresaNombre}}</span>
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
                <div class="portlet-body">
                    <div id="tree_2" class="tree-demo jstree jstree-2 jstree-default jstree-checkbox-selection" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_8" aria-busy="false">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection