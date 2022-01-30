"use strict";
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var List = [];

    var idEmpresa = document.querySelector('[name="idempresa"]').value;

    // Private functions
    var initListarUsuarios = function () {

        var datausuarios;
        var dataValue;
        var users;
        var urlfinal= urlBase + "usuarios/listarusuarios";

        //Sent Ajax
        datausuarios = {

            idem: idEmpresa
        },

        dataValue = JSON.stringify(datausuarios),

        $.ajax({
            type: "POST",
            url: urlfinal,
            contentType: "application/json; charset=utf-8",
            data: dataValue,
            dataType: "json",
            success: function (res) {

                var usuarios = res.Usuarios;
                var empresas = res.empresas;
                var TipoUsuario = res.TipoUsuario;

                //formatear datos
                for(var i=0;i<usuarios.length;i++){
                    //empresa
                        var idemp = usuarios[i].idempresa;
                        if(idemp==null){
                            usuarios[i].idempresa = "-";
                        }else{
                            for(var j=0;j<empresas.length;j++){
                                if(empresas[j].id==idemp){
                                    usuarios[i].idempresa = empresas[j].Nombre;
                                }
                            }
                        }
                    //tipoUsuario
                        var tius = usuarios[i].TipoUsuario;
                        for(var j=0;j<TipoUsuario.length;j++){
                            if(TipoUsuario[j].id==tius){
                                usuarios[i].TipoUsuario = TipoUsuario[j].Tipo;
                            }
                        }
                }

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
                    data:usuarios,

                    select: {
                        style: 'os',
                        selector: 'td:first-child',
                        className: 'row-selected'
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'nombre' },
                        { data: 'apellido' },
                        { data: 'email',className: 'text-center' },
                        { data: 'TipoUsuario',className: 'text-center' },
                        { data: 'idempresa',className: 'text-center' },
                        { data: null },

                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                            render: function (data) {
                                return `
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="${data}" />
                                    </div>`;
                            }
                        },
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-end',
                            render: function (data, type, row) {

                                return`
                                        <a data-kt-action="Gestionar_Perfil" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfil">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-edit" class="svg-inline--fa fa-user-edit fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                                    <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9 1.2-11.1 7.9-7.9 77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5zm45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8 137.9-137.9-71.7-71.7-137.9 137.8zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8-4.1 4.1 71.8 71.7 41.8-41.8c9.3-9.4 9.3-24.5 0-33.9z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    `;
                            },
                        },
                    ],
                    // Add data array
                    createdRow: function (row, data, dataIndex) {

                        // var l = [];

                        //     l['IdEntrada'] = data.IdEntrada;
                        //     l['OrdenEntrada'] = data.Orden;

                        //     ListOrden.push(l);
                    }
                });

                table = dt.$;

                initToggleToolbar();
                toggleToolbars();

                $('[data-bs-toggle="tooltip"]').tooltip();
                //initEditEntrada();
                //initStateEntrada();
                initRedirectPerfil();

                KTMenu.createInstances()

            }
        });
    }

    // Init AgregarActualizar
    var initAgregarActualizar = function () {

         //console.log(ListImgs);

        var t, e, o, n, r, i, b, c, h;

        i = new bootstrap.Modal(document.querySelector("#kt_modal_add_usuario")),
        r = document.querySelector("#kt_modal_add_usuario_form"),
        b = document.querySelector("#btnAddusuario"),
        c = document.querySelector("#kt_select_Empresa"),
        h = document.querySelector("#kt_select_Sucursal"),

        t = r.querySelector("#kt_modal_add_usuario_submit"),
        e = r.querySelector("#kt_modal_add_usuario_cancel"),
        o = r.querySelector("#kt_modal_add_usuario_close"),

        n = FormValidation.formValidation(r, {
            fields: {
                TxtUsuario: {
                    validators: {
                        notEmpty: {
                            message: "El Usuario es Obligatorio"
                        }
                    }
                },
                TxtCorreo: {
                    validators: {
                        notEmpty: {
                            message: "El Correo es Obligatorio"
                        },
                        emailAddress: {
                            message: "No es una direccion de Correo"
                        },
                    }
                },
                TxtContra: {
                    validators: {
                        notEmpty: {
                            message: "La Contraseña es Obligatorio"
                        },
                        stringLength: {
                            min: 6,
                            message: "Debe tener al menos 6 digitos",
                        },
                    }
                },
                TxtConfiContra: {
                    validators: {
                        notEmpty: {
                            message: "Confirmar la Contraseña es Obligatorio"
                        },
                        identical: {
                            compare: function () {
                                return r.querySelector('[name="TxtContra"]').value;
                            },
                            message: 'Las Contraseñas no coinciden'
                        }
                    }
                },
                TxtCi: {
                    validators: {
                        notEmpty: {
                            message: "El Ci es Obligatorio"
                        }
                    }
                },
                TxtNit: {
                    validators: {
                        notEmpty: {
                            message: "El Nit es Obligatorio"
                        },
                        stringLength: {
                            min: 15,
                            max: 15,
                            message: "El Nit debe ser de 15 digitos",
                        },
                        regexp: {
                            regexp: /^[0-9_]+$/,
                            message: "El Nit solo debe ser numeros",
                        },
                    }
                },
                TxtNombre: {
                    validators: {
                        notEmpty: {
                            message: "El Nombre es Obligatorio"
                        }
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: ""
                }),
            }
        }),

        //Validacion Numeric Input
        // Inputmask("decimal",{
        //     "mask": "9",
        //     "repeat": 10,
        //     "greedy": false,
        // }).mask("#kt_inputmask_orden");

        //DateTime input Modal
        $("#kt_date_FecNaci").flatpickr(

            {
                altInput: true,
                altFormat: "j F, Y",
                dateFormat: "Y-m-d",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                      shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                      longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    },
                    months: {
                      shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                      longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    },
                },
            }
        );

        if (idEmpresa == 0) {
             //Cargar sucursales por empresa
            $(c).on('change',function(){
                var idemp = $(c).val();
                if(idemp!=0){
                    var data={
                        IdEmpresa: idemp
                    };
                    var urlfinal= urlBase + "sucursales/listadesucursales";
                    var dataValue = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: dataValue,
                        dataType: "json",
                        success: function (res) {
                            if(res.tipoMensaje=="success"){
                                var Sucursales = res.Sucursales
                                limpiarsucursales();
                                for(var i=0;i<Sucursales.length;i++){
                                    $(h).prepend("<option value='"+Sucursales[i].id+"'>"+Sucursales[i].alias +" - "+Sucursales[i].direccion+"</option>");
                                }
                            }else{
                                toastr.error(res.mensaje);
                            }
                        // tooltipnow();
                        },
                        error: function(res){
                            toastr.error(res);
                        }
                    });
                }else{
                    limpiarsucursales();
                }
            });
            function limpiarsucursales(){
                $(h).html("<option value='0'>sin sucursal</option>");
            }
        }

        //Select Modal
        b.addEventListener("click", (function(){

            r.querySelector('[name="TitleModal"]').innerText = "Agregar Usuario";

            if(idEmpresa==0){


            }
            else{

                //SelectComboTipoUser
                var ComboTipoUsers = $("#kt_select_TipoUser");
                ComboTipoUsers.children().each(function () {

                    if (this.value == 2) {

                        this.remove();

                        var $newOption = $("<option selected='selected'></option>").val(this.value).text(this.text);
                        ComboTipoUsers.append($newOption).trigger('change');
                        ComboTipoUsers.prop('disabled', true);
                    }
                });

                //SelectComboEmpresas
                var ComboEmpresas = $("#kt_select_Empresa");
                ComboEmpresas.children().each(function () {

                    if (this.value == idEmpresa) {

                        this.remove();

                        var $newOption = $("<option selected='selected'></option>").val(this.value).text(this.text);
                        ComboEmpresas.append($newOption).trigger('change');
                        ComboEmpresas.prop('disabled', true);
                    }
                });

                //$('#kt_select_TipoUser').val(2).trigger('change');
                //$('#kt_select_TipoUser').trigger('change');
                //$('#kt_select_TipoUser').prop('disabled', true);

                //$('[name=ComboEmpresas]').val(idEmpresa).trigger('change');
                // $('#kt_select_Empresa').val(idEmpresa);
                // $('#kt_select_Empresa').trigger('change');
                //$('#kt_select_Empresa').prop('disabled', true);
            }

            t.value = "";
            r.reset();

        })),

        t.addEventListener("click", (function(e) {

            var urlfinal;

            var MensajeSwalValidacion;

            var Usuario = r.querySelector('[name="TxtUsuario"]').value;
            var Correo = r.querySelector('[name="TxtCorreo"]').value;
            var Contra = r.querySelector('[name="TxtContra"]').value;
            var Ci = r.querySelector('[name="TxtCi"]').value;
            var Nit = r.querySelector('[name="TxtNit"]').value;
            var Nombre = r.querySelector('[name="TxtNombre"]').value;
            var Apellido = r.querySelector('[name="TxtApellido"]').value;
            var Telefono = r.querySelector('[name="TxtTelefono"]').value;
            var Celular = r.querySelector('[name="TxtCelular"]').value;
            var Cargo = r.querySelector('[name="TxtCargo"]').value;
            var Direccion = r.querySelector('[name="TxtDireccion"]').value;
            var FecNaci = r.querySelector('[name="FecNaci"]').value;
            var ComboTipoUser = r.querySelector('[name="ComboTipoUser"]').value;
            var ComboEmpresas = r.querySelector('[name="ComboEmpresas"]').value;
            var ComboSucursales = r.querySelector('[name="ComboSucursales"]').value;

            var IdRowusuario = "";
            var TipoMensajeSwal = "";
            var MensajeSwal = "";

            var formData;

            if (t.value != "") {

                IdRowusuario = t.value;
            }

            MensajeSwalValidacion = "Complete los campos obligatorios";


            e.preventDefault(), n && n.validate().then((function(e) {

                // console.log("validated!"),

                "Valid" == e? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0,

                    formData = new FormData(),
                    formData.append('Nombre', Usuario),
                    formData.append('ci', Ci),
                    formData.append('nit', Nit),
                    formData.append('Name', Nombre),
                    formData.append('Apellido', Apellido),
                    formData.append('celular', Celular),
                    formData.append('Telefono', Telefono),
                    formData.append('direccion', Direccion),
                    formData.append('fecnac', FecNaci),
                    formData.append('Cargo', Cargo),
                    formData.append('Correo', Correo),
                    formData.append('Password', Contra),
                    formData.append('TipoUsuario', ComboTipoUser),
                    formData.append('Empresa', ComboEmpresas),
                    formData.append('Sucursal', ComboSucursales),

                    urlfinal= urlBase + "usuarios/crear-usuario",
                    // dataValue = JSON.stringify(dataentrada),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            if (res.titulo = "Success") {
                                TipoMensajeSwal = res.tipoMensaje;
                                MensajeSwal = res.mensaje;
                            }
                            if (res.titulo = "Update") {
                                TipoMensajeSwal = res.tipoMensaje;
                                MensajeSwal = res.mensaje;
                            }
                            if (res.titulo = "Error") {
                                TipoMensajeSwal = res.tipoMensaje;
                                MensajeSwal = res.mensaje;
                                //console.log(MensajeSwal);
                            }

                            setTimeout((function() {

                                t.removeAttribute("data-kt-indicator"), Swal.fire({
                                    text : MensajeSwal,
                                    icon: TipoMensajeSwal,
                                    buttonsStyling: !1,
                                    showConfirmButton: false,
                                    buttonsStyling: false,
                                    timer: 1000


                                }).then((function(e) {
                                    if (TipoMensajeSwal == "error") {

                                        t.disabled = !1
                                        //i.hide()
                                    }
                                    else {
                                        // e.isConfirmed && (i.hide(), t.disabled = !1, window.location = r.getAttribute("data-kt-redirect"))
                                        i.hide(),
                                        t.disabled = !1
                                        window.location = r.getAttribute("data-kt-redirect")
                                    }
                                }))

                            }), 1e1)
                        },
                        error: function(res){

                            // toastr.error("Error no controlado, comuniquese con el administrador");
                        }
                    })

                ): Swal.fire({
                    text: MensajeSwalValidacion,
                    icon: "error",
                    buttonsStyling: !1,
                    showConfirmButton: false,
                    buttonsStyling: false,
                    timer: 1000
                })
            }))
        })),

        e.addEventListener("click", (function(t) {
            r.reset()
            i.hide()

        })),

        o.addEventListener("click", (function() {

            r.reset()
            i.hide()

        }))
    }

    // Editar Entrada
    var initEditEntrada = function() {

        var t, e, o, n, r, i, contentImgs, htm;

        //i = new bootstrap.Modal(document.querySelector("#kt_modal_add_categoria"));
        r = document.querySelector("#kt_modal_add_entrada_form");
        //t = r.querySelector("#kt_modal_add_customer_header");
        t = r.querySelector("#kt_modal_add_entrada_submit");
        //o = r.querySelector("#idEntradaTable");

        const EditButton = document.querySelectorAll('[data-kt-action="Entrada_edit"]');

        EditButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();
                // Select parent row
                const parent = e.target.closest('tr');

                // Get entrada datos
                const entradaId = parent.querySelectorAll('td')[0].children[0].children[0].value;
                const entradaName = parent.querySelectorAll('td')[1].innerText;
                const entradaTitle = parent.querySelectorAll('td')[2].innerText;
                const entradaDescrip = parent.querySelectorAll('td')[3].innerText;
                const entradaOrden = parent.querySelectorAll('td')[4].innerText;

                // Insert datos entrada
                r.querySelector('[name="TitleModal"]').innerText = "Editar Entrada";
                r.querySelector('[name="TxtNombre"]').value = entradaName;
                r.querySelector('[name="TxtTitulo"]').value = entradaTitle;
                r.querySelector('[name="TxtOrden"]').value = entradaOrden;
                r.querySelector('[name="TxtTexto"]').value = entradaDescrip;
                t.value = entradaId;

            });

        });
    }

    // Cambiar Estado entrada
    var initStateEntrada = function() {

        var t, e, o, n, r, i;

        const ChangeStateButton = document.querySelectorAll('[data-kt-action="entrada_sw_state"]');

        ChangeStateButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                var dataentrada;
                var urlfinal;
                var dataValue;

                var Mensaje = "";
                // Select parent row
                const parent = e.target.closest('tr');

                // Get entrada datos
                const entradaId = parent.querySelectorAll('td')[0].children[0].children[0].value;

                //Sent Ajax
                dataentrada = {

                    IdUserActual:  1,
                    IdEntrada: entradaId
                },

                urlfinal= urlBase + "/HabilitarDeshabilitarEntrada",
                dataValue = JSON.stringify(dataentrada),

                $.ajax({
                    type: "POST",
                    url: urlfinal,
                    contentType: "application/json; charset=utf-8",
                    data: dataValue,
                    dataType: "json",
                    success: function (res) {
                       // console.log(res);
                        if (res.titulo = "Success") {

                            Mensaje = res.mensaje;

                            toastr.success(Mensaje);

                            window.location = location.href;
                        }

                    },
                    error: function(res){

                        // toastr.error("Error no controlado, comuniquese con el administrador");
                    }
                });

            });

        });
    }

    // ButtonRedirecPerfil
    var initRedirectPerfil = function() {

        const GestionPerfilButton = document.querySelectorAll('[data-kt-action="Gestionar_Perfil"]');

        GestionPerfilButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get perfil datos
                const perfilId = parent.querySelectorAll('td')[0].children[0].children[0].value;

                // RediretPagina
                window.location = urlBase + "usuarios/"+idEmpresa+"/"+perfilId;



            });

        });
    }


    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector('#kt_datatable_usuarios');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-usuario-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        // Deleted selected rows
        deleteSelected.addEventListener('click', function () {

            // Select refreshed checkbox DOM elements
            var datausuario;
            var urlfinal;
            var dataValue;
            var ArrayRowSelect=[];
            var Mensaje = "";

            const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

            // Fill Array
            allCheckboxes.forEach(c => {
                if (c.checked) {
                    ArrayRowSelect.push(c.value);
                }
            })

            Swal.fire({
                text: "¿Esta seguro que quiere eliminar los usuarios seleccionados?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                confirmButtonText: "Si",
                cancelButtonText: "No",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                },
            }).then(function (result) {
                if (result.value) {

                    Swal.fire({
                        text: "Eliminando usuarios seleccionados",
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false
                    });

                    //Sent Ajax
                    datausuario = {

                        IdRowSelected: ArrayRowSelect
                    },

                    urlfinal= urlBase + "usuarios/eliminar-usuario",
                    dataValue = JSON.stringify(datausuario),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: dataValue,
                        dataType: "json",
                        success: function (res) {
                            Swal.close();

                            Swal.fire({
                                text: "Usuarios Eliminados!.",
                                icon: "success",
                                buttonsStyling: !1,
                                showConfirmButton: false,
                                buttonsStyling: false,
                                timer: 1000

                            }).then(function () {
                                window.location = location.href;
                                // delete row data from server and re-draw datatable
                                //dt.draw();
                            });

                            // Remove header checked box
                            const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                            headerCheckbox.checked = false;
                        },
                        error: function(res){

                            // toastr.error("Error no controlado, comuniquese con el administrador");
                        }
                    });
                }
                else if (result.dismiss === 'cancel') {

                    Swal.close();
                 }
            });
        });
    }

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_datatable_usuarios');
        const toolbarBase = document.querySelector('[data-kt-usuarios-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-usuarios-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-usuarios-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-usuarios-table-filter="search"]');

        filterSearch.addEventListener('keyup', function (e) {

            dt.search(e.target.value).draw();
        });
    }

    // Public methods
    return {
        init: function () {

            initListarUsuarios();
            initAgregarActualizar();

            handleSearchDatatable();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

