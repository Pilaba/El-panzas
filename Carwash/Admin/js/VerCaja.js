$(function () {//cuando el DOM este listo
    $("#body .alert-info").click(function () {
        idPaq=this.value;

        //PETICION AJAX PARA RECUPERAR INFORMACION DE LA BD Y DESPLEGARLA EN EL MODAL
        $.ajax({
            url  : "ObtenerServicios.php", //Direccion url que recibira la peticion ajax
            cache: false,
            type : "POST", //modo
            dataType : "json",
            data : {idpaq : idPaq}, //datos a enviar

            success: function (dataResponse) { //En caso de ser positiva

                // =======LA RESPUESTA SE COLOCAN EN EL MODAL DE PROPOSITO GENERAL ==========//
                $newul=$("<ul id='ColeccionServicios' class='list-group'> </ul>") //nueva unordered list que contendra estos servicios
                $.each(dataResponse.servicios, function (key,value) {
                    $newul.append("<li class='list-group-item alert-warning'> <strong>"+ value +"</strong></li>") //para cada servicio se insertan en la nueva ul
                })
                $("#ColeccionServicios").replaceWith($newul) //finalmente se reemplaza la anterior ul por la nueva

                $newul=$("<ul id='Matricula' class='list-group'>Matricula <li class='list-group-item alert-warning'><strong> "+dataResponse.MatrVehiculo+"</strong></li> </ul>")
                $("#Matricula").replaceWith($newul)

                $newul=$("<ul id='Tipovehiculo' class='list-group'>Tipo de vehiculo <li class='list-group-item alert-warning'> <strong>"+dataResponse.NomVehiculo+"</strong></li> </ul>")
                $("#Tipovehiculo").replaceWith($newul)

            },

            error : function(dataResponse) { //En caso de fallar
                alert("error")
            }

        });

       $('#myModal').find("#myModalLabel").text("Paquete No. "+this.value) //Titulo con el numero del paquete
       $('#myModal').modal("show");//Despliega el modal
    })

    //======================Cuando se selecciona mostrar por===================================================
    $("#mostrarCajapor").change(function () {
        $.ajax({
            url  : "TablaMostrarCaja.php", //Direccion url que recibira la peticion ajax
            cache: false,
            type : "POST", //modo
            dataType : "json",
            data : {seleccion : this.value}, //datos a enviar

            success: function (dataResponse) {
                $body=$('<tbody id="body"></tbody>') //Nuevo body de la tabla
                $evento=$("#body .alert-info").clone(true).first() //Se copia el listener asociado a la tabla anterior {evento del boton}
                for (var i=0,puntero=0; i<dataResponse.resp.length/5; i++, puntero+=5) {
                    $copia=$evento.clone(true) //Se hace una copia del listener anterior para cada fila de la tabla

                    $newtr=$('<tr class="alert-success"></tr>') //Nueva fila

                    $copia.val(dataResponse.resp[puntero]) //chaining :D
                        .text(dataResponse.resp[puntero])
                        .addClass("alert-info")

                    $newtr.append($('<td></td>').append($copia)) //El boton se coloca dentro de un <td>

                    $newtr.append('<td>'+ dataResponse.resp[puntero+1] +'</td>') //Valores para cada fila
                    $newtr.append('<td>'+ dataResponse.resp[puntero+2] +'</td>')
                    $newtr.append('<td>'+ dataResponse.resp[puntero+3] +'</td>')
                    $newtr.append('<td>'+ dataResponse.resp[puntero+4] +'</td>')
                    $newtr.appendTo($body) //La fila se coloca dentro del body de la nueva tabla
                }

                $("tbody#body").remove() //Se elimina el body de la tabla anterior
                $body.appendTo($("#TCaja")) //se inserta la nueva tabla recien creada
            },
            error : function(dataResponse){
                alert("Aun no esta programado eso!!!")
            }
        });


    })







})


