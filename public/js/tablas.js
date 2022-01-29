$(document).ready( function () {
	$('#tablausuariospermisos').DataTable({
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
        buttons: [],
        scrollY:        150,
        deferRender:    true,
        scroller:       true,
        stateSave:      true,

        "order": [
            [0, 'asc']
        ],
        
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 10,

        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
	});
	// $('#tablagestiones').DataTable({
	// 	"pageLength": 25
	// });
	// $('#tablaperiodos').DataTable({
	// 	"pageLength": 25
	// });
	// $('#tablaMonedas').DataTable({
	// 	"pageLength": 25,
	// 	"order": [[ 4, "asc" ]]
	// });
	$('#tablaComprobantes').DataTable({
		"pageLength": 25,
		"order": [[ 0, "desc" ]]
	});
	$('#tablaarticulos').DataTable({
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
        // buttons: [
        //     { extend: 'print',
        //       className: 'btn dark btn-outline', 
        //       customize: function ( win ) {
        //             $(win.document.body)
        //                 .css( 'font-size', '10pt' );

        //             $(win.document.body).find( 'table' )
        //                 .addClass( 'compact' )
        //                 .css( 'font-size', 'inherit' );
        //         } 
        //     },
        //     { extend: 'pdf', className: 'btn green btn-outline' },
        //     { extend: 'csv', className: 'btn purple btn-outline ' }
        // ],
        scrollY:        150,
        bLengthChange: false,
        deferRender:    true,
        scroller:       true,
        "scrollX": true,
        fixedHeader: true,
        scrollCollapse: true,
        stateSave:      true,
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"] 
        ],
        "pageLength": 10,
        // "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
	});
	$('#tablalotes').DataTable({
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
        scrollY:        100,
        deferRender:    true,
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"] 
        ],
        "pageLength": 10,
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
	});
	$('#tablanotas').DataTable({
		"pageLength": 25,
		"order": [[ 0, "desc" ]]
	});
	$('#tablaintegracion').DataTable({
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
        scrollY:        100,
        deferRender:    true,
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"] 
        ],
        "pageLength": 10,
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		"order": [[ 6, "asc" ]]
	});
});


