$(function () {//cuando el DOM este listo
    $("table#TCaja .alert-info").click(function () {
        idPaq=this.value;

        //PETICION AJAX PARA RECUPERAR INFORMACION DE LA BD Y DESPLEGARLA EN EL MODAL
        $.ajax({
            url  : "ObtenerServicios.php", //Direccion url que recibira la peticion ajax
            cache: false,
            type : "POST", //modo
            data : {idpaq : idPaq}, //datos a enviar

            success: function (dataResponse) { //En caso de ser positiva
                JsonServicios=$.parseJSON(dataResponse) //Data desde PHP {array encode}

                newul=$("<ul id='ColeccionServicios'> </ul>") //nueva unordered list que contendra estos servicios
                $.each(JsonServicios, function (key, value) {
                    newul.append("<li>"+ value +"</li>") //para cada servicio se insertan en la nueva ul
                })
                $("#ColeccionServicios").replaceWith(newul) //finalmente se reemplaza la anterior ul por la nueva

            },

            error : function(dataResponse) { //En caso de fallar
                $('#myModal div.modal-body').replaceWith('<div class="modal-body"> No se han podido recuperar los datos</div>'); //En caso de error
            }

        });

       $('#myModal').find("#myModalLabel").text("Paquete No. "+this.value) //Titulo con el numero del paquete
       $('#myModal').modal("show");//Despliega el modal
    })
})