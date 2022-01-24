$(document).ready(function () {
/************Runner************/
    var _table;
    var perm = 0;
    var access = $("#access").text();
    marcadores("modconfiguracion","viewparametros","view2sucursales");
    ObtenerSucursales();
    cargarvista();
/************Eventos************/
    $('#btnAceptaraddsuc').on('click',function(){
        guardaractualizarsucursal();
    });
    $("#btnacepadv").click(function(){
         var idsuc=$(this).attr('data-idsucursal');
         eliminarSucursal(idsuc);
    });

    $("#idrtexcel").on('click',function(){
        var idem = $('#lblidempresa').text();
        location.href=urlBase+"sucursales/repsucursalexcel/"+idem+"";
    });

    $("#btn-addsuc").on('click',function(){
        $("#txtalias").val("");
        $('#txtdirsuc').val("");
        $('#txttelsuc').val("");
        $('#txtmailsuc').val("");
        $('#txtci').val("");
        $('#txtnit').val("");
        $('#txtnombres').val("");
        $('#txtapellidos').val("");
        $('#txtmail').val("");
        $('#txtcel').val("");
        $('#txttel').val("");
        $('#txtdir').val("");
        $('#txtfecnac').val("");
        $("#tituloModalsuc").text("Agregar Sucursal");
        $("#btnAceptaraddsuc").removeAttr("data-idsucursal");
        $("#optionscon").css('display','none');
    });
    $("#txtci").on('change',function(){
        var ci = $(this).val();
        var data = {
            ci: ci,
            nit: null,
            email:null
        };
        data = JSON.stringify(data);
        //Obtener Persona
        $.ajax({
            type: 'POST',
            url: urlBase + 'personas/Traerpersona',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                var Persona = res.Persona;
                $('#txtci').val(Persona.ci);
                $('#txtnit').val(Persona.nit);
                $('#txtnombres').val(Persona.nombres);
                $('#txtapellidos').val(Persona.apellidos);
                $('#txtmail').val(Persona.email);
                $('#txtcel').val(Persona.celular);
                $('#txttel').val(Persona.telefono);
                $('#txtdir').val(Persona.direccion);
                $('#txtfecnac').val(Persona.fecha_de_nacimiento);
            },
            error: function (res) {
            }
        });
    });
    $("#txtnit").on('change',function(){
        var nit = $(this).val();
        var data = {
            ci: null,
            nit: nit,
            email:null
        };
        data = JSON.stringify(data);
        //Obtener Persona
        $.ajax({
            type: 'POST',
            url: urlBase + 'personas/Traerpersona',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                var Persona = res.Persona;
                $('#txtci').val(Persona.ci);
                $('#txtnit').val(Persona.nit);
                $('#txtnombres').val(Persona.nombres);
                $('#txtapellidos').val(Persona.apellidos);
                $('#txtmail').val(Persona.email);
                $('#txtcel').val(Persona.celular);
                $('#txttel').val(Persona.telefono);
                $('#txtdir').val(Persona.direccion);
                $('#txtfecnac').val(Persona.fecha_de_nacimiento);
            },
            error: function (res) {
            }
        });
    });
    $("#txtmail").on('change',function(){
        var email = $(this).val();
        var data = {
            ci: null,
            nit: null,
            email:email
        };
        data = JSON.stringify(data);
        //Obtener Persona
        $.ajax({
            type: 'POST',
            url: urlBase + 'personas/Traerpersona',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                var Persona = res.Persona;
                $('#txtci').val(Persona.ci);
                $('#txtnit').val(Persona.nit);
                $('#txtnombres').val(Persona.nombres);
                $('#txtapellidos').val(Persona.apellidos);
                $('#txtmail').val(Persona.email);
                $('#txtcel').val(Persona.celular);
                $('#txttel').val(Persona.telefono);
                $('#txtdir').val(Persona.direccion);
                $('#txtfecnac').val(Persona.fecha_de_nacimiento);
            },
            error: function (res) {
            }
        });
    });
    $(".rdconlbl").on('click',function(){
        var check = $(this).hasClass('active');
        var id = $(this).children().attr('id');
        var per = $("#personaoc").text();
        if(check==false){
            if(id=="cambiarcon"){
                $('#txtci').val("");
                $('#txtnit').val("");
                $('#txtnombres').val("");
                $('#txtapellidos').val("");
                $('#txtmail').val("");
                $('#txtcel').val("");
                $('#txttel').val("");
                $('#txtdir').val("");
                $('#txtfecnac').val("");
            }
            if(id=="editarcon"){
                if(per!=""){
                    per = per.split(',');
                    $('#txtnombres').val(per[0]);
                    $('#txtapellidos').val(per[1]);
                    $('#txtci').val(per[2]);
                    $('#txtnit').val(per[3]);
                    $('#txtmail').val(per[4]);
                    $('#txttel').val(per[5]);
                    $('#txtcel').val(per[6]);
                    $('#txtdir').val(per[7]);
                    $('#txtfecnac').val(per[8]);
                }
            }
        }
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
    function eliminarGestion(idges){
        var urlfinal = urlBase + "gestiones/eliminar-gestion";
        var data={
            IdGestion: idges
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
                    var IdGestion = "#" + res.IdGestion;
                    _table.row(IdGestion)
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
    function eliminarSucursal(idsuc){
        var urlfinal = urlBase + "sucursales/eliminar-sucursal";
        var data={
            IdSuc: idsuc
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
                    var IdSuc = "#" + res.IdSucursal;
                    _table.row(IdSuc)
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
    function ObtenerSucursales() {
        var data = {
            IdEmpresa:$('#lblidempresa').text()
        };
        data = JSON.stringify(data);
        //Obtener Sucursales
        $.ajax({
            type: 'POST',
            url: urlBase + 'sucursales/listadesucursales',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                if (res.tipoMensaje=="success") {
                    var Sucursales = res.Sucursales;

                    if(access=="total"){
                        _table = $('#tablasucursales').DataTable({
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
                                "zeroRecords": "Sin Coincidencias"
                            },
                            scrollY:        150,
                            bLengthChange: false,
                            deferRender:    true,
                            "lengthMenu": [
                                [10, 15, 20, -1],
                                [10, 15, 20, "All"] 
                            ],
                            "pageLength": 10,
                            "data": Sucursales,
                            "rowId": "id",
                            //campos del DTO 
                            "columns": [
                                { "data": "alias" },
                                { "data": "direccion" },
                                {
                                    "data": "nombrecompleto",
                                    "render": function(d, t, r) {
                                                var student = r;
                                                var returnString = "";
                                                if (student.hasOwnProperty('nombres')) {
                                                    returnString = student.nombres;
                                                    if (student.hasOwnProperty('apellidos')) {
                                                        if (returnString!=null && returnString!="") {
                                                            returnString += " " + student.apellidos;
                                                        } else {
                                                            returnString = student.apellidos;
                                                        }
                                                    }
                                                }else{
                                                    if (student.hasOwnProperty('apellidos')) {
                                                        if (returnString!=null && returnString!="") {
                                                            returnString += " " + student.apellidos;
                                                        } else {
                                                            returnString = student.apellidos;
                                                        }
                                                    }else{
                                                        returnString = "Sin Datos";
                                                    }
                                                }
                                                
                                                return returnString;
                                            } 
                                },
                                {
                                  "orderable": false,
                                  "data": null,
                                  "defaultContent": `
                                    <a style="float: right;" title="Eliminar" data-bs-toggle="modal" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-eliminarsuc" >
                                        <span class="svg-icon svg-icon-3" data-bs-toggle="tooltip">
                                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                              <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                              <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                              <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                          </svg>
                                        </span>
                                    </a>
                                    <a style="float: right;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-goptf" data-bs-toggle="tooltip" data-bs-placement="top" title="Puntos de facturacion">
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V2.40002C0 3.00002 0.4 3.40002 1 3.40002H12C12.6 3.40002 13 3.00002 13 2.40002V1.40002C13 0.800024 12.6 0.400024 12 0.400024Z" fill="black"/>
                                                <path opacity="0.3" d="M15 8.40002H1C0.4 8.40002 0 8.00002 0 7.40002C0 6.80002 0.4 6.40002 1 6.40002H15C15.6 6.40002 16 6.80002 16 7.40002C16 8.00002 15.6 8.40002 15 8.40002ZM16 12.4C16 11.8 15.6 11.4 15 11.4H1C0.4 11.4 0 11.8 0 12.4C0 13 0.4 13.4 1 13.4H15C15.6 13.4 16 13 16 12.4ZM12 17.4C12 16.8 11.6 16.4 11 16.4H1C0.4 16.4 0 16.8 0 17.4C0 18 0.4 18.4 1 18.4H11C11.6 18.4 12 18 12 17.4Z" fill="black"/>
                                            </svg>
                                        </span>
                                    </a>
                                      <a style="float: right;" title="Editar" data-bs-toggle="modal" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-editsuc">
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
                            "order": [[ 1, "asc" ]]
                        });
                    }
                    if(access=="parcial"){
                        _table = $('#tablasucursales').DataTable({
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
                            "lengthMenu": [
                                [10, 15, 20, -1],
                                [10, 15, 20, "All"] 
                            ],
                            "pageLength": 10,
                            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                            "data": Sucursales,
                            "rowId": "id",
                            //campos del DTO 
                            "columns": [
                                { "data": "alias" },
                                { "data": "direccion" },
                                {
                                    "data": "nombrecompleto",
                                    "render": function(d, t, r) {
                                                var student = r;
                                                var returnString = "";
                                                if (student.hasOwnProperty('nombres')) {
                                                    returnString = student.nombres;
                                                    if (student.hasOwnProperty('apellidos')) {
                                                        if (returnString!=null && returnString!="") {
                                                            returnString += " " + student.apellidos;
                                                        } else {
                                                            returnString = student.apellidos;
                                                        }
                                                    }
                                                }else{
                                                    if (student.hasOwnProperty('apellidos')) {
                                                        if (returnString!=null && returnString!="") {
                                                            returnString += " " + student.apellidos;
                                                        } else {
                                                            returnString = student.apellidos;
                                                        }
                                                    }else{
                                                        returnString = "Sin Datos";
                                                    }
                                                }
                                                
                                                return returnString;
                                            } 
                                },
                                {
                                  "orderable": false,
                                  "data": null,
                                  "defaultContent": 
                                   `<a class="boton-op btn-editsuc" data-toggle="tooltip" title="Editar" style="cursor: hand;cursor:pointer;">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        Editar
                                    </a>
                                    <a class="boton-op btn-goptf" data-toggle="tooltip" title="Puntos de Facturacion" style="cursor: hand;cursor:pointer;">
                                        <span class="glyphicon glyphicon-th"></span>
                                        Puntos de Facturacion
                                    </a>`
                                }
                            ],
                            "order": [[ 1, "asc" ]]
                        });
                    }
                    if(access=="consulta"){
                        _table = $('#tablasucursales').DataTable({
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
                            "lengthMenu": [
                                [10, 15, 20, -1],
                                [10, 15, 20, "All"] 
                            ],
                            "pageLength": 10,
                            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                            "data": Sucursales,
                            "rowId": "id",
                            //campos del DTO 
                            "columns": [
                                { "data": "alias" },
                                { "data": "direccion" },
                                {
                                    "data": "nombrecompleto",
                                    "render": function(d, t, r) {
                                                var student = r;
                                                var returnString = "";
                                                if (student.hasOwnProperty('nombres')) {
                                                    returnString = student.nombres;
                                                    if (student.hasOwnProperty('apellidos')) {
                                                        if (returnString!=null && returnString!="") {
                                                            returnString += " " + student.apellidos;
                                                        } else {
                                                            returnString = student.apellidos;
                                                        }
                                                    }
                                                }else{
                                                    if (student.hasOwnProperty('apellidos')) {
                                                        if (returnString!=null && returnString!="") {
                                                            returnString += " " + student.apellidos;
                                                        } else {
                                                            returnString = student.apellidos;
                                                        }
                                                    }else{
                                                        returnString = "Sin Datos";
                                                    }
                                                }
                                                
                                                return returnString;
                                            } 
                                },
                                {
                                  "orderable": false,
                                  "data": null,
                                  "defaultContent": 
                                   ``
                                }
                            ],
                            "order": [[ 1, "asc" ]]
                        });
                    }
                    
                    formateartabla();
                    cargareventos();
                    // tooltipnow();
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

    function loading(){
        // $("").addClass("hola");
        $('.dataTables_filter input').addClass('yourclass');
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
        $(".btn-goptf").on('click',function(){
            var idem = $('#lblidempresa').text();
            var idsuc = $(this).parent().parent().attr("id");
            location.href=urlBase+"puntosfacturacion/"+idem+"/"+idsuc;
        });
        $(".btn-editsuc").on('click',function(){
            var idsuc = $(this).parent().parent().attr("id");
            var data = {
                IdSucursal: idsuc
            };
            data = JSON.stringify(data);
            $.ajax({
                type: 'POST',
                url: urlBase + 'sucursales/TraerSucursal',
                data: data,
                dataType: 'json',
                contentType: "application/json; charset=utf-8",
                success: function (res) {
                    if (res.tipoMensaje=="success") {
                        var Sucursal = res.Sucursal;
                        var result = Object.keys(Sucursal).map(function(key) {
                          return [key, Sucursal[key]];
                        });
                        for(var i=0;i<result.length;i++){
                            var hito = result[i];
                            if(hito[1]==null){
                                Sucursal[hito[0]] = "";
                            }
                        }
                        $('#txtalias').val(Sucursal.alias);
                        $('#txtdirsuc').val(Sucursal.direccion);
                        $('#txttelsuc').val(Sucursal.telefono);
                        $('#txtmailsuc').val(Sucursal.email);
                        //persona
                            $("#personaoc").text(Sucursal.nombres+
                                                ","+Sucursal.apellidos+
                                                ","+Sucursal.ci+
                                                ","+Sucursal.nit+
                                                ","+Sucursal.email+
                                                ","+Sucursal.telefono+
                                                ","+Sucursal.celular+
                                                ","+Sucursal.direccion+
                                                ","+Sucursal.fecha_de_nacimiento);
                            $('#txtci').val(Sucursal.ci);
                            $('#txtnit').val(Sucursal.nit);
                            $('#txtnombres').val(Sucursal.nombres);
                            $('#txtapellidos').val(Sucursal.apellidos);
                            $('#txtmail').val(Sucursal.emailper);
                            $('#txtcel').val(Sucursal.celular);
                            $('#txttel').val(Sucursal.telper);
                            $('#txtdir').val(Sucursal.dirper);
                            $('#txtfecnac').val(Sucursal.fecha_de_nacimiento);

                            $("#optionscon").css('display','block');
                            $("#editarlblcon").addClass("active");
                            $("#crearlblcon").removeClass("active");
                            $("#cambiarcon").prop('checked', false);
                            $("#editarcon").prop('checked', true);

                        $("#tituloModalsuc").text("Editar Sucursal");
                        $('#btnAceptaraddsuc').attr("data-idsucursal",idsuc);
                        $("#modaladdsuc").modal('show');
                        
                    }
                    else {
                        toastr.error(res.mensaje);
                    }
                    tooltipnow();
                },
                error: function (res) {
                    toastr.error(res.mensaje);
                }
            });          
        });
        $(".btn-eliminarsuc").click(function(){
            var idsuc = $(this).parent().parent().attr("id");
            $("#mensajeadver").text("¿Seguro desea Eliminar este item?");
            $("#btnacepadv").attr("data-idsucursal",idsuc);
            $("#modaladvertencia").modal("show");    
        });
    }
    function cargarvista(){
        // $("#topbar").children()[0].classList.remove("active");
        // $("#topbar").children()[1].classList.add("active");
    }
    function guardaractualizarsucursal(){
        if($('#txtalias').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#txtdirsuc').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#txttelsuc').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        if($('#txtmailsuc').val()==""){
            toastr.error("falta completar campos obligatorios");
            return 0;
        }
        var cor1=$('#txtmailsuc').val();
        if(cor1!="" && cor1 !=" "){
            var res=cor1.indexOf('.');
            if(res==-1){
                toastr.error('formato de correo erroneo','Error', {timeOut: 3000});
                return 0; 
            }else{
                var res=cor1.indexOf('@');
                if(res==-1){
                    toastr.error('formato de correo erroneo','Error', {timeOut: 3000}); 
                    return 0;
                }
            }
        }
        if($('#txtci').val()=="" && $('#txtnit').val()==""){
            toastr.error("Es necesario Al menos CI o NIT para registrar una persona de contacto",'Error', {timeOut: 3000});
            return 0;
        }
        if($('#txtnombres').val()==""){
            toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
            return 0;
        }
        if($('#txtapellidos').val()==""){
            toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
            return 0;
        }
        if($('#txtcelular').val()==""){
            toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
            return 0;
        }
        if($('#txtmail').val()==""){
            toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
            return 0;
        }
        var cor=$('#txtmail').val();
        if(cor!="" && cor !=" "){
            var res=cor.indexOf('.');
            if(res==-1){
                toastr.error('formato de correo erroneo','Error', {timeOut: 3000});
                return 0; 
            }else{
                var res=cor.indexOf('@');
                if(res==-1){
                    toastr.error('formato de correo erroneo','Error', {timeOut: 3000}); 
                    return 0;
                }
            }
        }
        if($('#btnAceptaraddsuc').attr('data-idsucursal')!=null){
            //actualizar
            data={
                IdSucursal:  $('#btnAceptaraddsuc').attr("data-idsucursal"),
                alias:       $('#txtalias').val(),
                dirsuc:      $('#txtdirsuc').val(),
                telsuc:      $('#txttelsuc').val(),
                mailsuc:     $('#txtmailsuc').val(),
                ci:          $('#txtci').val(),
                nit:         $('#txtnit').val(),
                nombres:     $('#txtnombres').val(),
                apellidos:   $('#txtapellidos').val(),
                email:       $('#txtmail').val(),
                celular:     $('#txtcel').val(),
                telefono:    $('#txttel').val(),
                direccion:   $('#txtdir').val(),
                fecnac:      $('#txtfecnac').val(),
                rdcon:       $(".rdcon:checked").val(),
                idem:        $('#lblidempresa').text()
            };
            var urlfinal= urlBase + "sucursales/actualizar-sucursal";
            var dataValue = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: urlfinal,
                contentType: "application/json; charset=utf-8",
                data: dataValue,
                dataType: "json",
                success: function (res) {
                console.log(res);
                if(res.tipoMensaje=="success"){
                    toastr.success(res.mensaje);
                    $("#modaladdsuc").modal('hide');
                    var rowNode = _table
                            .row("#" + res.Sucursal.id)
                            .data(res.Sucursal)
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
                alias:       $('#txtalias').val(),
                dirsuc:      $('#txtdirsuc').val(),
                telsuc:      $('#txttelsuc').val(),
                mailsuc:     $('#txtmailsuc').val(),
                ci:          $('#txtci').val(),
                nit:         $('#txtnit').val(),
                nombres:     $('#txtnombres').val(),
                apellidos:   $('#txtapellidos').val(),
                email:       $('#txtmail').val(),
                celular:     $('#txtcel').val(),
                telefono:    $('#txttel').val(),
                direccion:   $('#txtdir').val(),
                fecnac:      $('#txtfecnac').val(),
                idem:        $('#lblidempresa').text()
            };
            var urlfinal= urlBase + "sucursales/crear-sucursal";
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
                        $("#modaladdsuc").modal('hide');
                        var rowNode = _table
                            .row.add(res.Sucursal)
                            .draw()
                            .node();
                        cargareventos();
                        $("tr[id='"+res.Sucursal.id+"']").css('color', '#fff');
                        $("tr[id='"+res.Sucursal.id+"']").css('background-color', '#0E8BD8');
                        $("tr[id='"+res.Sucursal.id+"']").children()[1].classList.remove("sorting_1");
                        $("tr[id='"+res.Sucursal.id+"']").children().children()[0].style.color="#fff";
                        $("tr[id='"+res.Sucursal.id+"']").children().children()[1].style.color="#fff";
                        $("tr[id='"+res.Sucursal.id+"']").children().children()[2].style.color="#fff";
                        setTimeout(function () { 
                            $("tr[id='"+res.Sucursal.id+"']").css('background-color', '#fff');
                            $("tr[id='"+res.Sucursal.id+"']").children()[1].classList.add("sorting_1");
                            $("tr[id='"+res.Sucursal.id+"']").css('color', '#333');
                            $("tr[id='"+res.Sucursal.id+"']").children().children()[0].style.color="#337ab7";
                            $("tr[id='"+res.Sucursal.id+"']").children().children()[1].style.color="#337ab7";
                            $("tr[id='"+res.Sucursal.id+"']").children().children()[2].style.color="#337ab7";
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
    $("#txtci").keypress(function (tecla) {
        var value = $("#txtci").val();
        var code=tecla.charCode;
        if(code === 8){
            return true;
        }
        if(code > 57 || code < 48){            
            //toastr.error("solo puede tener numeros");
             return false;        
        }else{
             return true;
        }
    });

    $("#txtnit").keypress(function (tecla) {
        var value = $("#txtnit").val();
        var code=tecla.charCode;
        if(code === 8){
            return true;
        }
        if(code > 57 || code < 48){            
            //toastr.error("solo puede tener numeros");
            return false;        
        }else{
            if((value.length + 1) > 15){
                toastr.error("solo puede tener 15 digitos",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        }
    });

    $("#txtnombres").keypress(function (tecla) {
        var value = $("#txtnombres").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });

    $("#txtapellidos").keypress(function (tecla) {
        var value = $("#txtapellidos").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });

    $("#txtmail").keypress(function (tecla) {
        var value = $("#txtmail").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });

    $("#txtemailsuc").keypress(function (tecla) {
        var value = $("#txtemailsuc").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });

    $("#txttelsuc").keypress(function (tecla) {
        var value = $("#txttelsuc").val();
        if((value.length + 1) > 100){
            toastr.error("solo puede tener 100 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });

    $("#txtdirsuc").keypress(function (tecla) {
        var value = $("#txtdirsuc").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });

    $("#txtalias").keypress(function (tecla) {
        var value = $("#txtalias").val();
        if((value.length + 1) > 300){
            toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
            return false;
        }else{
            return true;
        }           
    });

    $("#modaladdsuc").draggable({
        handle: ".modal-content"
    });
    document.addEventListener('click', function(event){
        perm = 1;
    });
    document.addEventListener('keydown', function(event){
        var key = event.keyCode;
        console.log(key);
        perm = 1;
        //escape
            if(key==27){
                if($("#modaladdsuc").hasClass( "in" )){
                    perm = 1;
                    $("#modaladdsuc").modal("hide");
                }
            }
        //enter
            if(key==13){
                if($("#modaladdsuc").hasClass( "in" )){
                    perm = guardaractualizarsucursal();
                    $("#modaladdsuc").on('hide.bs.modal', function (e) {
                        if(perm!=1){
                            e.preventDefault();
                        }
                    });
                }
            }
        //up
            if(key==38){
                if($("#modaladdsuc").hasClass( "in" )){
                    var a  =$("#modaladdsuc .modal-body input");
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
                if($("#modaladdsuc").hasClass( "in" )){
                    var a  =$("#modaladdsuc .modal-body input");
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


    loading();
});

