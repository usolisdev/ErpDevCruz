$(document).ready(function () {
/************Runner************/
    var _table;
    var access = $("#access").text();
    marcadores("modconfiguracion","viewparametros","view2dosificacion");
    ObtenerDosificaciones();
    cargarvista();
/************Eventos************/
    $('#btnAceptaradddos').on('click',function(){
        guardareditardosificacion();
    });
    $("#btnacepadv").click(function(){
         var iddos=$(this).attr('data-iddosificacion');
        eliminarDosificacion(iddos);
    });

    $("#idrtexcel").on('click',function(){
        var idem = $('#lblidempresa').text();
        var idsuc = $('#lblidsucursal').text();
        var idpfacturacion = $('#lblidpfacturacion').text();
        location.href=urlBase+"sucursales/repdosifiexcel/"+idem+"/"+idsuc+"/"+idpfacturacion+"";
    });

    $("#btn-adddos").on('click',function(){
        $("#txtntramite").val("");
        $("#txtnauth").val("");
        $("#txtnfac").val("");
        $("#txtfle").val("");
        $("#txtley").val("");
        $("#txttday").val("");
        var idprin1 = $(".sisfac:first").val().trim();
        var idprin2 = $(".tifac:first").val().trim();
        var idprin3 = $(".sm:first").val().trim();
        $("#combosisfac").val(parseInt(idprin1));
        $("#combotifac").val(parseInt(idprin2));
        $("#combosm").val(parseInt(idprin3));
        $("#txtclave").val("");
        $("#combohab").val(0);
        $("#tituloModaldos").text("Agregar Dosificacion");
        $("#btnAceptaradddos").removeAttr("data-iddosificacion");
    });
/************funciones************/
    function marcadores(modulo,vista,vista2) {
        $("#"+modulo+"").addClass("active");
        if(vista!=0){
            if(vista2!=0){
                $("#"+vista+"").addClass("active");
            }else{
                $("#"+vista+"").addClass("active");
                $("#"+vista+"").addClass("open");
            }
        }
        if(vista2!=0){
            $("#"+vista2+"").addClass("active");
            $("#"+vista2+"").addClass("open");
        }
    }
    function eliminarDosificacion(iddos){
        var urlfinal = urlBase + "sucursales/eliminar-dosificacion";
        var data={
            IdDosif: iddos
        };
        var dataValue = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: urlfinal,
            contentType: "application/json; charset=utf-8",
            data: dataValue,
            dataType: "json",
            success: function (res) {
                if(res.tipoMensaje=="success"){
                    toastr.success(res.mensaje);
                    //*****atributos cambiados*****
                    // $("tr[id='"+res.IdGestion+"']").children().children()[0].style.pointerEvents ="none";
                    // $("tr[id='"+res.IdGestion+"']").children().children()[1].style.pointerEvents ="none";
                    // $("tr[id='"+res.IdGestion+"']").children().children()[2].style.pointerEvents ="none";
                    // $("tr[id='"+res.IdGestion+"']").css("opacity","0.5");
                    var IdDosif = "#" + res.IdDosificacion;
                    _table.row(IdDosif)
                            .remove()
                            .draw();
                    $("#modaladvertencia").modal("hide");
                    tooltipnow();
                }else{
                    toastr.error(res.mensaje,'Error', {timeOut: 3000});
                }
            },
            error: function(res){
                toastr.error(res,'Error', {timeOut: 3000});        
            }
        });
    }
    function ObtenerDosificaciones() {
        var data = {
            IdSucursal:$('#lblidsucursal').text(),
            IdPfacturacion:$('#lblidpfacturacion').text()
        };
        data = JSON.stringify(data);
        //Obtener Dosificaciones
        $.ajax({
            type: 'POST',
            url: urlBase + 'sucursales/listadedosificacion',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                if (res.tipoMensaje=="success") {
                    var Dosificaciones = res.Dosificaciones;
                    var Sistemafac = res.Sistemafac;
                    // var Tipofac = res.Tipofac;
                    // var Seriemarca = res.Seriemarca;
                    //formatear datos
                    for(var i=0;i<Dosificaciones.length;i++){
                        //sistema facturacion
                            var idsisfac = Dosificaciones[i].idsistemafacturacion;
                            for(var j=0;j<Sistemafac.length;j++){
                                if(Sistemafac[j].id==idsisfac){
                                    Dosificaciones[i].idsistemafacturacion = Sistemafac[j].sistemafacturacion;
                                }
                            }
                        //tipo facturacion
                        //     var idtifac = Dosificaciones[i].idtipofacturacion;
                        //     for(var j=0;j<Tipofac.length;j++){
                        //         if(Tipofac[j].id==idtifac){
                        //             Dosificaciones[i].idtipofacturacion = Tipofac[j].tipofacturacion;
                        //         }
                        //     }
                        //serie marca
                        //     var idsm = Dosificaciones[i].idmarcaserie;
                        //     for(var j=0;j<Seriemarca.length;j++){
                        //         if(Seriemarca[j].id==idsm){
                        //             Dosificaciones[i].idmarcaserie = Seriemarca[j].seriemarca;
                        //         }
                        //     }
                    }
                    if(access=="total"){
                        _table = $('#tabladosificacion').DataTable({
                            "language": {
                                "paginate":{
                                           previous: '‹',
                                           next:     '›'
                                            },
                                "searchPanes": {
                                         collapse: {
                                               0: '<i class="las la-search"></i>'
                                         }
                                    },
                                "search": "",
                                "searchPlaceholder": "Buscar",
                                "aria": {
                                    "sortAscending": ": activar para ordenar la columna de manera ascendente",
                                    "sortDescending": ": activar para ordenar la columna de manera descendente"
                                },
                                "emptyTable": "No hay datos disponibles",
                                "info": "Mostrando de _START_ a _END_ de _TOTAL_ items",
                                "infoEmpty": "no hay datos disponibles",
                                "infoFiltered": "(filtrando desde _MAX_ total de registros)",
                                "lengthMenu": "_MENU_ items",
                                "search": "",
                                "zeroRecords": "Sin Coincidencias"
                            },
                            scrollY:        150,
                            bLengthChange: false,
                            deferRender:    true,
                            // scroller:       true,
                            "scrollX": true,
                            fixedHeader: true,
                            scrollCollapse: true,
                            stateSave:      true,
                            "lengthMenu": [
                                [10, 15, 20, -1],
                                [10, 15, 20, "All"] 
                            ],
                            "pageLength": 10,
        
                            "data": Dosificaciones,
                            "rowId": "id",
                            //campos del DTO 
                            "columns": [
                                { "data": "ntramite" },
                                { "data": "nautorizacion" },
                                { "data": "stockfacturas" },
                                {
                                    "data": "nombrecompleto",
                                    "render": function(d, t, r) {
                                                var student = r;
                                                var returnString = "";
                                                // idsistemafacturacion idtipofacturacion idmarcaserie
                                                if (student.hasOwnProperty('idsistemafacturacion')) {
                                                    returnString = student.idsistemafacturacion;
                                                    // if (student.hasOwnProperty('idtipofacturacion')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idtipofacturacion;
                                                    //     } else {
                                                    //         returnString = student.idtipofacturacion;
                                                    //     }
                                                    // }
                                                    // if (student.hasOwnProperty('idmarcaserie')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idmarcaserie;
                                                    //     } else {
                                                    //         returnString = student.idmarcaserie;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                }else{
                                                    // if (student.hasOwnProperty('idtipofacturacion')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idtipofacturacion;
                                                    //     } else {
                                                    //         returnString = student.idtipofacturacion;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                    // if (student.hasOwnProperty('idmarcaserie')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idmarcaserie;
                                                    //     } else {
                                                    //         returnString = student.idmarcaserie;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                    returnString = "Sin Datos";
                                                }
                                                
                                                return returnString;
                                            } 
                                },
                                { "data": "fechalimiteemision" },
                                {
                                  "orderable": false,
                                  "data": null,
                                  "defaultContent": 
                                   ` 
                                   <a style="float: right;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-eliminardos" title="Eliminar">
                                        <span class="svg-icon svg-icon-3">
                                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                              <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                              <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                              <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                          </svg>
                                        </span>
                                    </a>
                                    <a style="float: right;" title="Editar" data-kt-action="empresa_edit" data-bs-toggle="modal" data-bs-target="#kt_modal_add_empresa" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-editdos">
                                      <span class="svg-icon svg-icon-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                              <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                              <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                          </svg>
                                      </span>
                                    </a>
                                    `
                                }
                            ],
                            "order": [[ 0, "asc" ]]
                        });
                    }
                    if(access=="parcial"){
                        _table = $('#tabladosificacion').DataTable({
                            "language": {
                                "aria": {
                                    "sortAscending": ": activar para ordenar la columna de manera ascendente",
                                    "sortDescending": ": activar para ordenar la columna de manera descendente"
                                },
                                "emptyTable": "No hay datos disponibles",
                                "info": "Mostrando de _START_ a _END_ de _TOTAL_ items",
                                "infoEmpty": "no hay datos disponibles",
                                "infoFiltered": "(filtrando desde _MAX_ total de registros)",
                                "lengthMenu": "_MENU_ items",
                                "search": "Buscar:",
                                "zeroRecords": "Sin Coincidencias"
                            },
                            buttons: [
                                { extend: 'print',
                                  className: 'btn dark btn-outline', 
                                  customize: function ( win ) {
                                        $(win.document.body)
                                            .css( 'font-size', '10pt' );

                                        $(win.document.body).find( 'table' )
                                            .addClass( 'compact' )
                                            .css( 'font-size', 'inherit' );
                                    } 
                                },
                                { extend: 'pdf', className: 'btn green btn-outline' },
                                { extend: 'csv', className: 'btn purple btn-outline ' }
                            ],
                            scrollY:        150,
                            deferRender:    true,
                            // scroller:       true,
                            "scrollX": true,
                            fixedHeader: true,
                            scrollCollapse: true,
                            stateSave:      true,
                            "lengthMenu": [
                                [10, 15, 20, -1],
                                [10, 15, 20, "All"] 
                            ],
                            "pageLength": 10,
                            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                            "data": Dosificaciones,
                            "rowId": "id",
                            //campos del DTO 
                            "columns": [
                                { "data": "ntramite" },
                                { "data": "nautorizacion" },
                                { "data": "stockfacturas" },
                                {
                                    "data": "nombrecompleto",
                                    "render": function(d, t, r) {
                                                var student = r;
                                                var returnString = "";
                                                // idsistemafacturacion idtipofacturacion idmarcaserie
                                                if (student.hasOwnProperty('idsistemafacturacion')) {
                                                    returnString = student.idsistemafacturacion;
                                                    // if (student.hasOwnProperty('idtipofacturacion')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idtipofacturacion;
                                                    //     } else {
                                                    //         returnString = student.idtipofacturacion;
                                                    //     }
                                                    // }
                                                    // if (student.hasOwnProperty('idmarcaserie')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idmarcaserie;
                                                    //     } else {
                                                    //         returnString = student.idmarcaserie;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                }else{
                                                    // if (student.hasOwnProperty('idtipofacturacion')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idtipofacturacion;
                                                    //     } else {
                                                    //         returnString = student.idtipofacturacion;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                    // if (student.hasOwnProperty('idmarcaserie')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idmarcaserie;
                                                    //     } else {
                                                    //         returnString = student.idmarcaserie;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                    returnString = "Sin Datos";
                                                }
                                                
                                                return returnString;
                                            } 
                                },
                                { "data": "fechalimiteemision" },
                                {
                                  "orderable": false,
                                  "data": null,
                                  "defaultContent": 
                                   `<a class="boton-op btn-editdos" data-toggle="tooltip" title="Editar" style="cursor: hand;cursor:pointer;">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        Editar
                                    </a>`
                                }
                            ],
                            "order": [[ 0, "asc" ]]
                        });
                    }
                    if(access=="consulta"){
                        _table = $('#tabladosificacion').DataTable({
                            "language": {
                                "aria": {
                                    "sortAscending": ": activar para ordenar la columna de manera ascendente",
                                    "sortDescending": ": activar para ordenar la columna de manera descendente"
                                },
                                "emptyTable": "No hay datos disponibles",
                                "info": "Mostrando de _START_ a _END_ de _TOTAL_ items",
                                "infoEmpty": "no hay datos disponibles",
                                "infoFiltered": "(filtrando desde _MAX_ total de registros)",
                                "lengthMenu": "_MENU_ items",
                                "search": "Buscar:",
                                "zeroRecords": "Sin Coincidencias"
                            },
                            buttons: [
                                { extend: 'print',
                                  className: 'btn dark btn-outline', 
                                  customize: function ( win ) {
                                        $(win.document.body)
                                            .css( 'font-size', '10pt' );

                                        $(win.document.body).find( 'table' )
                                            .addClass( 'compact' )
                                            .css( 'font-size', 'inherit' );
                                    } 
                                },
                                { extend: 'pdf', className: 'btn green btn-outline' },
                                { extend: 'csv', className: 'btn purple btn-outline ' }
                            ],
                            scrollY:        150,
                            deferRender:    true,
                            // scroller:       true,
                            "scrollX": true,
                            fixedHeader: true,
                            scrollCollapse: true,
                            stateSave:      true,
                            "lengthMenu": [
                                [10, 15, 20, -1],
                                [10, 15, 20, "All"] 
                            ],
                            "pageLength": 10,
                            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                            "data": Dosificaciones,
                            "rowId": "id",
                            //campos del DTO 
                            "columns": [
                                { "data": "ntramite" },
                                { "data": "nautorizacion" },
                                { "data": "stockfacturas" },
                                {
                                    "data": "nombrecompleto",
                                    "render": function(d, t, r) {
                                                var student = r;
                                                var returnString = "";
                                                // idsistemafacturacion idtipofacturacion idmarcaserie
                                                if (student.hasOwnProperty('idsistemafacturacion')) {
                                                    returnString = student.idsistemafacturacion;
                                                    // if (student.hasOwnProperty('idtipofacturacion')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idtipofacturacion;
                                                    //     } else {
                                                    //         returnString = student.idtipofacturacion;
                                                    //     }
                                                    // }
                                                    // if (student.hasOwnProperty('idmarcaserie')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idmarcaserie;
                                                    //     } else {
                                                    //         returnString = student.idmarcaserie;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                }else{
                                                    // if (student.hasOwnProperty('idtipofacturacion')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idtipofacturacion;
                                                    //     } else {
                                                    //         returnString = student.idtipofacturacion;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                    // if (student.hasOwnProperty('idmarcaserie')) {
                                                    //     if (returnString!=null && returnString!="") {
                                                    //         returnString += " - " + student.idmarcaserie;
                                                    //     } else {
                                                    //         returnString = student.idmarcaserie;
                                                    //     }
                                                    // }else{
                                                    //     returnString = "Sin Datos";
                                                    // }
                                                    returnString = "Sin Datos";
                                                }
                                                
                                                return returnString;
                                            } 
                                },
                                { "data": "fechalimiteemision" },
                                {
                                  "orderable": false,
                                  "data": null,
                                  "defaultContent": 
                                   ``
                                }
                            ],
                            "order": [[ 0, "asc" ]]
                        });
                    }
                    
                    formateartabla();
                    cargareventos();
                    tooltipnow();
                }
                else {
                    toastr.error(res.mensaje);
                }
            },
            error: function (res) {
                toastr.error(res.mensaje);
            }
        });
    }
    function formateartabla(){
        $('#tabla').css('display','block');
        // $('#tablagestiones').css('width','100%');
        // var tablagestiones_length = document.getElementById('tablagestiones_length');
        // var tablagestiones_paginate = document.getElementById('tablagestiones_paginate');
        // var tablagestiones_info = document.getElementById('tablagestiones_info');
        // var tablagestiones_filter = document.getElementById('tablagestiones_filter');


        // tablagestiones_info.innerHTML = tablagestiones_info.innerHTML.replace('Showing', 'Mostrando');
        // tablagestiones_info.innerHTML = tablagestiones_info.innerHTML.replace('to', 'a');
        // tablagestiones_info.innerHTML = tablagestiones_info.innerHTML.replace('of', 'de');
        // tablagestiones_info.innerHTML = tablagestiones_info.innerHTML.replace('entries', 'items');

        // tablagestiones_paginate.innerHTML = tablagestiones_paginate.innerHTML.replace('Previous','Anterior');
        // tablagestiones_paginate.innerHTML = tablagestiones_paginate.innerHTML.replace('Next','Siguiente');

        // tablagestiones_filter.innerHTML = tablagestiones_filter.innerHTML.replace('Search','Buscar');

        // tablagestiones_length.innerHTML = tablagestiones_length.innerHTML.replace('Show','Mostrar');
        // tablagestiones_length.innerHTML = tablagestiones_length.innerHTML.replace('entries','items');
    }
    function cargareventos(){
        $(".btn-editdos").on('click',function(){
            var iddos = $(this).parent().parent().attr("id");
            var data = {
                IdDosificacion: iddos
            };
            data = JSON.stringify(data);
            $.ajax({
                type: 'POST',
                url: urlBase + 'sucursales/TraerDosificacion',
                data: data,
                dataType: 'json',
                contentType: "application/json; charset=utf-8",
                success: function (res) {
                    if (res.tipoMensaje=="success") {
                        var Dosificacion = res.Dosificacion;
                        $("#txtntramite").val(Dosificacion.ntramite);
                        $("#txtnauth").val(Dosificacion.nautorizacion);
                        $("#txtnfac").val(Dosificacion.cantidadfac);
                        $("#txtfle").val(Dosificacion.fechalimiteemision);
                        $("#comboley").val(Dosificacion.idleyenda);
                        $("#txttday").val(Dosificacion.tiempodias);
                        $("#combosisfac").val(Dosificacion.idsistemafacturacion);
                        //$("#combotifac").val(Dosificacion.idtipofacturacion);
                        //$("#combosm").val(Dosificacion.idmarcaserie);
                        $("#txtclave").val(Dosificacion.clave),
                        $("#combohab").val(Dosificacion.habilitado),

                        $('#btnAceptaradddos').attr("data-iddosificacion",iddos);
                        $("#tituloModaldos").text("Editar Dosificacion");
                        $("#modaladddos").modal('show');
                        
                    }
                    else {
                        toastr.error(res.mensaje);
                    }

                    //BloquearComboHabilitado
                    if (Dosificacion.habilitado == 1) {
                        $("#combohab").attr("disabled",true);
                    }else {
                        $("#combohab").attr("disabled",false);
                    }

                    //Ocultar Txtclave Dosificacion
                    if(Dosificacion.idsistemafacturacion == 2){
                        $('#idtxtclave').css('display','none');
                    }else {
                        $('#idtxtclave').css('display','block');
                    }
                    tooltipnow();
                },
                error: function (res) {
                    toastr.error(res.mensaje);
                }
            });          
        });
        $(".btn-eliminardos").click(function(){
            var iddosif = $(this).parent().parent().attr("id");
            $("#mensajeadver").text("¿Seguro desea Eliminar este item?");
            $("#btnacepadv").attr("data-iddosificacion",iddosif);
            $("#modaladvertencia").modal("show");    
        });

        //Ocultar Txtclave Dosificacion
        var combsisfac = document.getElementById("combosisfac");
        combsisfac.onchange = function () {
            var idopselect =  $("#combosisfac").val();
            if(idopselect == 2){
                $('#idtxtclave').css('display','none');
                $('#txtclave').val('');

            }else {
                $('#idtxtclave').css('display','block');
            }
        }
    }
    function cargarvista(){
        // $("#topbar").children()[0].classList.remove("active");
        // $("#topbar").children()[1].classList.add("active");
    }
    function guardareditardosificacion(){
        if($('#txtntramite').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#txtnauth').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#txttday').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#txtfle').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#txtley').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#btnAceptaradddos').attr('data-iddosificacion')!=null){
            //actualizar
            data={
                IdDosificacion:     $('#btnAceptaradddos').attr("data-iddosificacion"),
                ntramite:           $("#txtntramite").val(),
                nauth:              $("#txtnauth").val(),
                nfac:               $("#txtnfac").val(),
                fle:                $("#txtfle").val(),
                ley:                $("#comboley").val(),
                tday:               $("#txttday").val(),
                sisfac:             $("#combosisfac").val(),
                //tifac:              $("#combotifac").val(),
                //sm:                 $("#combosm").val(),
                clave:              $("#txtclave").val(),
                hab:                $("#combohab").val(),
                //idsuc:              $("#lblidsucursal").text(),
                idem:               $("#lblidempresa").text(),
                idpfacturacion:     $("#lblidpfacturacion").text()
            };
            var urlfinal= urlBase + "sucursales/actualizar-dosificacion";
            var dataValue = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: urlfinal,
                contentType: "application/json; charset=utf-8",
                data: dataValue,
                dataType: "json",
                success: function (res) {
                if(res.tipoMensaje=="success"){
                    toastr.success(res.mensaje);
                    $("#modaladddos").modal('hide');
                    var Dosificacion = res.Dosificaciones;
                    var Sistemafac = res.Sistemafac;
                    var Leyenda = res.Leyenda;
                    //var Tipofac = res.Tipofac;
                    //var Seriemarca = res.Seriemarca;
                    //formatear datos
                        //Leyenda
                            var idley = Dosificacion.idleyenda;
                            for(var j=0;j<Leyenda.length;j++){
                                if(Leyenda[j].id==idley){
                                    Dosificacion.idleyenda = Leyenda[j].ley;
                                }
                            }
                        //sistema facturacion
                            var idsisfac = Dosificacion.idsistemafacturacion;
                            for(var j=0;j<Sistemafac.length;j++){
                                if(Sistemafac[j].id==idsisfac){
                                    Dosificacion.idsistemafacturacion = Sistemafac[j].sistemafacturacion;
                                }
                            }
                        //tipo facturacion
                        //     var idtifac = Dosificacion.idtipofacturacion;
                        //     for(var j=0;j<Tipofac.length;j++){
                        //         if(Tipofac[j].id==idtifac){
                        //             Dosificacion.idtipofacturacion = Tipofac[j].tipofacturacion;
                        //         }
                        //     }
                        //serie marca
                        //     var idsm = Dosificacion.idmarcaserie;
                        //     for(var j=0;j<Seriemarca.length;j++){
                        //         if(Seriemarca[j].id==idsm){
                        //             Dosificacion.idmarcaserie = Seriemarca[j].seriemarca;
                        //         }
                        //     }
                    var rowNode = _table
                            .row("#" + Dosificacion.id)
                            .data(Dosificacion)
                            .draw(false)
                            .node();
                    cargareventos();
                }else{
                    toastr.error(res.mensaje);
                }
                },
                error: function(res){
                    toastr.error(res);  
                }
            });
        }else{
            //crear
            data={
                ntramite:           $("#txtntramite").val(),
                nauth:              $("#txtnauth").val(),
                nfac:               $("#txtnfac").val(),
                fle:                $("#txtfle").val(),
                ley:                $("#comboley").val(),
                tday:               $("#txttday").val(),
                sisfac:             $("#combosisfac").val(),
                // tifac:              $("#combotifac").val(),
                // sm:                 $("#combosm").val(),
                clave:              $("#txtclave").val(),
                hab:                $("#combohab").val(),
                //idsuc:              $("#lblidsucursal").text(),
                idem:               $("#lblidempresa").text(),
                idpfacturacion:     $("#lblidpfacturacion").text()
            };
            var urlfinal= urlBase + "sucursales/crear-dosificacion";
            var dataValue = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: urlfinal,
                contentType: "application/json; charset=utf-8",
                data: dataValue,
                dataType: "json",
                success: function (res) {
                    if(res.tipoMensaje=="success"){
                        toastr.success(res.mensaje);
                        $("#modaladddos").modal('hide');
                        var Dosificacion = res.Dosificaciones;
                        var Sistemafac = res.Sistemafac;
                        var Leyenda = res.Leyenda;
                        // var Tipofac = res.Tipofac;
                        // var Seriemarca = res.Seriemarca;
                        //formatear datos
                            //Leyenda
                                var idley = Dosificacion.idleyenda;
                                for(var j=0;j<Leyenda.length;j++){
                                    if(Leyenda[j].id==idley){
                                        Dosificacion.idleyenda = Leyenda[j].ley;
                                    }
                                }
                            //sistema facturacion
                                var idsisfac = Dosificacion.idsistemafacturacion;
                                for(var j=0;j<Sistemafac.length;j++){
                                    if(Sistemafac[j].id==idsisfac){
                                        Dosificacion.idsistemafacturacion = Sistemafac[j].sistemafacturacion;
                                    }
                                }
                            //tipo facturacion
                            //     var idtifac = Dosificacion.idtipofacturacion;
                            //     for(var j=0;j<Tipofac.length;j++){
                            //         if(Tipofac[j].id==idtifac){
                            //             Dosificacion.idtipofacturacion = Tipofac[j].tipofacturacion;
                            //         }
                            //     }
                            //serie marca
                            //     var idsm = Dosificacion.idmarcaserie;
                            //     for(var j=0;j<Seriemarca.length;j++){
                            //         if(Seriemarca[j].id==idsm){
                            //             Dosificacion.idmarcaserie = Seriemarca[j].seriemarca;
                            //         }
                            //     }
                        var rowNode = _table
                            .row.add(Dosificacion)
                            .draw()
                            .node();
                        cargareventos();
                        $("tr[id='"+res.Dosificaciones.id+"']").css('color', '#fff');
                        $("tr[id='"+res.Dosificaciones.id+"']").css('background-color', '#0E8BD8');
                        $("tr[id='"+res.Dosificaciones.id+"']").children()[1].classList.remove("sorting_1");
                        $("tr[id='"+res.Dosificaciones.id+"']").children().children()[0].style.color="#fff";
                        $("tr[id='"+res.Dosificaciones.id+"']").children().children()[1].style.color="#fff";
                        setTimeout(function () { 
                            $("tr[id='"+res.Dosificaciones.id+"']").css('background-color', '#fff');
                            $("tr[id='"+res.Dosificaciones.id+"']").children()[1].classList.add("sorting_1");
                            $("tr[id='"+res.Dosificaciones.id+"']").css('color', '#333');
                            $("tr[id='"+res.Dosificaciones.id+"']").children().children()[0].style.color="#337ab7";
                            $("tr[id='"+res.Dosificaciones.id+"']").children().children()[1].style.color="#337ab7";
                        }, 5000);
                    }else{
                        toastr.error(res.mensaje);
                    }
                },
                error: function(res){
                    console.log(res);
                    toastr.error(res + 'Error');  
                }
            });
        }
        return 1;
    }
