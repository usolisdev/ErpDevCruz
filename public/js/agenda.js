$(document).ready(function () {
/************Runner************/
    marcadores("modconfiguracion","viewagendaadmin",0);
    cargardatos();
/************Eventos************/
    $('#btnguardar').on('click',function(){
        // validaciones empresa
            if($('#txtnombemp').val()==""){
                toastr.error("falta completar campos obligatorios",'Error', {timeOut: 7000});
                return;
            }
            if($('#txtnitemp').val()==""){
                toastr.error("falta completar campos obligatorios",'Error', {timeOut: 7000});
                return;
            }
            if($('#txtnitemp').val().length>15){
                toastr.error("el nit solo puede contener 15 digitos",'Error', {timeOut: 7000});
                return;
            }
            if($('#txtsigla').val()==""){
                toastr.error("falta completar campos obligatorios",'Error', {timeOut: 7000});
                return;
            }
            var cor=$('#txtmailemp').val();
            if(cor!="" && cor !=" "){
                var res=cor.indexOf('.');
                if(res==-1){
                    toastr.error('formato de correo erroneo','Error', {timeOut: 7000});
                    return; 
                }else{
                    var res=cor.indexOf('@');
                    if(res==-1){
                        toastr.error('formato de correo erroneo','Error', {timeOut: 7000}); 
                        return;
                    }
                }
            }
        // validaciones contacto
            var nomcom  = $("#txtnomcon").val();
            var apcom   = $("#txtapcon").val();
            var cicom   = $("#txtcicon").val();
            var nitcom  = $("#txtnitcon").val();
            var mailcom = $("#txtmailcon").val();
            var telcom  = $("#txttelcon").val();
            var celcom  = $("#txtcelcon").val();
            var dircom  = $("#txtdircon").val();
            var fnccom  = $("#txtfnccon").val();
            if(nomcom!=undefined||apcom!=undefined||cicom!=undefined||nitcom!=undefined||mailcom!=undefined||telcom!=undefined||celcom!=undefined||dircom!=undefined||fnccom!=undefined){
                if(nomcom!=""||apcom!=""||cicom!=""||nitcom!=""||mailcom!=""||telcom!=""||celcom!=""||dircom!=""||fnccom!=""){
                    if($('#txtcicon').val()=="" && $('#txtnitcon').val()==""){
                        toastr.error("Es necesario Al menos CI o NIT para registrar una persona de contacto",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtnomcon').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtapcon').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtcelcon').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtmailcon').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    var cor=$('#txtmailcon').val();
                    if(cor!="" && cor !=" "){
                        var res=cor.indexOf('.');
                        if(res==-1){
                            toastr.error('formato de correo erroneo','Error', {timeOut: 3000});
                            return; 
                        }else{
                            var res=cor.indexOf('@');
                            if(res==-1){
                                toastr.error('formato de correo erroneo','Error', {timeOut: 3000}); 
                                return;
                            }
                        }
                    }
                }
            }       
        // validaciones Representate
            var nomrep  = $("#txtnomrep").val();
            var aprep   = $("#txtaprep").val();
            var cirep   = $("#txtcirep").val();
            var nitrep  = $("#txtnitrep").val();
            var mailrep = $("#txtmailrep").val();
            var telrep  = $("#txttelrep").val();
            var celrep  = $("#txtcelrep").val();
            var dirrep  = $("#txtdirrep").val();
            var fncrep  = $("#txtfncrep").val();
            if(nomrep!=undefined||aprep!=undefined||cirep!=undefined||nitrep!=undefined||mailrep!=undefined||telrep!=undefined||celrep!=undefined||dirrep!=undefined||fncrep!=undefined){
                if(nomrep!=""||aprep!=""||cirep!=""||nitrep!=""||mailrep!=""||telrep!=""||celrep!=""||dirrep!=""||fncrep!=""){
                    if($('#txtcirep').val()=="" && $('#txtnitrep').val()==""){
                        toastr.error("Es necesario Al menos CI o NIT para registrar una persona como Representante Legal",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtnomrep').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtaprep').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtcelrep').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    if($('#txtmailrep').val()==""){
                        toastr.error("falta completar campos obligatorios",'Error', {timeOut: 3000});
                        return;
                    }
                    var cor=$('#txtmailrep').val();
                    if(cor!="" && cor !=" "){
                        var res=cor.indexOf('.');
                        if(res==-1){
                            toastr.error('formato de correo erroneo','Error', {timeOut: 3000});
                            return; 
                        }else{
                            var res=cor.indexOf('@');
                            if(res==-1){
                                toastr.error('formato de correo erroneo','Error', {timeOut: 3000}); 
                                return;
                            }
                        }
                    }
                }
            }
        data={
            idem:    $('#lblidempresa').text(),
            nomem:   $("#txtnombemp").val(),
            nitem:   $("#txtnitemp").val(),
            sigla:   $("#txtsigla").val(),
            telem:   $("#txttelemp").val(),
            mailem:  $("#txtmailemp").val(),
            direm:   $("#txtdiremp").val(),
            nomcom:  nomcom,
            apcom:   apcom,
            cicom:   cicom,
            nitcom:  nitcom,
            mailcom: mailcom,
            telcom:  telcom,
            celcom:  celcom,
            dircom:  dircom,
            fnccom:  fnccom,
            nomrep:  nomrep,
            aprep:   aprep,
            cirep:   cirep,
            nitrep:  nitrep,
            mailrep: mailrep,
            telrep:  telrep,
            celrep:  celrep,
            dirrep:  dirrep,
            fncrep:  fncrep,
            rdcon:   $(".rdcon:checked").val(),
            rdrep:   $(".rdrep:checked").val()
        };
        console.log(data);
        var urlfinal= urlBase + "empresas/guardaragenda";
        var dataValue = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: urlfinal,
            contentType: "application/json; charset=utf-8",
            data: dataValue,
            dataType: "json",
            success: function (res) {
                if(res.tipoMensaje=="success"){
                    toastr.success(res.mensaje,'Hecho', {timeOut: 7000});
                    var Empresa = res.empresa;
                    var Contacto = res.contacto;
                    var Representante = res.representante;
                    //empresa
                        $("#txtnombemp").val(Empresa.Nombre);
                        $("#txtnitemp").val(Empresa.Nit);
                        $("#txtsigla").val(Empresa.Sigla);
                        $("#txttelemp").val(Empresa.Telefono);
                        $("#txtmailemp").val(Empresa.Correo);
                        $("#txtdiremp").val(Empresa.Direccion);
                    // Contacto
                        if(Contacto!=0){
                            $("#percon").text(Contacto.nombres+
                                                ","+Contacto.apellidos+
                                                ","+Contacto.ci+
                                                ","+Contacto.nit+
                                                ","+Contacto.email+
                                                ","+Contacto.telefono+
                                                ","+Contacto.celular+
                                                ","+Contacto.direccion+
                                                ","+Contacto.fecha_de_nacimiento);
                            $("#txtnomcon").val(Contacto.nombres);
                            $("#txtapcon").val(Contacto.apellidos);
                            $("#txtcicon").val(Contacto.ci);
                            $("#txtnitcon").val(Contacto.nit);
                            $("#txtmailcon").val(Contacto.email);
                            $("#txttelcon").val(Contacto.telefono);
                            $("#txtcelcon").val(Contacto.celular);
                            $("#txtdircon").val(Contacto.direccion);
                            $("#txtfnccon").val(Contacto.fecha_de_nacimiento);

                            $("#editarlblcon").addClass("active");
                            $("#crearlblcon").removeClass("active");
                            $(".rdconlbl").css('display','block');
                            $("#cambiarcon").prop('checked', false);
                            $("#editarcon").prop('checked', true);
                        }else{
                            $(".rdconlbl").css('display','none');
                            $("#editarcon").prop('checked', false);
                            $("#cambiarcon").prop('checked', true);
                        }
                    // Representante legal
                        if(Representante!=0){
                            $("#perrep").text(Representante.nombres+
                                                ","+Representante.apellidos+
                                                ","+Representante.ci+
                                                ","+Representante.nit+
                                                ","+Representante.email+
                                                ","+Representante.telefono+
                                                ","+Representante.celular+
                                                ","+Representante.direccion+
                                                ","+Representante.fecha_de_nacimiento);
                            $("#txtnomrep").val(Representante.nombres);
                            $("#txtaprep").val(Representante.apellidos);
                            $("#txtcirep").val(Representante.ci);
                            $("#txtnitrep").val(Representante.nit);
                            $("#txtmailrep").val(Representante.email);
                            $("#txttelrep").val(Representante.telefono);
                            $("#txtcelrep").val(Representante.celular);
                            $("#txtdirrep").val(Representante.direccion);
                            $("#txtfncrep").val(Representante.fecha_de_nacimiento);

                            $("#editarlblrep").addClass("active");
                            $("#crearlblrep").removeClass("active");
                            $(".rdreplbl").css('display','block');
                            $("#cambiarrep").prop('checked', false);
                            $("#editarrep").prop('checked', true);
                        }else{
                            $(".rdreplbl").css('display','none');
                            $("#editarrep").prop('checked', false);
                            $("#cambiarrep").prop('checked', true);
                        }
                }else{
                    toastr.error(res.mensaje,'Error', {timeOut: 7000});
                }
            },
            error: function(res){
                console.log(res);
                toastr.error(res + 'Error');  
            }
        });
    });
    $("#txtcicon").on('change',function(){
        var ci = $(this).val();
        var data = {
            ci: ci,
            nit: null,
            email:null
        };
        data = JSON.stringify(data);
        //Obtener Vendedores
        $.ajax({
            type: 'POST',
            url: urlBase + 'personas/Traerpersona',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                var Persona = res.Persona;
                $("#txtnomcon").val(Persona.nombres);
                $("#txtapcon").val(Persona.apellidos);
                $("#txtcicon").val(Persona.ci);
                $("#txtnitcon").val(Persona.nit);
                $("#txtmailcon").val(Persona.email);
                $("#txttelcon").val(Persona.telefono);
                $("#txtcelcon").val(Persona.celular);
                $("#txtdircon").val(Persona.direccion);
                $("#txtfnccon").val(Persona.fecha_de_nacimiento);
            },
            error: function (res) {
            }
        });
    });
    $("#txtcirep").on('change',function(){
        var ci = $(this).val();
        var data = {
            ci: ci,
            nit: null,
            email:null
        };
        data = JSON.stringify(data);
        //Obtener Vendedores
        $.ajax({
            type: 'POST',
            url: urlBase + 'personas/Traerpersona',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                var Persona = res.Persona;
                $("#txtnomrep").val(Persona.nombres);
                $("#txtaprep").val(Persona.apellidos);
                $("#txtcirep").val(Persona.ci);
                $("#txtnitrep").val(Persona.nit);
                $("#txtmailrep").val(Persona.email);
                $("#txttelrep").val(Persona.telefono);
                $("#txtcelrep").val(Persona.celular);
                $("#txtdirrep").val(Persona.direccion);
                $("#txtfncrep").val(Persona.fecha_de_nacimiento);
            },
            error: function (res) {
            }
        });
    });
    $(".rdreplbl").on('click',function(){
        var check = $(this).hasClass('active');
        var id = $(this).children().attr('id');
        var per = $("#perrep").text();
        if(check==false){
            if(id=="cambiarrep"){
                $("#txtnomrep").val("");
                $("#txtaprep").val("");
                $("#txtcirep").val("");
                $("#txtnitrep").val("");
                $("#txtmailrep").val("");
                $("#txttelrep").val("");
                $("#txtcelrep").val("");
                $("#txtdirrep").val("");
                $("#txtfncrep").val("");
            }
            if(id=="editarrep"){
                if(per!=""){
                    per = per.split(',');
                    $("#txtnomrep").val(per[0]);
                    $("#txtaprep").val(per[1]);
                    $("#txtcirep").val(per[2]);
                    $("#txtnitrep").val(per[3]);
                    $("#txtmailrep").val(per[4]);
                    $("#txttelrep").val(per[5]);
                    $("#txtcelrep").val(per[6]);
                    $("#txtdirrep").val(per[7]);
                    $("#txtfncrep").val(per[8]);
                }
            }
        }
    });
    $(".rdconlbl").on('click',function(){
        var check = $(this).hasClass('active');
        var id = $(this).children().attr('id');
        var per = $("#percon").text();
        if(check==false){
            if(id=="cambiarcon"){
                $("#txtnomcon").val("");
                $("#txtapcon").val("");
                $("#txtcicon").val("");
                $("#txtnitcon").val("");
                $("#txtmailcon").val("");
                $("#txttelcon").val("");
                $("#txtcelcon").val("");
                $("#txtdircon").val("");
                $("#txtfnccon").val("");
            }
            if(id=="editarcon"){
                if(per!=""){
                    per = per.split(',');
                    $("#txtnomcon").val(per[0]);
                    $("#txtapcon").val(per[1]);
                    $("#txtcicon").val(per[2]);
                    $("#txtnitcon").val(per[3]);
                    $("#txtmailcon").val(per[4]);
                    $("#txttelcon").val(per[5]);
                    $("#txtcelcon").val(per[6]);
                    $("#txtdircon").val(per[7]);
                    $("#txtfnccon").val(per[8]);
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
    function cargardatos(){
        var data = {
            IdEmpresa: $('#lblidempresa').text()
        };
        data = JSON.stringify(data);
        //Obtener Datos
        $.ajax({
            type: 'POST',
            url: urlBase + 'empresas/TraerAgenda',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (res) {
                if (res.tipoMensaje=="success") {
                    var Empresa = res.empresa;
                    var Contacto = res.contacto;
                    var Representante = res.representante;
                    //empresa
                        $("#txtnombemp").val(Empresa.Nombre);
                        $("#txtnitemp").val(Empresa.Nit);
                        $("#txtsigla").val(Empresa.Sigla);
                        $("#txttelemp").val(Empresa.Telefono);
                        $("#txtmailemp").val(Empresa.Correo);
                        $("#txtdiremp").val(Empresa.Direccion);
                    // Contacto
                        if(Contacto!=0){
                            $("#percon").text(Contacto.nombres+
                                                ","+Contacto.apellidos+
                                                ","+Contacto.ci+
                                                ","+Contacto.nit+
                                                ","+Contacto.email+
                                                ","+Contacto.telefono+
                                                ","+Contacto.celular+
                                                ","+Contacto.direccion+
                                                ","+Contacto.fecha_de_nacimiento);
                            $("#txtnomcon").val(Contacto.nombres);
                            $("#txtapcon").val(Contacto.apellidos);
                            $("#txtcicon").val(Contacto.ci);
                            $("#txtnitcon").val(Contacto.nit);
                            $("#txtmailcon").val(Contacto.email);
                            $("#txttelcon").val(Contacto.telefono);
                            $("#txtcelcon").val(Contacto.celular);
                            $("#txtdircon").val(Contacto.direccion);
                            $("#txtfnccon").val(Contacto.fecha_de_nacimiento);
                        }else{
                            $(".rdconlbl").css('display','none');
                            $("#editarcon").prop('checked', false);
                            $("#cambiarcon").prop('checked', true);
                        }
                    // Representante legal
                        if(Representante!=0){
                            $("#perrep").text(Representante.nombres+
                                                ","+Representante.apellidos+
                                                ","+Representante.ci+
                                                ","+Representante.nit+
                                                ","+Representante.email+
                                                ","+Representante.telefono+
                                                ","+Representante.celular+
                                                ","+Representante.direccion+
                                                ","+Representante.fecha_de_nacimiento);
                            $("#txtnomrep").val(Representante.nombres);
                            $("#txtaprep").val(Representante.apellidos);
                            $("#txtcirep").val(Representante.ci);
                            $("#txtnitrep").val(Representante.nit);
                            $("#txtmailrep").val(Representante.email);
                            $("#txttelrep").val(Representante.telefono);
                            $("#txtcelrep").val(Representante.celular);
                            $("#txtdirrep").val(Representante.direccion);
                            $("#txtfncrep").val(Representante.fecha_de_nacimiento);
                        }else{
                            $(".rdreplbl").css('display','none');
                            $("#editarrep").prop('checked', false);
                            $("#cambiarrep").prop('checked', true);
                        }
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
/************validaciones************/
    // empresas
        $("#txtnitemp").keypress(function (tecla) {
            var value = $("#txtnitemp").val();
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
        $("#txtnombemp").keypress(function (tecla) {
            var value = $("#txtnombemp").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txtsigla").keypress(function (tecla) {
            var value = $("#txtsigla").val();
            if((value.length + 1) > 100){
                toastr.error("solo puede tener 100 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txttelemp").keypress(function (tecla) {
            var value = $("#txttelemp").val();
            var code=tecla.charCode;
            if(code === 8){
                return true;
            }
            if(code > 57 || code < 48){            
                //toastr.error("solo puede tener numeros");
                return false;        
            }else{
                if((value.length + 1) > 100){
                    toastr.error("solo puede tener 100 digitos",'Error', {timeOut: 3000});
                    return false;
                }else{
                    return true;
                }           
            }          
        });
        $("#txtmailemp").keypress(function (tecla) {
            var value = $("#txtmailemp").val();
            if((value.length + 1) > 100){
                toastr.error("solo puede tener 100 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txtdiremp").keypress(function (tecla) {
            var value = $("#txtdiremp").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
    // Contacto
        $("#txtnitcon").keypress(function (tecla) {
            var value = $("#txtnitcon").val();
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
        $("#txtcicon").keypress(function (tecla) {
            var value = $("#txtcicon").val();
            var code=tecla.charCode;
            if(code === 8){
                return true;
            }
            if(code > 57 || code < 48){            
                //toastr.error("solo puede tener numeros");
                return false;        
            }else{
                if((value.length + 1) > 100){
                    toastr.error("solo puede tener 100 digitos",'Error', {timeOut: 3000});
                    return false;
                }else{
                    return true;
                }           
            }
        });
        $("#txtnomcon").keypress(function (tecla) {
            var value = $("#txtnomcon").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txtapcon").keypress(function (tecla) {
            var value = $("#txtapcon").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txtmailcon").keypress(function (tecla) {
            var value = $("#txtmailcon").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txttelcon").keypress(function (tecla) {
            var value = $("#txttelcon").val();
            var code=tecla.charCode;
            if(code === 8){
                return true;
            }
            if(code > 57 || code < 48){            
                //toastr.error("solo puede tener numeros");
                return false;        
            }else{
                if((value.length + 1) > 300){
                    toastr.error("solo puede tener 300 digitos",'Error', {timeOut: 3000});
                    return false;
                }else{
                    return true;
                }           
            }    
        });
        $("#txtcelcon").keypress(function (tecla) {
            var value = $("#txtcelcon").val();
            var code=tecla.charCode;
            if(code === 8){
                return true;
            }
            if(code > 57 || code < 48){            
                //toastr.error("solo puede tener numeros");
                return false;        
            }else{
                if((value.length + 1) > 300){
                    toastr.error("solo puede tener 300 digitos",'Error', {timeOut: 3000});
                    return false;
                }else{
                    return true;
                }           
            }          
        });
        $("#txtdircon").keypress(function (tecla) {
            var value = $("#txtdircon").val();
            if((value.length + 1) > 10000){
                toastr.error("solo puede tener 10000 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        // txtnomcon
        // txtapcon
        // txtcicon
        // txtnitcon
        // txtmailcon
        // txttelcon
        // txtcelcon
        // txtdircon
        // txtfnccon
    // Representante legal
        $("#txtnitrep").keypress(function (tecla) {
            var value = $("#txtnitrep").val();
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
        $("#txtcirep").keypress(function (tecla) {
            var value = $("#txtcirep").val();
            var code=tecla.charCode;
            if(code === 8){
                return true;
            }
            if(code > 57 || code < 48){            
                //toastr.error("solo puede tener numeros");
                return false;        
            }else{
                if((value.length + 1) > 100){
                    toastr.error("solo puede tener 100 digitos",'Error', {timeOut: 3000});
                    return false;
                }else{
                    return true;
                }           
            }
        });
        $("#txtnomrep").keypress(function (tecla) {
            var value = $("#txtnomrep").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txtaprep").keypress(function (tecla) {
            var value = $("#txtaprep").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txtmailrep").keypress(function (tecla) {
            var value = $("#txtmailrep").val();
            if((value.length + 1) > 300){
                toastr.error("solo puede tener 300 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        $("#txttelrep").keypress(function (tecla) {
            var value = $("#txttelrep").val();
            var code=tecla.charCode;
            if(code === 8){
                return true;
            }
            if(code > 57 || code < 48){            
                //toastr.error("solo puede tener numeros");
                return false;        
            }else{
                if((value.length + 1) > 300){
                    toastr.error("solo puede tener 300 digitos",'Error', {timeOut: 3000});
                    return false;
                }else{
                    return true;
                }           
            }            
        });
        $("#txtcelrep").keypress(function (tecla) {
            var value = $("#txtcelrep").val();
            var code=tecla.charCode;
            if(code === 8){
                return true;
            }
            if(code > 57 || code < 48){            
                //toastr.error("solo puede tener numeros");
                return false;        
            }else{
                if((value.length + 1) > 300){
                    toastr.error("solo puede tener 300 digitos",'Error', {timeOut: 3000});
                    return false;
                }else{
                    return true;
                }           
            }           
        });
        $("#txtdirrep").keypress(function (tecla) {
            var value = $("#txtdirrep").val();
            if((value.length + 1) > 10000){
                toastr.error("solo puede tener 10000 caracteres",'Error', {timeOut: 3000});
                return false;
            }else{
                return true;
            }           
        });
        // txtnomrep
        // txtaprep
        // txtcirep
        // txtnitrep
        // txtmailrep
        // txttelrep
        // txtcelrep
        // txtdirrep
        // txtfncrep
});




