"use strict";
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables

    var idEmpresa = document.querySelector('[name="idempresa"]').value;
    var idUsuario = document.querySelector('[name="idussersel"]').value;

    var ListData = [];

    // Private functions
    var initObtenerUsuario = function () {

        var datausuario;
        var dataValue;

        var urlfinal= urlBase + "usuarios/TraerUsuario";

        //Sent Ajax
        datausuario = {

            idusuario: idUsuario
        },

        dataValue = JSON.stringify(datausuario),

        $.ajax({
            type: "POST",
            url: urlfinal,
            contentType: "application/json; charset=utf-8",
            data: dataValue,
            dataType: "json",
            success: function (res) {

                var usuario = res.Usuario;
                var empresas = res.Empresas;
                var persona = res.Persona;
                //formatear datos
                //empresa
                if(res.Usuario.idempresa==null){
                    res.Usuario.idempresa = 0;
                }
                if(res.Usuario.idsucursal==null){
                    res.Usuario.idsucursal = 0;
                }

                // var l = [];

                // var u = [];
                // u['NameUsuario'] = usuario.name;
                // u['Cargo'] =  usuario.cargo;
                // u['IdEmpresa'] =  usuario.idempresa;
                // u['IdSucursal'] =  usuario.idsucursal;

                // l['DatosCuenta'] = u;

                //var p = [];

                //ListData.push(l);

                CargarDatos(
                    usuario.name,
                    usuario.nombre,
                    usuario.apellido,
                    usuario.email,
                    persona.email,
                    usuario.telefono,
                    usuario.cargo,
                    usuario.idempresa,
                    usuario.idsucursal,
                    usuario.TipoUsuario,
                    persona.ci,
                    persona.nit,
                    persona.celular,
                    persona.direccion,
                    persona.fecha_de_nacimiento,
                    persona.nombres,
                    persona.apellidos,
                    persona.telefono);

                KTMenu.createInstances()

            }
        });

    }

     // CargarDatos
    var CargarDatos = function(usuario,nombre,apellido,mail,mailper,telefono,cargo,empresa,sucursal,tius,ci,nit,cel,dir,fnac,nombresper,apellidosper,telefonoper) {

        var t, e, o, n, r, i;

        // Insert datos de cuenta
        r = document.querySelector("#kt_datos_cuenta_form");

        r.querySelector('[name="TxtUsuario"]').value = usuario;
        r.querySelector('[name="TxtCargo"]').value = cargo;
        $('#kt_select_ComboEmpresas').val(empresa).trigger('change');
        $('#kt_select_ComboSucursales').val(sucursal).trigger('change');


        // Insert datos personales
        i = document.querySelector("#kt_datos_personales_form");

        i.querySelector('[name="TxtNombre"]').value = nombresper;
        i.querySelector('[name="TxtApellido"]').value = apellidosper;
        //DateTime input
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
                defaultDate: fnac,
            }
        );
        i.querySelector('[name="TxtCi"]').value = ci;
        i.querySelector('[name="TxtNit"]').value = nit;
        i.querySelector('[name="TxtTelefono"]').value = telefonoper;
        i.querySelector('[name="TxtCelular"]').value = cel;
        i.querySelector('[name="TxtCorreo"]').value = mailper;
        i.querySelector('[name="TxtDireccion"]').value = dir;


        // Insert datos inicio sesion
        n = document.querySelector("#kt_signin_change_email_form");
        //n.reset();
        n.querySelector('[name="emailaddress"]').value = mail;
    }

    // Init AgregarActualizar
    var initAgregarActualizar = function () {

        // Guardar datos de la cuenta
        var t, e, n, r;

        r = document.querySelector("#kt_datos_cuenta_form"),
        t = r.querySelector("#kt_datoscuenta_submit"),
        e = r.querySelector("#kt_datoscuenta_cancel"),

        n = FormValidation.formValidation(r, {
            fields: {
                TxtUsuario: {
                    validators: {
                        notEmpty: {
                            message: "El Usuario es Obligatorio"
                        }
                    }
                },
                TxtCargo: {
                    validators: {
                        notEmpty: {
                            message: "El Cargo es Obligatorio"
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

        t.addEventListener("click", (function(e) {

            var urlfinal;

            var MensajeSwalValidacion;

            var Usuario = r.querySelector('[name="TxtUsuario"]').value;
            var Cargo = r.querySelector('[name="TxtCargo"]').value;
            var ComboEmpresas = r.querySelector('[name="ComboEmpresas"]').value;
            var ComboSucursales = r.querySelector('[name="ComboSucursales"]').value;

            var TipoMensajeSwal = "";
            var MensajeSwal = "";

            var formData;

            MensajeSwalValidacion = "Complete los campos obligatorios";

            e.preventDefault(), n && n.validate().then((function(e) {

                "Valid" == e? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0,

                    formData = new FormData(),
                    formData.append('IdUsuario', idUsuario),
                    formData.append('NameUsuario', Usuario),
                    formData.append('Cargo', Cargo),
                    formData.append('Empresa', ComboEmpresas),
                    formData.append('Sucursal', ComboSucursales),

                    urlfinal= urlBase + "usuarios/actualizar-datoscuenta",
                    // dataValue = JSON.stringify(dataentrada),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {

                            var usuario = res.Usuario;

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

                                        t.disabled = !1
                                        //window.location = r.getAttribute("data-kt-redirect")
                                        window.location = urlBase + "usuarios/"+idEmpresa+"/"+idUsuario;
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

            // ListData.forEach(u => {

            //     if (u == "DatosCuenta") {



            //         r.querySelector('[name="TxtUsuario"]').value = usuario.name;
            //         r.querySelector('[name="TxtCargo"]').value = usuario.cargo;
            //         $('#kt_select_ComboEmpresas').val(usuario.idempresa).trigger('change');
            //         $('#kt_select_ComboSucursales').val(usuario.idsucursal).trigger('change');
            //     }
            // });
            //r.reset()
        }))


        // Guardar metodo inicio sesion correo
        var f, g, h;

        f = document.querySelector("#kt_signin_change_email_form"),
        g = f.querySelector("#kt_signin_submit"),

        h = FormValidation.formValidation(f, {
            fields: {
                emailaddress: {
                    validators: {
                        notEmpty: {
                            message: "El Correo es Obligatorio"
                        },
                        emailAddress: {
                            message: "No es una direccion de Correo"
                        },
                    }
                },
                confirmemailpassword: {
                    validators: {
                        notEmpty: {
                            message: "La Contraseña es Obligatorio"
                        },
                        stringLength: {
                            min: 6,
                            message: "Digitos de Contraseña Incompletos",
                        },
                    }
                },
                // TxtConfiContra: {
                //     validators: {
                //         notEmpty: {
                //             message: "Confirmar la Contraseña es Obligatorio"
                //         },
                //         identical: {
                //             compare: function () {
                //                 return r.querySelector('[name="TxtContra"]').value;
                //             },
                //             message: 'Las Contraseñas no coinciden'
                //         }
                //     }
                // },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                //submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row"
                }),
            }

        }),

        g.addEventListener("click", (function(e) {

            var urlfinal;

            var MensajeSwalValidacion;

            var Correo = f.querySelector('[name="emailaddress"]').value;
            var Contra = f.querySelector('[name="confirmemailpassword"]').value;

            var TipoMensajeSwal = "";
            var MensajeSwal = "";

            var formData;

            MensajeSwalValidacion = "Complete los campos obligatorios";

            e.preventDefault(), h && h.validate().then((function(e) {

                "Valid" == e? (g.setAttribute("data-kt-indicator", "on"), g.disabled = !0,

                    formData = new FormData(),
                    formData.append('IdUsuario', idUsuario),
                    formData.append('Correo', Correo),
                    formData.append('Contra', Contra),

                    urlfinal= urlBase + "usuarios/actualizar-iniciosesion-correo",
                    // dataValue = JSON.stringify(dataentrada),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {

                            var usuario = res.Usuario;

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

                                g.removeAttribute("data-kt-indicator"), Swal.fire({
                                    text : MensajeSwal,
                                    icon: TipoMensajeSwal,
                                    buttonsStyling: !1,
                                    showConfirmButton: false,
                                    buttonsStyling: false,
                                    timer: 1000


                                }).then((function(e) {
                                    if (TipoMensajeSwal == "error") {

                                        g.disabled = !1
                                        //i.hide()
                                    }
                                    else {

                                        g.disabled = !1
                                       // window.location = a.getAttribute("data-kt-redirect")
                                        window.location = urlBase + "usuarios/"+idEmpresa+"/"+idUsuario;
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
        }))

        // Guardar metodo inicio sesion Contraseña
        var i, j, k;

        i = document.querySelector("#kt_signin_change_password_form"),
        j = i.querySelector("#kt_password_submit"),

        k = FormValidation.formValidation(i, {
            fields: {
                currentpassword: {
                    validators: {
                        notEmpty: {
                            message: "La Actual Contraseña es Obligatorio"
                        },
                        stringLength: {
                            min: 6,
                            message: "Digitos de Contraseña Incompletos",
                        },
                    }
                },
                newpassword: {
                    validators: {
                        notEmpty: {
                            message: "La Nueva Contraseña es Obligatorio"
                        },
                        stringLength: {
                            min: 6,
                            message: "Debe tener al menos 6 digitos",
                        },
                    }
                },
                confirmpassword: {
                    validators: {
                        notEmpty: {
                            message: "Confirmar Nueva Contraseña es Obligatorio"
                        },
                        identical: {
                            compare: function () {
                                return i.querySelector('[name="newpassword"]').value;
                            },
                            message: 'Las Contraseñas no coinciden'
                        }
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                //submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row"
                }),
            }

        }),

        j.addEventListener("click", (function(e) {

            var urlfinal;

            var MensajeSwalValidacion;

            var ActualContra = i.querySelector('[name="currentpassword"]').value;
            var NuevaContra = i.querySelector('[name="newpassword"]').value;

            var TipoMensajeSwal = "";
            var MensajeSwal = "";

            var formData;

            MensajeSwalValidacion = "Complete los campos obligatorios";

            e.preventDefault(), k && k.validate().then((function(e) {

                "Valid" == e? (j.setAttribute("data-kt-indicator", "on"), j.disabled = !0,

                    formData = new FormData(),
                    formData.append('IdUsuario', idUsuario),
                    formData.append('ActualContra', ActualContra),
                    formData.append('NuevaContra', NuevaContra),

                    urlfinal= urlBase + "usuarios/actualizar-iniciosesion-contra",
                    // dataValue = JSON.stringify(dataentrada),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {

                            var usuario = res.Usuario;

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

                                j.removeAttribute("data-kt-indicator"), Swal.fire({
                                    text : MensajeSwal,
                                    icon: TipoMensajeSwal,
                                    buttonsStyling: !1,
                                    showConfirmButton: false,
                                    buttonsStyling: false,
                                    timer: 1000


                                }).then((function(e) {
                                    if (TipoMensajeSwal == "error") {

                                        j.disabled = !1
                                        //i.hide()
                                    }
                                    else {

                                        j.disabled = !1
                                       // window.location = a.getAttribute("data-kt-redirect")
                                        window.location = urlBase + "usuarios/"+idEmpresa+"/"+idUsuario;
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
        }))

        // Guardar datos personales
        var a, b, c, d;

        a = document.querySelector("#kt_datos_personales_form"),
        b = a.querySelector("#kt_datospersonales_submit"),
        c = a.querySelector("#kt_datospersonales_cancel"),

        d = FormValidation.formValidation(a, {
            fields: {
                TxtNombre: {
                    validators: {
                        notEmpty: {
                            message: "El Nombre es Obligatorio"
                        }
                    }
                },
                TxtCorreo: {
                    validators: {
                        emailAddress: {
                            message: "No es una direccion de Correo"
                        },
                    }
                },
                TxtNit: {
                    validators: {
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
                // TxtContra: {
                //     validators: {
                //         notEmpty: {
                //             message: "La Contraseña es Obligatorio"
                //         },
                //         stringLength: {
                //             min: 6,
                //             message: "Debe tener al menos 6 digitos",
                //         },
                //     }
                // },
                // TxtConfiContra: {
                //     validators: {
                //         notEmpty: {
                //             message: "Confirmar la Contraseña es Obligatorio"
                //         },
                //         identical: {
                //             compare: function () {
                //                 return r.querySelector('[name="TxtContra"]').value;
                //             },
                //             message: 'Las Contraseñas no coinciden'
                //         }
                //     }
                // },
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

        b.addEventListener("click", (function(e) {

            var urlfinal;

            var InputVacios = false;
            var MensajeSwalValidacion;

            var Nombre = a.querySelector('[name="TxtNombre"]').value;
            var Apellido = a.querySelector('[name="TxtApellido"]').value;
            var FecNaci = a.querySelector('[name="FecNaci"]').value;
            var Ci = a.querySelector('[name="TxtCi"]').value;
            var Nit = a.querySelector('[name="TxtNit"]').value;
            var Telefono = a.querySelector('[name="TxtTelefono"]').value;
            var Celular = a.querySelector('[name="TxtCelular"]').value;
            var Correo = a.querySelector('[name="TxtCorreo"]').value;
            var Direccion = a.querySelector('[name="TxtDireccion"]').value;

            var TipoMensajeSwal = "";
            var MensajeSwal = "";

            var formData;

            if (Ci == "" && Nit == "") {

                InputVacios = true;
                MensajeSwalValidacion = "Es necesario al menos CI o NIT";
            }
            else{

                MensajeSwalValidacion = "Complete los campos obligatorios";
            }

            e.preventDefault(), d && d.validate().then((function(e) {

                "Valid" == e && InputVacios == false? (b.setAttribute("data-kt-indicator", "on"), b.disabled = !0,

                    formData = new FormData(),
                    formData.append('IdUsuario', idUsuario),
                    formData.append('Nombre', Nombre),
                    formData.append('Apellido', Apellido),
                    formData.append('FechaNaci', FecNaci),
                    formData.append('Ci', Ci),
                    formData.append('Nit', Nit),
                    formData.append('Telefono', Telefono),
                    formData.append('Celular', Celular),
                    formData.append('Correo', Correo),
                    formData.append('Direccion', Direccion),

                    urlfinal= urlBase + "usuarios/actualizar-datospersonales",
                    // dataValue = JSON.stringify(dataentrada),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {

                            var usuario = res.Usuario;

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
                                        //i.hide()
                                    }
                                    else {

                                        b.disabled = !1
                                       // window.location = a.getAttribute("data-kt-redirect")
                                        window.location = urlBase + "usuarios/"+idEmpresa+"/"+idUsuario;
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

        c.addEventListener("click", (function(t) {

            // ListData.forEach(u => {

            //     if (u == "DatosCuenta") {



            //         r.querySelector('[name="TxtUsuario"]').value = usuario.name;
            //         r.querySelector('[name="TxtCargo"]').value = usuario.cargo;
            //         $('#kt_select_ComboEmpresas').val(usuario.idempresa).trigger('change');
            //         $('#kt_select_ComboSucursales').val(usuario.idsucursal).trigger('change');
            //     }
            // });
            //r.reset()
        }))
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

    // Buttons ChangeEmail and ChangePass
    var initActionsButtons = function () {

        var o, t, e, s, r, a, n, i;

        o = document.getElementById("kt_signin_email_button");
        t = document.getElementById("kt_signin_email");
        e = document.getElementById("kt_signin_email_edit");
        s = document.getElementById("kt_signin_cancel");
        r = document.getElementById("kt_signin_password_button");
        n = document.getElementById("kt_signin_password");
        i = document.getElementById("kt_signin_password_edit")
        a = document.getElementById("kt_password_cancel");

        o.querySelector("button").addEventListener("click", (function()
            {
                l();
            }
        ));
        s.addEventListener("click", (function()
            {
                l();
            }
        ));

        r.querySelector("button").addEventListener("click", (function()
            {
                d();
            }
        ));
        a.addEventListener("click", (function()
            {
                d();
            }
        ));

        var l, d;

        l = function() {
            t.classList.toggle("d-none"),
            o.classList.toggle("d-none"),
            e.classList.toggle("d-none")
        }

        d = function() {
            n.classList.toggle("d-none"),
            r.classList.toggle("d-none"),
            i.classList.toggle("d-none")
        }

    }

    // init: function() {
    //     var t, e;
    //     !function() {
    //         var t = document.getElementById("kt_signin_email")
    //           , e = document.getElementById("kt_signin_email_edit")
    //           , n = document.getElementById("kt_signin_password")
    //           , i = document.getElementById("kt_signin_password_edit")
    //           , o = document.getElementById("kt_signin_email_button")
    //           , s = document.getElementById("kt_signin_cancel")
    //           , r = document.getElementById("kt_signin_password_button")
    //           , a = document.getElementById("kt_password_cancel");
    //         o.querySelector("button").addEventListener("click", (function() {
    //             l()
    //         }
    //         )),
    //         s.addEventListener("click", (function() {
    //             l()
    //         }
    //         )),
    //         r.querySelector("button").addEventListener("click", (function() {
    //             d()
    //         }
    //         )),
    //         a.addEventListener("click", (function() {
    //             d()
    //         }
    //         ));
    //         var l = function() {
    //             t.classList.toggle("d-none"),
    //             o.classList.toggle("d-none"),
    //             e.classList.toggle("d-none")
    //         }
    //           , d = function() {
    //             n.classList.toggle("d-none"),
    //             r.classList.toggle("d-none"),
    //             i.classList.toggle("d-none")
    //         }
    //     }(),
    //     e = document.getElementById("kt_signin_change_email"),
    //     t = FormValidation.formValidation(e, {
    //         fields: {
    //             emailaddress: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: "Email is required"
    //                     },
    //                     emailAddress: {
    //                         message: "The value is not a valid email address"
    //                     }
    //                 }
    //             },
    //             confirmemailpassword: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: "Password is required"
    //                     }
    //                 }
    //             }
    //         },
    //         plugins: {
    //             trigger: new FormValidation.plugins.Trigger,
    //             bootstrap: new FormValidation.plugins.Bootstrap5({
    //                 rowSelector: ".fv-row"
    //             })
    //         }
    //     }),
    //     e.querySelector("#kt_signin_submit").addEventListener("click", (function(e) {
    //         e.preventDefault(),
    //         console.log("click"),
    //         t.validate().then((function(t) {
    //             "Valid" == t ? swal.fire({
    //                 text: "Sent password reset. Please check your email",
    //                 icon: "success",
    //                 buttonsStyling: !1,
    //                 confirmButtonText: "Ok, got it!",
    //                 customClass: {
    //                     confirmButton: "btn font-weight-bold btn-light-primary"
    //                 }
    //             }) : swal.fire({
    //                 text: "Sorry, looks like there are some errors detected, please try again.",
    //                 icon: "error",
    //                 buttonsStyling: !1,
    //                 confirmButtonText: "Ok, got it!",
    //                 customClass: {
    //                     confirmButton: "btn font-weight-bold btn-light-primary"
    //                 }
    //             })
    //         }
    //         ))
    //     }
    //     )),
    //     function(t) {
    //         var e, n = document.getElementById("kt_signin_change_password");
    //         e = FormValidation.formValidation(n, {
    //             fields: {
    //                 currentpassword: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "Current Password is required"
    //                         }
    //                     }
    //                 },
    //                 newpassword: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "New Password is required"
    //                         }
    //                     }
    //                 },
    //                 confirmpassword: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "Confirm Password is required"
    //                         },
    //                         identical: {
    //                             compare: function() {
    //                                 return n.querySelector('[name="newpassword"]').value
    //                             },
    //                             message: "The password and its confirm are not the same"
    //                         }
    //                     }
    //                 }
    //             },
    //             plugins: {
    //                 trigger: new FormValidation.plugins.Trigger,
    //                 bootstrap: new FormValidation.plugins.Bootstrap5({
    //                     rowSelector: ".fv-row"
    //                 })
    //             }
    //         }),
    //         n.querySelector("#kt_password_submit").addEventListener("click", (function(t) {
    //             t.preventDefault(),
    //             console.log("click"),
    //             e.validate().then((function(t) {
    //                 "Valid" == t ? swal.fire({
    //                     text: "Sent password reset. Please check your email",
    //                     icon: "success",
    //                     buttonsStyling: !1,
    //                     confirmButtonText: "Ok, got it!",
    //                     customClass: {
    //                         confirmButton: "btn font-weight-bold btn-light-primary"
    //                     }
    //                 }) : swal.fire({
    //                     text: "Sorry, looks like there are some errors detected, please try again.",
    //                     icon: "error",
    //                     buttonsStyling: !1,
    //                     confirmButtonText: "Ok, got it!",
    //                     customClass: {
    //                         confirmButton: "btn font-weight-bold btn-light-primary"
    //                     }
    //                 })
    //             }
    //             ))
    //         }
    //         ))
    //     }()
    // }


    // Public methods

    return {
        init: function () {

            initObtenerUsuario();
            initAgregarActualizar();
            initActionsButtons();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

