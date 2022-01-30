"use strict";
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var List = [];
    moment.locale('es');

    var idEmpresa = document.querySelector('[name="idempresa"]').value;

    // Private functions
    var initListarMembresias = function () {

        var datamembresias;
        var dataValue;
        var users;
        var urlfinal= urlBase + "seguridad/traermembresias";

        //Sent Ajax
        datamembresias = {

            idempresa: idEmpresa
        },

        dataValue = JSON.stringify(datamembresias),

        $.ajax({
            type: "POST",
            url: urlfinal,
            contentType: "application/json; charset=utf-8",
            data: dataValue,
            dataType: "json",
            success: function (res) {

                if (res.tipoMensaje=="success") {
                    var membresias = res.Membresias;
                    var empresas = res.Empresas;
                    //formatear datos
                    for(var i=0;i<membresias.length;i++){
                        //empresa
                            var idemp = membresias[i].idempresa;
                            for(var j=0;j<empresas.length;j++){
                                if(empresas[j].id==idemp){
                                    membresias[i].idempresa = empresas[j].id;
                                    membresias[i].nomEmpresa = empresas[j].Nombre;
                                }
                            }
                        //estado
                            if(membresias[i].estado==1){
                                membresias[i].estado = "Habilitada";
                            }else{
                                membresias[i].estado = "Deshabilitada";
                            }
                    }

                    dt = $("#kt_datatable_membresias").DataTable({

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
                        data:membresias,

                        select: {
                            style: 'os',
                            selector: 'td:first-child',
                            className: 'row-selected'
                        },
                        columns: [
                            ///{ data: 'id' },
                            { data: 'nomEmpresa' },
                            { data: 'estado',className: 'text-center' },
                            { data: 'fechainicio',className: 'text-center' },
                            { data: 'fechafin',className: 'text-center' },
                            { data: null },

                        ],
                        columnDefs: [
                            // {
                            //     targets: 0,
                            //     orderable: false,
                            //     render: function (data) {
                            //         return `
                            //             <div class="form-check form-check-sm form-check-custom form-check-solid">
                            //                 <input class="form-check-input" type="checkbox" value="${data}" />
                            //             </div>`;
                            //     }
                            // },
                            {
                                targets: 1,
                                render: function (data, type, row) {
                                    var TipoEstado;

                                    if (row.estado == "Habilitada") {
                                        TipoEstado = "success";

                                    } else {
                                        TipoEstado = "danger";
                                    }

                                    return `<span class="badge badge-light-${TipoEstado} fs-7 fw-bold">${row.estado}</span>`;
                                }
                            },
                            {
                                targets: 2,
                                render: function (data, type, row) {

                                    var dateInit = moment(row.fechainicio).format('LL');

                                    return dateInit;
                                }
                            },
                            {
                                targets: 3,
                                render: function (data, type, row) {

                                    var datefinal = moment(row.fechafin).format('LL');
                                    return datefinal;
                                }
                            },
                            {
                                targets: -1,
                                data: null,
                                orderable: false,
                                className: 'text-end',
                                render: function (data, type, row) {

                                    return`
                                            <a data-kt-action="Editar_Membresia" id="${row.id}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_membresia" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-placement="top">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <a data-kt-action="Cancelar_membresia" id="${row.id}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                                                        <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"/>
                                                        <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"/>
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

                            var l = [];

                                l['IdMembresia'] = data.id;
                                l['IdEmpresa'] = data.idempresa;
                                l['FecInicio'] = data.fechainicio;
                                l['FecFin'] = data.fechafin;

                                List.push(l);
                        }
                    });

                    table = dt.$;

                    //initToggleToolbar();
                    //toggleToolbars();

                    $('[data-bs-toggle="tooltip"]').tooltip();
                    initEditMembresia();
                    initCancelMembresia();
                    //initStateEntrada();
                    //initRedirectPerfil();
                    KTMenu.createInstances()
                }
                else {
                    toastr.error(res.mensaje);
                }

            }
        });
    }

    // Init AgregarActualizar
    var initAgregarActualizar = function () {

         //console.log(ListImgs);
        var t, e, o, n, r, i, b, RangeCalendar;

        i = new bootstrap.Modal(document.querySelector("#kt_modal_add_membresia")),
        r = document.querySelector("#kt_modal_add_membresia_form"),
        b = document.querySelector("#btnAddmembresia"),

        t = r.querySelector("#kt_modal_add_membresia_submit"),
        e = r.querySelector("#kt_modal_add_membresia_cancel"),
        o = r.querySelector("#kt_modal_add_membresia_close"),

        RangeCalendar = $("#kt_date_range");

        n = FormValidation.formValidation(r, {
            fields: {
                DateRange: {
                    validators: {
                        notEmpty: {
                            message: "La Fecha es Obligatoria"
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

        //Select Modal

        b.addEventListener("click", (function(){
            //Insert datos entrada
            r.querySelector('[name="TitleModal"]').innerText = "Agregar Membresia";

            $("#kt_select_ComboEmpresa").prop('disabled', false);

            if(idEmpresa==0){



            }
            else{

               //SelectComboEmpresas
               var ComboEmpresas = $("#kt_select_ComboEmpresa");
               ComboEmpresas.children().each(function () {

                   if (this.value == idEmpresa) {

                       this.remove();

                       var $newOption = $("<option selected='selected'></option>").val(this.value).text(this.text);
                       ComboEmpresas.append($newOption).trigger('change');
                       ComboEmpresas.prop('disabled', true);
                   }
               });
            }

            RangeCalendar.flatpickr().clear();
            //DateTime input Modal
            RangeCalendar.flatpickr(

                {
                    altInput: true,
                    altFormat: "j F, Y",
                    dateFormat: "Y-m-d",
                    mode: "range",
                    minDate: "today",
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                        },
                        months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                        longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        },
                    },
                    defaultDate: "",
                }
            );

            t.value = "";
            r.reset();

        })),

        t.addEventListener("click", (function(e) {

            var urlfinal;
            var MensajeSwalValidacion;

            var ComboEmpresa = r.querySelector('[name="ComboEmpresa"]').value;
            var RangeFecha = r.querySelector('[name="DateRange"]').value.split('to');
            var FecIni = RangeFecha[0];
            var FecFin = RangeFecha[1];

            var IdRowmembresia = "";
            var TipoMensajeSwal = "";
            var MensajeSwal = "";

            var formData;

            if (t.value != "") {

                IdRowmembresia = t.value;
            }

            MensajeSwalValidacion = "Complete los campos obligatorios";

            e.preventDefault(), n && n.validate().then((function(e) {

                "Valid" == e? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0,

                    formData = new FormData(),
                    formData.append('Empresa', ComboEmpresa),
                    formData.append('Fei', FecIni),
                    formData.append('Fef', FecFin),
                    formData.append('IdMembresia', IdRowmembresia),

                    urlfinal= urlBase + "seguridad/crearmembresia",
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

    // Editar Membresia
    var initEditMembresia = function() {

        var t, r, RangeCalendar;
        //i = new bootstrap.Modal(document.querySelector("#kt_modal_add_categoria"));
        r = document.querySelector("#kt_modal_add_membresia_form");
        //t = r.querySelector("#kt_modal_add_customer_header");
        t = r.querySelector("#kt_modal_add_membresia_submit");
        //o = r.querySelector("#idEntradaTable");

        const EditButton = document.querySelectorAll('[data-kt-action="Editar_Membresia"]');

        EditButton.forEach(m => {

            m.addEventListener("click", function(e) {
                e.preventDefault();
                // Select parent row
                const parent = e.target.closest('tr');
                var RangeCalendar = $("#kt_date_range");

                $("#kt_select_ComboEmpresa").prop('disabled', true);

                RangeCalendar.flatpickr().clear();
                // Get membresia datos
                const membresiaId = this.id;
                // Insert datos entrada
                r.querySelector('[name="TitleModal"]').innerText = "Editar Membresia";

                List.forEach(m => {

                    if (m.IdMembresia == membresiaId) {

                        $('#kt_select_ComboEmpresa').val(m.IdEmpresa).trigger('change');

                         //DateRange input Modal
                         RangeCalendar.flatpickr(

                            {
                                altInput: true,
                                altFormat: "j F, Y",
                                dateFormat: "Y-m-d",
                                mode: "range",
                                locale: {
                                    firstDayOfWeek: 1,
                                    weekdays: {
                                    shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                                    },
                                    months: {
                                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                                    longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                    },
                                },
                                defaultDate: [m.FecInicio, m.FecFin],
                            }
                        );
                    }

                });

                t.value = membresiaId;

            });

        });
    }

    // Cancelar Membresia
    var initCancelMembresia = function() {

        const CancelButton = document.querySelectorAll('[data-kt-action="Cancelar_membresia"]');

        CancelButton.forEach(c => {

            c.addEventListener("click", function(e) {
                e.preventDefault();
                // Select parent row
                const IdSelec = this.id;

                var datamembresia;
                var urlfinal;
                var dataValue;
                var TipoMensajeSwal;
                var MensajeSwal;

                Swal.fire({
                    text: "¿Esta seguro que quiere cancelar esta membresia?",
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
                            text: "Cancelando membresia ...",
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false
                        });

                        //Sent Ajax
                        datamembresia = {

                            idmembresia: IdSelec
                        },

                        urlfinal= urlBase + "seguridad/cancelarmembresia",
                        dataValue = JSON.stringify(datamembresia),

                        $.ajax({
                            type: "POST",
                            url: urlfinal,
                            contentType: "application/json; charset=utf-8",
                            data: dataValue,
                            dataType: "json",
                            success: function (res) {
                                Swal.close();

                                if (res.titulo = "Success") {
                                    TipoMensajeSwal = res.tipoMensaje;
                                    MensajeSwal = res.mensaje;
                                }

                                if (res.titulo = "Error") {
                                    TipoMensajeSwal = res.tipoMensaje;
                                    MensajeSwal = res.mensaje;
                                    //console.log(MensajeSwal);
                                }

                                setTimeout((function() {

                                    Swal.fire({
                                        text : MensajeSwal,
                                        icon: TipoMensajeSwal,
                                        buttonsStyling: !1,
                                        showConfirmButton: false,
                                        buttonsStyling: false,
                                        timer: 1000

                                    }).then((function(e) {
                                        if (TipoMensajeSwal == "error") {

                                            //i.hide()
                                        }
                                        else {

                                            window.location = location.href;
                                        }
                                    }))

                                }), 1e1)
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

        });
    }

    // Search Datatable
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-membresia-table-filter="search"]');

        filterSearch.addEventListener('keyup', function (e) {

            dt.search(e.target.value).draw();
        });
    }

    // Public methods
    return {
        init: function () {

            initListarMembresias();
            initAgregarActualizar();

            handleSearchDatatable();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

