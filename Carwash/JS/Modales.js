
$(function () {
    $("#help").click(function () {
        $("#PanelBody").children().remove() //Se elimina lo que este en el body del panel
       $("#myModal").modal("show")
    })

    $("#services").click(function () {
        $("#PanelBody").children().remove() //Se elimina lo que este en el body del panel
        $("#myModal").modal("show")
    })

    $("#contact").click(function () {
        $("#myModal").modal("show")
        $("#PanelBody").children().remove() //Se elimina lo que este en el body del panel

    })


    $("#MiCuenta").click(function () { //Obtener los datos de la cuenta
        $.ajax({
            url  : "ObtenerDatosdeUsuario.php", //Direccion url que recibira la peticion ajax
            cache: false,
            dataType : "json",
            type : "POST", //modo
            success: function (dataResponse) { //En caso de ser positiva
                $Modal=$('#myModal');

                var Datos = new Array(dataResponse.nombre, dataResponse.correo, dataResponse.tel) //Datos del usuario
                var Ids = new Array("nombre","correo","telefono")

                $("#myModalTitle").text(Datos[0])
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
                    $("#PanelBody").append(formulario.append(formGroup.append(label,Divisor.append(input)))) //CHAINING IN ACTION
                }

            },
            error : function(dataResponse) { //En caso de fallar
                alert("error")
            }
        });
        $('#myModal').modal("show");//Despliega el modal
    })

    $("#Cambios").click(function () {
        $("#CambioDatos").submit()
    })






})