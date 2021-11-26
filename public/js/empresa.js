"use strict";
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var ListOrden = [];

    // Private functions
    var initListarEmpresas = function () {

        var urlfinal= urlBase + "empresas/listarempresas";

        dt = $("#kt_datatable_empresas").DataTable({

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

            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                url: urlfinal
            },
            columns: [
                { data: 'id' },
                { data: 'Nombre' },
                { data: 'Nit' },
                { data: 'Sigla',className: 'text-center' },
                { data: 'Niveles',className: 'text-center' },
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
                                <a data-kt-action="sector_edit" data-bs-toggle="modal" data-bs-target="#kt_modal_add_sector" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                    <span class="svg-icon svg-icon-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a data-kt-action="Gestionar_entradas" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Gestionar Entradas">
                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V2.40002C0 3.00002 0.4 3.40002 1 3.40002H12C12.6 3.40002 13 3.00002 13 2.40002V1.40002C13 0.800024 12.6 0.400024 12 0.400024Z" fill="black"/>
                                            <path opacity="0.3" d="M15 8.40002H1C0.4 8.40002 0 8.00002 0 7.40002C0 6.80002 0.4 6.40002 1 6.40002H15C15.6 6.40002 16 6.80002 16 7.40002C16 8.00002 15.6 8.40002 15 8.40002ZM16 12.4C16 11.8 15.6 11.4 15 11.4H1C0.4 11.4 0 11.8 0 12.4C0 13 0.4 13.4 1 13.4H15C15.6 13.4 16 13 16 12.4ZM12 17.4C12 16.8 11.6 16.4 11 16.4H1C0.4 16.4 0 16.8 0 17.4C0 18 0.4 18.4 1 18.4H11C11.6 18.4 12 18 12 17.4Z" fill="black"/>
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

                // l['IdSector'] = data.IdSector;
                // l['NumOrden'] = data.Orden;

                // ListOrden.push(l);
            }

        });

        table = dt.$;

        dt.on('draw', function () {

            // initToggleToolbar(),
            // toggleToolbars(),

            $('[data-bs-toggle="tooltip"]').tooltip(),
            //  initEditSector(),
            //  initStateSector(),
            //  initRedirectMultimedia(),
            //  initRedirectEntradas(),

            KTMenu.createInstances()
        });
    }

    // Init AgregarActualizar
    var initAgregarActualizar = function () {

        //console.log(ListImgs);

        var t, e, o, n, r, i, b;


        i = new bootstrap.Modal(document.querySelector("#kt_modal_add_sector")),
        r = document.querySelector("#kt_modal_add_sector_form"),
        b = document.querySelector("#btnAddsector"),

        t = r.querySelector("#kt_modal_add_sector_submit"),
        e = r.querySelector("#kt_modal_add_sector_cancel"),
        o = r.querySelector("#kt_modal_add_sector_close"),

        n = FormValidation.formValidation(r, {
            fields: {
                TxtNombre: {
                    validators: {
                        notEmpty: {
                            message: "El Nombre es Obligatorio"
                        }
                    }
                },
                TxtTitulo: {
                    validators: {
                        notEmpty: {
                            message: "El Titulo es Obligatorio"
                        }
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger,
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: ""
                })
            }
        }),

       // Validacion Numeric Input
        // Inputmask("decimal",{
        //     "mask": "9",
        //     "repeat": 10,
        //     "greedy": false,
        // }).mask("#kt_inputmask_orden");

        b.addEventListener("click", (function(){

            r.querySelector('[name="TitleModal"]').innerText = "Agregar Sector";

            r.querySelector('[name="TxtNombre"]').value = "";
            r.querySelector('[name="TxtTitulo"]').value = "";

            if (ListOrden.length == 0) {
                r.querySelector('[name="TxtOrden"]').value = 1;
            }
            else {
                r.querySelector('[name="TxtOrden"]').value = ListOrden[ListOrden.length - 1].NumOrden + 1;
            }

            r.querySelector('[name="TxtTexto"]').value = "";

            t.value = "";
            //r.reset();
        })),

        t.addEventListener("click", (function(e) {

            var urlfinal;

            var ExisteOrden = false;
            var MensajeSwalValidacion;

            var Nombre = r.querySelector('[name="TxtNombre"]').value;
            var Titulo = r.querySelector('[name="TxtTitulo"]').value;
            var Orden = r.querySelector('[name="TxtOrden"]').value;
            var Texto = r.querySelector('[name="TxtTexto"]').value;

            var IdRowSector = "";

            if (t.value != "") {

                IdRowSector = t.value;
            }

            ListOrden.forEach(v => {

                if (IdRowSector == "") {

                    if (v.NumOrden == Orden) {

                        ExisteOrden = true;
                        MensajeSwalValidacion = "Este numero de Orden ya fue Asignado";
                    }

                }
                else {

                    if (v.IdSector != IdRowSector) {

                        if (v.NumOrden == Orden) {

                            ExisteOrden = true;
                            MensajeSwalValidacion = "Este numero de Orden ya fue Asignado";
                        }

                    }

                }
            });

            if (ExisteOrden == false) {

                MensajeSwalValidacion = "Complete los campos obligatorios";
            }


            var TipoMensajeSwal = "";
            var MensajeSwal = "";

            var formData;

            e.preventDefault(), n && n.validate().then((function(e) {

                "Valid" == e && ExisteOrden == false? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0,

                    formData = new FormData(),
                    formData.append('IdUserActual', 1),
                    formData.append('Nombre',Nombre),
                    formData.append('Titulo',Titulo),
                    formData.append('NumOrden',Orden),
                    formData.append('Texto',Texto),
                    formData.append('IdSector',IdRowSector),

                    urlfinal= urlBase + "/RegistrarActualizarSector",
                   // dataValue = JSON.stringify(datalinea),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: formData,
                       // dataType: "json",
                        processData: false,
                        contentType: false,
                        success: function (res) {
                           // console.log(res);
                            if (res.titulo == "Success") {
                                TipoMensajeSwal = res.tipoMensaje;
                                MensajeSwal = res.mensaje;
                            }
                            if (res.titulo == "Update") {
                                TipoMensajeSwal = res.tipoMensaje;
                                MensajeSwal = res.mensaje;
                            }
                            if (res.titulo == "Error") {
                                TipoMensajeSwal = res.tipoMensaje;
                                MensajeSwal = res.mensaje;
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
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
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

    // Editar Sector
    var initEditSector = function() {

        var t, e, o, n, r, i;

        //i = new bootstrap.Modal(document.querySelector("#kt_modal_add_linea"));
        r = document.querySelector("#kt_modal_add_sector_form");
        //t = r.querySelector("#kt_modal_add_customer_header");
        t = r.querySelector("#kt_modal_add_sector_submit");
        //o = r.querySelector("#idLineaTable");

        const EditButton = document.querySelectorAll('[data-kt-action="sector_edit"]');

        EditButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();
                // Select parent row
                const parent = e.target.closest('tr');

                // Get sector datos
                const sectorId = parent.querySelectorAll('td')[0].children[0].children[0].value;
                const sectorNombre = parent.querySelectorAll('td')[1].innerText;
                const sectorTitulo = parent.querySelectorAll('td')[2].innerText;
                const sectorTexto = parent.querySelectorAll('td')[3].innerText;
                const sectorOrden = parent.querySelectorAll('td')[4].innerText;

                // Insert datos sector
                r.querySelector('[name="TitleModal"]').innerText = "Editar Sector";
                r.querySelector('[name="TxtNombre"]').value = sectorNombre;
                r.querySelector('[name="TxtTitulo"]').value = sectorTitulo;
                r.querySelector('[name="TxtOrden"]').value = sectorOrden;
                r.querySelector('[name="TxtTexto"]').value = sectorTexto;
                t.value = sectorId;

            });

        });
    }

    // Cambiar Estado Sector
    var initStateSector = function() {

        var t, e, o, n, r, i;

        const ChangeStateButton = document.querySelectorAll('[data-kt-action="sector_sw_state"]');

        ChangeStateButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                var datasector;
                var urlfinal;
                var dataValue;

                var Mensaje = "";
                // Select parent row
                const parent = e.target.closest('tr');

                // Get Sector datos
                const sectorId = parent.querySelectorAll('td')[0].children[0].children[0].value;

                //Sent Ajax
                datasector = {

                    IdSector: sectorId
                },

                urlfinal= urlBase + "/HabilitarDeshabilitarSector",
                dataValue = JSON.stringify(datasector),

                $.ajax({
                    type: "POST",
                    url: urlfinal,
                    contentType: "application/json; charset=utf-8",
                    data: dataValue,
                    dataType: "json",
                    success: function (res) {
                       // console.log(res);
                        if (res.titulo = "Success") {

                            // var RowSelect = dt.row(parent).data();

                            // if (res.Sector.estado == 0) {

                            //     RowSelect.Estado = "Deshabilitado";
                            //     RowSelect.TipoEstado = "danger";
                            // }
                            // if (res.Sector.estado == 1){

                            //     RowSelect.Estado = "Habilitado";
                            //     RowSelect.TipoEstado = "success";
                            // }

                            // dt.row(parent).data(RowSelect).draw(false);

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

     // ButtonRedirecMultimedia
     var initRedirectMultimedia = function() {

        const GestionCateButton = document.querySelectorAll('[data-kt-action="Gestionar_multimedia"]');

        GestionCateButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get sector datos
                const sectorId = parent.querySelectorAll('td')[0].children[0].children[0].value;

                // RediretPagina
                window.location = urlBase + "MediasSector/"+ sectorId;



            });

        });
    }

    // ButtonRedirecEntradas
    var initRedirectEntradas = function() {

        const GestionCateButton = document.querySelectorAll('[data-kt-action="Gestionar_entradas"]');

        GestionCateButton.forEach(d => {

            d.addEventListener("click", function(e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get sector datos
                const sectorId = parent.querySelectorAll('td')[0].children[0].children[0].value;

                // RediretPagina
                window.location = urlBase + "entradas/"+ sectorId;



            });

        });
    }

    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector('#kt_datatable_sectores');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-sector-table-select="delete_selected"]');

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
            var datasector;
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
                text: "¿Esta seguro que quiere eliminar los sectores seleccionados?",
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
                        text: "Eliminando sectores seleccionados",
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false
                    });

                    //Sent Ajax
                    datasector = {

                        IdRowSelected: ArrayRowSelect
                    },

                    urlfinal= urlBase + "/EliminarSectores",
                    dataValue = JSON.stringify(datasector),

                    $.ajax({
                        type: "POST",
                        url: urlfinal,
                        contentType: "application/json; charset=utf-8",
                        data: dataValue,
                        dataType: "json",
                        success: function (res) {
                            Swal.close();

                            Swal.fire({
                                text: "Sectores Eliminados!.",
                                icon: "success",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 1000

                            }).then(function () {
                                window.location = location.href;

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
        const container = document.querySelector('#kt_datatable_sectores');
        const toolbarBase = document.querySelector('[data-kt-sectores-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-sectores-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-sectores-table-select="selected_count"]');

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
        })

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

    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-sectores-table-filter="search"]');

        filterSearch.addEventListener('keyup', function (e) {

            dt.search(e.target.value).draw();
        });
    }

    // Public methods
    return {
        init: function () {

            initListarEmpresas();
            // initAgregarActualizar();

            // handleSearchDatatable();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
