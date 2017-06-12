
$(function () {
    $("#MiCuenta").click(function () { //Obtener los datos de la cuenta
        $.ajax({
            url  : "ObtenerDatosdeUsuario.php", //Direccion url que recibira la peticion ajax
            cache: false,
            dataType : "json",
            type : "POST", //modo
            success: function (dataResponse) { //En caso de ser positiva

                var Datos = new Array(dataResponse.nombre, dataResponse.correo, dataResponse.tel) //Datos del usuario
                var Ids = new Array("nombre","correo","telefono")

                $("#myModalTitle").text("Datos de usuario")
                $("#title").text(Datos[0])
                formulario=$("<form id='CambioDatos' action='Index.php' method='post'></form>")
                for (var i=0; i<3; i++){
                    formGroup=$("<div class='form-group'> </div>")
                    label=$("<label class='col-md-3 control-label'>"+ Ids[i]+"</label>");
                    Divisor=$("<div class='col-md-9'></div>")
                    if(i==2){ //Cuando el input sea telefono
                        input=$("<input class='form-control' onKeyPress='if(this.value.length==10) return false;' min='0' id='"+Ids[i]+"' name='"+Ids[i]+"' type='number' value='"+Datos[i]+"'>")
                    }else if(i==1){
                        input=$("<input class='form-control' maxlength='30' id='"+Ids[i]+"' name='"+Ids[i]+"' type='email' value='"+Datos[i]+"'>")
                    }else{
                        input=$("<input class='form-control' maxlength='30' id='"+Ids[i]+"' name='"+Ids[i]+"' type='text' value='"+Datos[i]+"'>")
                    }
                    $("#PanelBody").children().remove().end().append(formulario.append(formGroup.append(label,Divisor.append(input)))) //CHAINING IN ACTION Level 5
                }
            },
            error : function(dataResponse) { //En caso de fallar
                alert("error")
            }
        });

        //Boton de guardar cambios
        $("#Cambios").click(function () {
            if($("#Matr").hasClass("pisho")){ //Elimina interferencias entre modales
                return;
            }
            if($("#nombre").val()=="" || $("#correo").val()=="" ){ //Validar entradas
                alert("Hay campos vacios")
                return false;
            }else if (!/^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i.test($("#correo").val())){ //Validar Email
                alert("Email incorrecto")
                return false;
            }else{
                $("#CambioDatos").submit()
            }
        })
        //Despliega el modal
        $('#myModal').modal("show");
    })

    /////////////////////////DAR DE ALTA MATRICULA//////////////////////////////////////////////////////////////
    var contador=0; //paraa evitar demasiados intentos

    $("#DarAlta").click(function () {
        $("#myModalTitle").text("Dar de alta matricula")
        $("#title").text("Usuario")
        $("#PanelBody").html("<label for='Matr'> Matricula</label><br><input class='pisho' type='text' id='Matr' name='Matr' maxlength='8'>");


        //Guardar cambios
        $("#Cambios").click(function () {
            if($("#Matr").val()==""){
                alert("Ingresa una matricula")
                return false;
            }
            $.ajax({
                url  : "DarAltavehiculo.php", //Direccion url que recibira la peticion ajax
                cache: false,
                data: {matricula : $("#Matr").val(), contador: contador},
                type : "POST",
                dataType : "json",
                success: function (dataResponse) { //En caso de ser positiva
                    if(dataResponse.exito=="true"){
                        contador=dataResponse.contadorr
                        alert("Exito, matricula registrada correctamente")
                    }else{
                        alert("Error, matricula inexistente")
                    }
                    contador++;
                },
                error : function(dataResponse) { //En caso de fallar
                    alert("has superado el numero maximo de intentos")
                }
            });
        })
        $('#myModal').modal("show");//Despliega el modal
    })





})