/************validaciones************/
    // $("#txtntramite").keypress(function (tecla) {
    //     var value = $("#txtntramite").val();
    //     if((value.length + 1) > 300){
    //         toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
    //         return false;
    //     }else{
    //         return true;
    //     }           
    // });

    $("#txtntramite").keypress(function (tecla) {
        var value = $("#txtntramite").val();
        var code=tecla.charCode;
        if(code === 8){
            return true;
        }
        if(code > 57 || code < 48){            
            //toastr.error("solo puede tener numeros");
            return false;        
        }else{
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }      
        }
    });
    $("#txtnauth").keypress(function (tecla) {
        var value = $("#txtnauth").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });
    $("#txtnfac").keypress(function (tecla) {
        var value = $("#txtnfac").val();
        var code=tecla.charCode;
        if(code === 8){
            return true;
        }
        if(code > 57 || code < 48){            
            //toastr.error("solo puede tener numeros");
            return false;        
        }else{
            if((value.length + 1) > 11){
                toastr.error("solo puede tener 11 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }         
        }
    });
    $("#txttday").keypress(function (tecla) {
        var value = $("#txttday").val();
        var code=tecla.charCode;
        if(code === 8){
            return true;
        }
        if(code > 57 || code < 48){            
            //toastr.error("solo puede tener numeros");
            return false;        
        }else{
            if((value.length + 1) > 11){
                toastr.error("solo puede tener 11 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }             
        }
    });
    // $("#txtley").keypress(function (tecla) {
    //     var value = $("#txtley").val();
    //     if((value.length + 1) > 10000){
    //         toastr.error("solo puede tener 10000 caracteres",'Error', {timeOut: 3000});
    //         return false;
    //     }else{
    //         return true;
    //     }           
    // });
    $("#txtclave").keypress(function (tecla) {
        var value = $("#txtclave").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });
    $("#modaladddos").draggable({
        handle: ".modal-content"
    });
    document.addEventListener('click', function(event){
        perm = 1;
    });
    document.addEventListener('keydown', function(event){
        var key = event.keyCode;
        perm = 1;
        //escape
            if(key==27){
                if($("#modaladddos").hasClass( "in" )){
                    perm = 1;
                    $("#modaladddos").modal("hide");
                }
            }
        //enter
            if(key==13){
                if($("#modaladddos").hasClass( "in" )){
                    
                    perm = guardareditardosificacion();
                    $("#modaladddos").on('hide.bs.modal', function (e) {
                        if(perm!=1){
                            e.preventDefault();
                        }
                    });
                }
            }
        //up
            if(key==38){
                if($("#modaladddos").hasClass( "in" )){
                    var a  =$("#modaladddos .modal-body input");
                    for(var i=0;i<a.length;i++){
                        var fo = $("#"+a[i].id).is(":focus");
                        if(fo==true){
                            if((i-1)>=0){
                                a[(i-1)].focus();
                                return;
                            }else{
                                a[a.length-1].focus();
                                return;
                            }
                        }
                    }
                }
            }
        //down
            if(key==40){
                if($("#modaladddos").hasClass( "in" )){
                    var a  =$("#modaladddos .modal-body input");
                    for(var i=0;i<a.length;i++){
                        var fo = $("#"+a[i].id).is(":focus");
                        if(fo==true){
                            if(i+1<a.length){
                                a[i+1].focus();
                                return;
                            }else{
                                a[0].focus();
                                return;
                            }
                        }
                    }
                }
            }
    }, false);
});




