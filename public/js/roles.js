"use strict";
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var dt;
    var ListData = [];

    /// IDs de acceso a los diferentes modulos
    var tree1 = $('#tree_configuracion');
    var tree2 = $('#tree_miempresa');
    var tree3 = $('#tree_contabilidad');
    var tree4 = $('#tree_compras');
    var tree5 = $('#tree_ventas');
    var tree6 = $('#tree_rrhh');
    var tree7 = $('#tree_activos');
    var tree8 = $('#tree_produccion');
    var tree9 = $('#tree_crm');

    // Private functions
    var init = function () {

        dt = $("#kt_datatable_usuarios").DataTable({

            language: {
                "zeroRecords": "No se encontraron resultados",
                "infoEmpty": "No existen datos",
                "processing": "Procesando...",
            },
            info: !1,
            responsive: true,
            searchDelay: 300,
            processing: true,
            serverSide: false,
            order: [],
            stateSave: true,
            scrollY: '15vh',
            scrollCollapse: true,

            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            }
        });

        initSelectUsuario();
        KTMenu.createInstances();

    }

    // Init Guardar Configuracion
    var initSaveConfig = function () {

        var b;

        b = document.querySelector("#kt_save_config_submit"),

        b.addEventListener("click", (function(e) {

            var urlfinal;

            var seleccionados = "";
            var pool0 = tree1.jstree(true).get_selected();
            var pool1 = tree2.jstree(true).get_selected();
            var pool2 = tree3.jstree(true).get_selected();
            var pool3 = tree4.jstree(true).get_selected();
            var pool4 = tree5.jstree(true).get_selected();
            var pool5 = tree6.jstree(true).get_selected();
            var pool6 = tree7.jstree(true).get_selected();
            var pool7 = tree8.jstree(true).get_selected();
            var pool8 = tree9.jstree(true).get_selected();
            if(pool0.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree1.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree1.jstree(true).get_selected();
                }
            }
            if(pool1.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree2.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree2.jstree(true).get_selected();
                }
            }
            if(pool2.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree3.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree3.jstree(true).get_selected();
                }
            }
            if(pool3.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree4.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree4.jstree(true).get_selected();
                }
            }
            if(pool4.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree5.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree5.jstree(true).get_selected();
                }
            }
            if(pool5.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree6.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree6.jstree(true).get_selected();
                }
            }
            if(pool6.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree7.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree7.jstree(true).get_selected();
                }
            }
            if(pool7.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree8.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree8.jstree(true).get_selected();
                }
            }
            if(pool8.length>0){
                if(seleccionados==""){
                    seleccionados = String(tree9.jstree(true).get_selected());
                }else{
                    seleccionados = seleccionados + "," + tree9.jstree(true).get_selected();
                }
            }
            var seleccion = "";
            if(seleccionados!=""){
                seleccionados = seleccionados.split(",");

                for(var i=0;i<seleccionados.length;i++){
                    // console.log(seleccionados[i].replace('t',''));
                    var acceso = $("#" + seleccionados[i] + "").children().children().children('.checked').attr("data-value");
                    if(seleccion==""){
                        seleccion = seleccionados[i].replace('t','') + "/" + acceso;
                    }
                    else{
                        seleccion = seleccion + "," + seleccionados[i].replace('t','') + "/" + acceso;
                    }
                }
            }

            var formData;
            var TipoMensajeSwal;
            var MensajeSwal;

            b.setAttribute("data-kt-indicator", "on");
            b.disabled = !0;

            formData = new FormData(),
            formData.append('idusuario', b.value),
            formData.append('seleccion', seleccion),

            urlfinal= urlBase + "seguridad/actualizarpermisos",
           // dataValue = JSON.stringify(datalinea),

            $.ajax({
                type: "POST",
                url: urlfinal,
                contentType: "application/json; charset=utf-8",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                   // console.log(res);
                    if (res.titulo == "Success") {
                        TipoMensajeSwal = res.tipoMensaje;
                        MensajeSwal = res.mensaje;
                    }

                    if (res.titulo == "Error") {
                        TipoMensajeSwal = res.tipoMensaje;
                        MensajeSwal = res.mensaje;
                    }

                    setTimeout((function() {

                        b.removeAttribute("data-kt-indicator"), Swal.fire({
                            text : MensajeSwal,
                            icon: TipoMensajeSwal,
                            buttonsStyling: !1,
                            showConfirmButton: false,
                            buttonsStyling: false,
                            timer: 1000

                        }).then((function(e) {
                            if (TipoMensajeSwal == "error") {

                                b.disabled = !1
                            }
                            else {

                                b.disabled = !1
                                window.location = location.href;
                            }
                        }))

                    }), 1e1)
                },
                error: function(res){

                // toastr.error("Error no controlado, comuniquese con el administrador");

                }
            })
        }))
    }

     // ButtonSelectUsuario
    var initSelectUsuario = function() {

        const GestionSelectButton = document.querySelectorAll('[data-kt-action="usuario_select"]');
        var b = document.querySelector("#kt_save_config_submit");

        GestionSelectButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');
                // Get ID
                const iduserselect = $(this).attr("data-idus");

                if ( $(parent).hasClass('selected bg-primary') ) {

                    $(parent).removeClass('selected bg-primary');
                    vaciartrees();
                    b.value = "";
                }
                else {

                    dt.$('tr.selected').removeClass('selected bg-primary');
                    $(parent).addClass('selected bg-primary');
                    cargarvistas(iduserselect);
                    b.value = iduserselect;
                }

            });

        });
    }

    // Cargar Vistas
    var cargarvistas = function(idus) {
        var urlfinal;
        var formData;
       // console.log(idus);
        formData = new FormData(),
        formData.append('idusuario', idus)

        urlfinal= urlBase + "seguridad/traerpermisos"
        // dataValue = JSON.stringify(datalinea),

        $.ajax({
            type: "POST",
            url: urlfinal,
            contentType: "application/json; charset=utf-8",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {

                if (res.tipoMensaje=="success") {
                    vaciartrees();
                    var Modulo1 = res.Modulo1;
                    var Modulo2 = res.Modulo2;
                    var Modulo3 = res.Modulo3;
                    var Modulo4 = res.Modulo4;
                    var Modulo5 = res.Modulo5;
                    var Modulo6 = res.Modulo6;
                    var Modulo7 = res.Modulo7;
                    var Modulo8 = res.Modulo8;
                    var Modulo9 = res.Modulo9;
                    tree1.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo1
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree1.jstree("open_all");

                    tree2.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo2
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree2.jstree("open_all");

                    tree3.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo3
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree3.jstree("open_all");

                    tree4.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo4
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree4.jstree("open_all");

                    tree5.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo5
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree5.jstree("open_all");

                    tree6.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo6
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree6.jstree("open_all");

                    tree7.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo7
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree7.jstree("open_all");

                    tree8.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo8
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree8.jstree("open_all");

                    tree9.jstree({
                        'plugins': ["wholerow", "checkbox", "types"],
                        'core': {
                            "themes" : {
                                "responsive": false
                            },
                            'data': Modulo9
                        },
                        "types" : {
                            "default" : {
                                "icon" : "fas fa-pager text-primary"
                            },
                            "file" : {
                                "icon" : "fas fa-pager  text-primary"
                            }
                        }
                    });
                    tree9.jstree("open_all");

                    //cargareventos();
                    //tooltipnow();
                }
                else {
                    toastr.error(res.mensaje);
                }
            },
            error: function(res){
                toastr.error(res.mensaje);
            }
        })

        // $('#tree_configuracion').jstree({
        //     'plugins': ["wholerow", "checkbox", "types"],
        //     'core': {
        //         "themes" : {
        //             "responsive": false
        //         },
        //         'data': [{
        //                 "text": "Same but with checkboxes",
        //                 "children": [{
        //                     "text": "initially selected",
        //                     "state": {
        //                         "selected": true
        //                     }
        //                 }, {
        //                     "text": "custom icon",
        //                     "icon": "fa fa-warning text-danger"
        //                 }, {
        //                     "text": "initially open",
        //                     "icon" : "fa fa-folder text-default",
        //                     "state": {
        //                         "opened": true
        //                     },
        //                     "children": ["Another node"]
        //                 }, {
        //                     "text": "custom icon",
        //                     "icon": "fa fa-warning text-waring"
        //                 }, {
        //                     "text": "disabled node",
        //                     "icon": "fa fa-check text-success",
        //                     "state": {
        //                         "disabled": true
        //                     }
        //                 }]
        //             },
        //             "And wholerow selection"
        //         ]
        //     },
        //     "types" : {
        //         "default" : {
        //             "icon" : "fa fa-folder text-warning"
        //         },
        //         "file" : {
        //             "icon" : "fa fa-file  text-warning"
        //         }
        //     },
        // });
    }

    // Limpiar Tree
    var vaciartrees = function () {

        tree1.jstree("destroy").empty();
        tree2.jstree("destroy").empty();
        tree3.jstree("destroy").empty();
        tree4.jstree("destroy").empty();
        tree5.jstree("destroy").empty();
        tree6.jstree("destroy").empty();
        tree7.jstree("destroy").empty();
        tree8.jstree("destroy").empty();
        tree9.jstree("destroy").empty();
    }

    // Select Accesos Predeterminados
    var selectipoacceso = function () {

        const SelectTab = document.querySelectorAll('[data-kt-action="Acceso_select"]');

        SelectTab.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                if (this.id == "rcustomer") {

                    deselectall();
                }
                if (this.id == "radmin") {

                    radministrador();
                }
                if (this.id == "rvendedor") {

                    deselectall();
                    selectvendedor();
                }

            });

        });
    }

    // Deseleccionar todos los roles
    var deselectall = function () {

        tree1.jstree("deselect_all");
        tree2.jstree("deselect_all");
        tree3.jstree("deselect_all");
        tree4.jstree("deselect_all");
        tree5.jstree("deselect_all");
        tree6.jstree("deselect_all");
        tree7.jstree("deselect_all");
        tree8.jstree("deselect_all");
        tree9.jstree("deselect_all");

        var t1 = tree1.jstree().get_json('#', {flat:true});
        var t2 = tree2.jstree().get_json('#', {flat:true});
        var t3 = tree3.jstree().get_json('#', {flat:true});
        var t4 = tree4.jstree().get_json('#', {flat:true});
        var t5 = tree5.jstree().get_json('#', {flat:true});
        var t6 = tree6.jstree().get_json('#', {flat:true});
        var t7 = tree7.jstree().get_json('#', {flat:true});
        var t8 = tree8.jstree().get_json('#', {flat:true});
        var t9 = tree9.jstree().get_json('#', {flat:true});
        for(var i=0;i<t1.length;i++){
            var id = t1[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t2.length;i++){
            var id = t2[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t3.length;i++){
            var id = t3[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t4.length;i++){
            var id = t4[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t5.length;i++){
            var id = t5[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t6.length;i++){
            var id = t6[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t7.length;i++){
            var id = t7[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t8.length;i++){
            var id = t8[i].id;
            selaccesconsulta(id);
        }
        for(var i=0;i<t9.length;i++){
            var id = t9[i].id;
            selaccesconsulta(id);
        }
    }

     // Seleccionar rol Administrador
     var radministrador = function () {

        var t1 = tree1.jstree().get_json('#', {flat:true});
        var t2 = tree2.jstree().get_json('#', {flat:true});
        var t3 = tree3.jstree().get_json('#', {flat:true});
        var t4 = tree4.jstree().get_json('#', {flat:true});
        var t5 = tree5.jstree().get_json('#', {flat:true});
        var t6 = tree6.jstree().get_json('#', {flat:true});
        var t7 = tree7.jstree().get_json('#', {flat:true});
        var t8 = tree8.jstree().get_json('#', {flat:true});
        var t9 = tree9.jstree().get_json('#', {flat:true});
        for(var i=0;i<t1.length;i++){
            var id = t1[i].id;
            tree1.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t2.length;i++){
            var id = t2[i].id;
            tree2.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t3.length;i++){
            var id = t3[i].id;
            tree3.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t4.length;i++){
            var id = t4[i].id;
            tree4.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t5.length;i++){
            var id = t5[i].id;
            tree5.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t6.length;i++){
            var id = t6[i].id;
            tree6.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t7.length;i++){
            var id = t7[i].id;
            tree7.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t8.length;i++){
            var id = t8[i].id;
            tree8.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
        for(var i=0;i<t9.length;i++){
            var id = t9[i].id;
            tree9.jstree("check_node", "#"+id);
        }
    }

     // Seleccionar rol Vendedor
     var selectvendedor = function () {

        var t5 = tree5.jstree().get_json('#', {flat:true});
        for(var i=0;i<t5.length;i++){
            if(t5[i].text.split('<')[0]=="Ventas"){
                var id = t5[i].id;
                tree5.jstree("check_node", "#"+id);
                selaccesparcial(id);
            }
            if(t5[i].text.split('<')[0]=="Facturacion"){
                var id = t5[i].id;
                // tree5.jstree("deselect_node", "#"+id);
                selaccesconsulta(id);
            }
        }
    }

    // Seleccionar y deselecionar modulos
    var selectdeselectmodulo = function () {

        const SelectTab = document.querySelectorAll('[data-kt-action="Modulo_select"]');

        SelectTab.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                //Modulo Configuracion
                if (this.id == "rsm1") {

                    selectmoduloconfigacto();
                }
                if (this.id == "rdm1") {

                    selectmoduloconfigdesac();
                }

                //Modulo Mi empresa
                if (this.id == "rsm2") {

                    selectmodulo2acto();
                }
                if (this.id == "rdm2") {

                    selectmodulo2desac();
                }

                 //Modulo contabilidad
                if (this.id == "rsm3") {

                    selectmodulo3acto();
                }
                if (this.id == "rdm3") {

                    selectmodulo3desac();
                }

                 //Modulo compras
                if (this.id == "rsm4") {

                    selectmodulo4acto();
                }
                if (this.id == "rdm4") {

                    selectmodulo4desac();
                }

                 //Modulo ventas
                if (this.id == "rsm5") {

                    selectmodulo5acto();
                }
                if (this.id == "rdm5") {

                    selectmodulo5desac();
                }

                 //Modulo RRHH
                if (this.id == "rsm6") {

                    selectmodulo6acto();
                }
                if (this.id == "rdm6") {

                    selectmodulo6desac();
                }

                 //Modulo CRM
                if (this.id == "rsm7") {

                    selectmodulo9acto();
                }
                if (this.id == "rdm7") {

                    selectmodulo9desac();
                }

                 //Modulo activos fijos
                 if (this.id == "rsm8") {

                    selectmodulo7acto();
                }
                if (this.id == "rdm8") {

                    selectmodulo7desac();
                }

                 //Modulo Produccion
                if (this.id == "rsm9") {

                    selectmodulo8acto();
                }
                if (this.id == "rdm9") {

                    selectmodulo8desac();
                }
            });

        });
    }
    // seleccionar Modulo Configuracion
    var selectmoduloconfigacto = function () {

        var t1 = tree1.jstree().get_json('#', {flat:true});
        for(var i=0;i<t1.length;i++){
            var id = t1[i].id;
            tree1.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmoduloconfigdesac = function () {

        tree1.jstree("deselect_all");
        var t1 = tree1.jstree().get_json('#', {flat:true});
        for(var i=0;i<t1.length;i++){
            var id = t1[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo Mi empresa
    var selectmodulo2acto = function () {

        var t2 = tree2.jstree().get_json('#', {flat:true});
        for(var i=0;i<t2.length;i++){
            var id = t2[i].id;
            tree2.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo2desac = function () {

        tree2.jstree("deselect_all");
        var t2 = tree2.jstree().get_json('#', {flat:true});
        for(var i=0;i<t2.length;i++){
            var id = t2[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo Contabilidad
    var selectmodulo3acto = function () {

        var t3 = tree3.jstree().get_json('#', {flat:true});
        for(var i=0;i<t3.length;i++){
            var id = t3[i].id;
            tree3.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo3desac = function () {

        tree3.jstree("deselect_all");
        var t3 = tree3.jstree().get_json('#', {flat:true});
        for(var i=0;i<t3.length;i++){
            var id = t3[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo compras
    var selectmodulo4acto = function () {

        var t4 = tree4.jstree().get_json('#', {flat:true});
        for(var i=0;i<t4.length;i++){
            var id = t4[i].id;
            tree4.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo4desac = function () {

        tree4.jstree("deselect_all");
        var t4 = tree4.jstree().get_json('#', {flat:true});
        for(var i=0;i<t4.length;i++){
            var id = t4[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo ventas
    var selectmodulo5acto = function () {

        var t5 = tree5.jstree().get_json('#', {flat:true});
        for(var i=0;i<t5.length;i++){
            var id = t5[i].id;
            tree5.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo5desac = function () {

        tree5.jstree("deselect_all");
        var t5 = tree5.jstree().get_json('#', {flat:true});
        for(var i=0;i<t5.length;i++){
            var id = t5[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo RRHH
    var selectmodulo6acto = function () {

        var t6 = tree6.jstree().get_json('#', {flat:true});
        for(var i=0;i<t6.length;i++){
            var id = t6[i].id;
            tree6.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo6desac = function () {

        tree6.jstree("deselect_all");
        var t6 = tree6.jstree().get_json('#', {flat:true});
        for(var i=0;i<t6.length;i++){
            var id = t6[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo activos fijos
    var selectmodulo7acto = function () {

        var t7 = tree7.jstree().get_json('#', {flat:true});
        for(var i=0;i<t7.length;i++){
            var id = t7[i].id;
            tree7.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo7desac = function () {

        tree7.jstree("deselect_all");
        var t7 = tree7.jstree().get_json('#', {flat:true});
        for(var i=0;i<t7.length;i++){
            var id = t7[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo Produccion
    var selectmodulo8acto = function () {

        var t8 = tree8.jstree().get_json('#', {flat:true});
        for(var i=0;i<t8.length;i++){
            var id = t8[i].id;
            tree8.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo8desac = function () {

        tree8.jstree("deselect_all");
        var t8 = tree8.jstree().get_json('#', {flat:true});
        for(var i=0;i<t8.length;i++){
            var id = t8[i].id;
            selaccesconsulta(id);
        }
    }
    // seleccionar Modulo CRM
    var selectmodulo9acto = function () {

        var t9 = tree9.jstree().get_json('#', {flat:true});
        for(var i=0;i<t9.length;i++){
            var id = t9[i].id;
            tree9.jstree("check_node", "#"+id);
            selaccestotal(id);
        }
    }
    var selectmodulo9desac = function () {

        tree9.jstree("deselect_all");
        var t9 = tree9.jstree().get_json('#', {flat:true});
        for(var i=0;i<t9.length;i++){
            var id = t9[i].id;
            selaccesconsulta(id);
        }
    }

     // seleccionar Acceso total
     var selaccestotal = function (id) {

        $("#" + id + "").children().children().children()[1].classList.remove("font-green-sharp");
        $("#" + id + "").children().children().children()[1].classList.remove("checked");
        $("#" + id + "").children().children().children()[2].classList.remove("font-green-sharp");
        $("#" + id + "").children().children().children()[2].classList.remove("checked");
        $("#" + id + "").children().children().children()[0].classList.add("font-green-sharp");
        $("#" + id + "").children().children().children()[0].classList.add("checked");
    }

    // seleccionar Acceso Parcial
    var selaccesparcial = function (id) {

        $("#" + id + "").children().children().children()[0].classList.remove("font-green-sharp");
        $("#" + id + "").children().children().children()[0].classList.remove("checked");
        $("#" + id + "").children().children().children()[2].classList.remove("font-green-sharp");
        $("#" + id + "").children().children().children()[2].classList.remove("checked");
        $("#" + id + "").children().children().children()[1].classList.add("font-green-sharp");
        $("#" + id + "").children().children().children()[1].classList.add("checked");
    }

    // seleccionar Acceso consulta
    var selaccesconsulta = function (id) {

        $("#" + id + "").children().children().children()[0].classList.remove("font-green-sharp");
        $("#" + id + "").children().children().children()[0].classList.remove("checked");
        $("#" + id + "").children().children().children()[1].classList.remove("font-green-sharp");
        $("#" + id + "").children().children().children()[1].classList.remove("checked");
        $("#" + id + "").children().children().children()[2].classList.add("font-green-sharp");
        $("#" + id + "").children().children().children()[2].classList.add("checked");
    }


    var handleSearchDatatable = function () {

        const filterSearch = document.querySelector('[data-kt-usuarios-table-filter="search"]');

        filterSearch.addEventListener('keyup', function (e) {

            dt.search(e.target.value).draw();
        });
    }

    // Public methods
    return {
        init: function () {

            init();
            selectipoacceso();
            selectdeselectmodulo();
            initSaveConfig();
            handleSearchDatatable();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
