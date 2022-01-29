$(document).ready(function () {
    /***********on Load********************/
        limpiarpoolcategorias();
        var poolcategorias = $("#poolcategorias").text().split(",");
        autocomplete(document.getElementById("cmbcat"), poolcategorias);
    /***********Eventos********************/
        $('#btnAceptaraddedit').on('click',function(){
            //validaciones
                if($('#txtNombre').val()==""){
                    toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                    return;
                }
                if($('#txtdes').val()==""){
                    toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                    return;
                }
                if($('#txtprice').val()==""){
                    toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                    return;
                }
                if($('#txtpriceinter').val()==""){
                    toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                    return;
                }
                if($('#txtpricemay').val()==""){
                    toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                    return;
                }
                if($('#cmbcat').attr("data-idcategoria")==undefined){
                    toastr.error("Error en la Categoria",'Error', {timeOut: 3000});
                    return;
                }
                // if($('#txtdem').val()==""){
                //     toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                //     return;
                // }
                // if($('#txtfecha').val()==""){
                //     toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                //     return;
                // }
                // if($('#txtpoint').val()==""){
                //     toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                //     return;
                // }
                // if($('#txtcosto').val()==""){
                //     toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                //     return;
                // }
            if($(this).attr('data-idart')!=null){
                //actualizar
                data={
                    Idart:         $(this).attr("data-idart"),
                    Nombre:        $('#txtNombre').val(),
                    txtdes:        $('#txtdes').val(),
                    txtprice:      $('#txtprice').val(),
                    txtpriceinter: $('#txtpriceinter').val(),
                    txtpricemay:   $('#txtpricemay').val(),
                    txtcodebus:    $('#txtcodebus').val(),
                    // txtdem:          $('#txtdem').val(),
                    // txtfecha:          $('#txtfecha').val(),
                    // txtpoint:          $('#txtpoint').val(),
                    // txtcosto:          $('#txtcosto').val(),
                    idcat:          $('#cmbcat').attr("data-idcategoria"),
                    idem:               $('#idemnavbar').text()
                };
                var urlfinal= urlBase + "articulos/actualizar-articulo";
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
                        $("#modaladdart").modal('hide');
                        location.reload();  
                    }else{
                        toastr.error(res.mensaje,'Error', {timeOut: 3000});
                    }
                    },
                    error: function(res){
                        toastr.error(res,'Error', {timeOut: 3000});  
                    }
                });
            }else{
                //crear
                data={
                    Nombre:        $('#txtNombre').val(),
                    txtdes:        $('#txtdes').val(),
                    txtprice:      $('#txtprice').val(),
                    txtpriceinter: $('#txtpriceinter').val(),
                    txtpricemay:   $('#txtpricemay').val(),
                    // txtdem:          $('#txtdem').val(),
                    // txtfecha:          $('#txtfecha').val(),
                    // txtpoint:          $('#txtpoint').val(),
                    // txtcosto:          $('#txtcosto').val(),
                    idcat:          $('#cmbcat').attr("data-idcategoria"),
                    idem:           $('#idemnavbar').text(),
                    txtcodebus:     $('#txtcodebus').val()
                };
                var urlfinal= urlBase + "articulos/crear-articulo";
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
                            $("#modaladdem").modal('hiden');
                            location.reload();
                        }else{
                            toastr.error(res.mensaje,'Error', {timeOut: 3000});
                        }
                    },
                    error: function(res){
                        console.log(res);
                        toastr.error(res,'Error', {timeOut: 3000});  
                    }
                });
            }
        });
        $(".btn-golot").on('click',function(){
            var idart=$(this).attr('data-idart');
            var idem = $('#idemnavbar').text();
            location.href=urlBase+"articulos/listarlotes/"+idart+"/"+idem;
        });
        $("#btn-addart").on('click',function(){
            $('#txtNombre').val("");
            $('#txtdes').val("");
            $('#txtcodebus').val("");
            
            // $('#txtcant').val(0);
            $('#txtprice').val("");
            $('#txtpriceinter').val("");
            $('#txtpricemay').val("");
            // $('#txtdem').val("");
            // $('#txtfecha').val("");
            // $('#txtcosto').val(0);
            // $('#txtcosti').val(0);
            // $('#txtpoint').val("");
            // $('#cmbcat').val(1);
            // document.getElementById("txtcosto").removeAttribute("disabled");
            $("#modaladdart").modal("show");
        });
        $(".btn-editart").on('click',function(){
            var idart=$(this).attr('data-idart');
            var nombre=$("#tablaarticulos tr .datnombre[data-idart='"+idart+"']").text();
            var descripcion=$("#tablaarticulos tr .datdes[data-idart='"+idart+"']").text();
            // var cantidad=$("#tablaarticulos tr .datcant[data-idart='"+idart+"']").text();
            var precioventa=$("#tablaarticulos tr .datprice[data-idart='"+idart+"']").text();
            var precioventainter=$("#tablaarticulos tr .datpriceinter[data-idart='"+idart+"']").text();
            var precioventamay=$("#tablaarticulos tr .datpricemary[data-idart='"+idart+"']").text();
            // var demanda=$("#tablaarticulos tr .datdem[data-idart='"+idart+"']").text();
            // var tiempo=$("#tablaarticulos tr .dattime[data-idart='"+idart+"']").text();
            // var costo=$("#tablaarticulos tr .datcosto[data-idart='"+idart+"']").text();
            // var costi=$("#tablaarticulos tr .datcostoinv[data-idart='"+idart+"']").text();
            // var punto=$("#tablaarticulos tr .datpoint[data-idart='"+idart+"']").text();
            var categoria=$("#tablaarticulos tr .datcat[data-idart='"+idart+"']").attr("data-idcat");
            $('#txtNombre').val(nombre);
            $('#txtdes').val(descripcion);
            // $('#txtcant').val(cantidad);
            $('#txtprice').val(precioventa);
            $('#txtpriceinter').val(precioventainter);
            $('#txtpricemay').val(precioventamay);
            // $('#txtdem').val(demanda);
            // $('#txtfecha').val(tiempo);
            // $('#txtcosto').attr("disabled","disabled");
            // $('#txtcosto').val(costo);
            // $('#txtcosti').val(costi);
            // $('#txtpoint').val(punto);
            var cat = buscarnombrecategoria(categoria);
            $('#cmbcat').val(cat);
            $('#cmbcat').attr("data-idcategoria",categoria);
            // document.getElementById("txtcosto").removeAttribute("disabled");
            $('#btnAceptaraddedit').attr("data-idart",idart);
            $("#modaladdart").modal('show');
        });
        $(".btn-eliminarart").click(function(){
            var idart=$(this).attr('data-idart');
            $("#mensajeadver").text("¿Seguro desea Eliminar este item?");
            $("#btnacepadv").attr("data-idart",idart);
            $("#modaladvertencia").modal("show");
        });
        $("#btnacepadv").click(function(){
             var idart=$(this).attr('data-idart');
             eliminarArticulo(idart);
        });
    /***********Funciones********************/
        function eliminarArticulo(idart){
            var urlfinal = urlBase + "articulos/eliminar-articulo";
            var data={
                IdArticulo: idart
            };
            var dataValue = JSON.stringify(data);
            ajaxx(urlfinal,dataValue);
        } 
        $('#tabla').css('display','block');
        // $('#tablaarticulos').css('width','100%');
        // var tablaarticulos_length = document.getElementById('tablaarticulos_length');
        // var tablaarticulos_paginate = document.getElementById('tablaarticulos_paginate');
        // var tablaarticulos_info = document.getElementById('tablaarticulos_info');
        // var tablaarticulos_filter = document.getElementById('tablaarticulos_filter');


        // tablaarticulos_info.innerHTML = tablaarticulos_info.innerHTML.replace('Showing', 'Mostrando');
        // tablaarticulos_info.innerHTML = tablaarticulos_info.innerHTML.replace('to', 'a');
        // tablaarticulos_info.innerHTML = tablaarticulos_info.innerHTML.replace('of', 'de');
        // tablaarticulos_info.innerHTML = tablaarticulos_info.innerHTML.replace('entries', 'items');

        // tablaarticulos_paginate.innerHTML = tablaarticulos_paginate.innerHTML.replace('Previous','Anterior');
        // tablaarticulos_paginate.innerHTML = tablaarticulos_paginate.innerHTML.replace('Next','Siguiente');

        // tablaarticulos_filter.innerHTML = tablaarticulos_filter.innerHTML.replace('Search','Buscar');

        // tablaarticulos_length.innerHTML = tablaarticulos_length.innerHTML.replace('Show','Mostrar');
        // tablaarticulos_length.innerHTML = tablaarticulos_length.innerHTML.replace('entries','items');
        //autocompletado
        function autocomplete(inp, arr) {
            var currentFocus;
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(a);
                for (i = 0; i < arr.length; i++) {
                  // comparación de valores
                  if (arr[i].split("/")[1].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*armar opciones*/
                    var arreglocuenta = arr[i];
                    var arreglocuenta = arreglocuenta.split("/");
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arreglocuenta[1].substr(0, val.length) + "</strong>";
                    b.innerHTML += arreglocuenta[1].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arreglocuenta[1] + "' data-idcategoria='"+arreglocuenta[0]+"'>";
                    b.addEventListener("click", function(e) {
                        /*inserta el valor de la unica opcion*/
                        var valor = this.getElementsByTagName("input")[0].value;
                        var id = this.getElementsByTagName("input")[0].getAttribute("data-idcategoria"); 
                        inp.value=valor;
                        inp.setAttribute("data-idcategoria",id);
                        closeAllLists();
                    });
                    a.appendChild(b);
                  }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) { //down
                  currentFocus++;
                  addActive(x);
                } else if (e.keyCode == 38) { //up
                  currentFocus--;
                  addActive(x);
                } else if (e.keyCode == 13) {//enter
                  e.preventDefault();
                  if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                  }
                }
            });
            function addActive(x) {
              if (!x) return false;
              removeActive(x);
              if (currentFocus >= x.length) currentFocus = 0;
              if (currentFocus < 0) currentFocus = (x.length - 1);
              x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
              /*a function to remove the "active" class from all autocomplete items:*/
              for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
              }
            }
            function closeAllLists(elmnt) {
              var x = document.getElementsByClassName("autocomplete-items");
              for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                  x[i].parentNode.removeChild(x[i]);
                }
              }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }
        //limpiar pool cuentas
        function limpiarpoolcategorias(){
            var pool = $("#poolcategorias").text();
            pool = pool.split("|");
            var poolcuentasfinal="";
            $.each(pool,function(index,e){
              if(e.trim() != "" && e !=null){
                var cuenta = e.trim().split(",");
                if(poolcuentasfinal==""){
                  poolcuentasfinal = cuenta[0];
                }else{
                  poolcuentasfinal = poolcuentasfinal + "," + cuenta[0];
                }
              }
            });
            $("#poolcategorias").text(poolcuentasfinal);
        }
        //buscar nombre categoria por id 
        function buscarnombrecategoria(id){
            var categoria = id + "";
            var nombre = "";
            for(var i=0;i<poolcategorias.length;i++){
              var catem = poolcategorias[i].trim().split("/");
              if(categoria === catem[0].toString()){
                nombre = catem[1];
              }
            }
            return nombre;
        }
    /************validaciones************/
        $("#txtprice").on('keypress',function(tecla){
            var value=$("#txtprice").val();
            var code=tecla.keyCode;
            var controlcal=0;
            console.log(code);
            if(code === 8 || code === 13){
                return true;
            }
            if(code === 46){
                var puntoanterior=value.indexOf(".");
                if(value===""){
                    return false;
                }else{
                    if(puntoanterior!=-1){
                        return false;
                    }else{
                        return true;
                    }
                }
            }
            if(code > 57 || code < 48){            
                return false;        
            }else{
                var puntoanterior=value.indexOf(".");
                if(puntoanterior!=-1){
                    var decimal=value.split(".");
                    decimal = decimal[1];
                    if((decimal.length + 1) > 2){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    if((value.length + 1) > 10){
                        return false;
                    }else{
                        return true;
                    }  
                }          
            }
        });
        $("#txtpriceinter").on('keypress',function(tecla){
            var value=$("#txtpriceinter").val();
            var code=tecla.keyCode;
            var controlcal=0;
            console.log(code);
            if(code === 8 || code === 13){
                return true;
            }
            if(code === 46){
                var puntoanterior=value.indexOf(".");
                if(value===""){
                    return false;
                }else{
                    if(puntoanterior!=-1){
                        return false;
                    }else{
                        return true;
                    }
                }
            }
            if(code > 57 || code < 48){            
                return false;        
            }else{
                var puntoanterior=value.indexOf(".");
                if(puntoanterior!=-1){
                    var decimal=value.split(".");
                    decimal = decimal[1];
                    if((decimal.length + 1) > 2){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    if((value.length + 1) > 10){
                        return false;
                    }else{
                        return true;
                    }  
                }          
            }
        });
        $("#txtpricemay").on('keypress',function(tecla){
            var value=$("#txtpricemay").val();
            var code=tecla.keyCode;
            var controlcal=0;
            console.log(code);
            if(code === 8 || code === 13){
                return true;
            }
            if(code === 46){
                var puntoanterior=value.indexOf(".");
                if(value===""){
                    return false;
                }else{
                    if(puntoanterior!=-1){
                        return false;
                    }else{
                        return true;
                    }
                }
            }
            if(code > 57 || code < 48){            
                return false;        
            }else{
                var puntoanterior=value.indexOf(".");
                if(puntoanterior!=-1){
                    var decimal=value.split(".");
                    decimal = decimal[1];
                    if((decimal.length + 1) > 2){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    if((value.length + 1) > 10){
                        return false;
                    }else{
                        return true;
                    }  
                }          
            }
        });
});




