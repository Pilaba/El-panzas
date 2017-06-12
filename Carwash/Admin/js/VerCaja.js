$(function () {//cuando el DOM este listo
    $("#body .alert-info, #AlmacenEvento").click(function () {
        //PETICION AJAX PARA RECUPERAR INFORMACION DE LA BD Y DESPLEGARLA EN EL MODAL
        $.ajax({
            url  : "ObtenerServicios.php", //Direccion url que recibira la peticion ajax
            cache: false,
            type : "POST", //modo
            dataType : "json",
            data : {idpaq : this.value}, //datos a enviar

            success: function (dataResponse) { //En caso de ser positiva
                // =======LA RESPUESTA SE COLOCAN EN EL MODAL DE PROPOSITO GENERAL ==========//
                $newul=$("<ul id='ColeccionServicios' class='list-group'> </ul>") //nueva unordered list que contendra estos servicios
                $.each(dataResponse.servicios, function (key,value) {
                    $newul.append("<li class='list-group-item alert-warning'> <strong>"+ value +"</strong></li>") //para cada servicio se insertan en la nueva ul
                })

                $("#ColeccionServicios").replaceWith($newul) //finalmente se reemplaza la anterior ul por la nueva

                //Se cambia la matricula
                $newMatricula=$("<ul id='Matricula' class='list-group'>Matricula <li class='list-group-item alert-warning'><strong> "+dataResponse.MatrVehiculo+"</strong></li> </ul>")
                $("#Matricula").replaceWith($newMatricula)

                //Se cambia el tipo de vehiculo
                $newTipoVehiculo=$("<ul id='Tipovehiculo' class='list-group'>Tipo de vehiculo <li class='list-group-item alert-warning'> <strong>"+dataResponse.NomVehiculo+"</strong></li> </ul>")
                $("#Tipovehiculo").replaceWith($newTipoVehiculo)
            },
            error : function(dataResponse) { //En caso de fallar
                alert("error")
            }
        });

       $('#myModal').find("#myModalLabel").text("Datos del paquete") //Titulo con el numero del paquete
       $('#myModal').modal("show");//Despliega el modal
    })

    //======================Cuando se selecciona mostrar por================================================
    $("#mostrarCajapor").change(function () {
        //En caso de seleccionar la opcion 3  "Fecha especifica"
        if(this.value==3){
            $("#datepicker").show("blind", 500)
            return false;
        }else{
            $("#datepicker").hide("blind", 500) //Se oculta el datepicker
            peticion_Ajax(this.value,null,null) //se realiza la peticion ajax de manera normal
        }
    })

    function peticion_Ajax(option,fechaFrom,fechaTo) {
        $.ajax({
            url  : "TablaMostrarCaja.php", //Direccion url que recibira la peticion ajax
            cache: false,
            type : "POST", //modo
            dataType : "json",
            data : {seleccion : option, Fromm : fechaFrom, Too: fechaTo}, //datos a enviar

            success: function (dataResponse) {
                $body=$('<tbody id="body"></tbody>') //Nuevo body de la tabla

                for (var i=0, puntero=0; i<dataResponse.resp.length/5; i++, puntero+=5) {
                    //Se hace una copia del listener que se guardo
                    $copia=$("#AlmacenEvento").clone(true).first()
                    $copia.css("display","block")
                    $newtr=$('<tr class="alert-success"></tr>') //Nueva fila

                    $copia.val(dataResponse.resp[puntero+1]) //chaining :D
                        .html( $("<span class='glyphicon glyphicon-zoom-in'></span>") )
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
                alert("Error")
            }
        });
    }

    //=================EVENTOS PARA EL DATE PICKER=============================//
    var dateFormat = "DD, d MM, yy"
    from = $( "#FROM" ).datepicker({
        changeMonth: true,
        numberOfMonths: 1,
        showAnim: "clip",
        altField: "#FROM",
        altFormat: "DD, d MM, yy"
    }).on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
    })

    to = $( "#TO" ).datepicker({
        changeMonth: true,
        numberOfMonths: 1,
        showAnim: "clip",
        altField: "#TO",
        altFormat: "DD, d MM, yy"
    }).on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
    });

    function getDate( element ) {
        return $.datepicker.parseDate( dateFormat, element.value );
    }

    //============EVENTO PARA ACEPTAR DEL DATEPICKER===================//
    $("#AceptarDatepicker").click(function () {
        if($("#FROM").val()==0 || $("#TO").val()==0){
            return false;
        }else{
            var valorFROM = $('#FROM').datepicker('getDate');
            var valorTO = $('#TO').datepicker('getDate' , "+1d");
            valorTO.setDate(valorTO.getDate()+1)

            var dateFrom=$.datepicker.formatDate('yy-mm-dd', valorFROM)
            var dateTo=$.datepicker.formatDate('yy-mm-dd', valorTO)

            peticion_Ajax(3,dateFrom,dateTo) //3 equivale a fecha especifica+
        }
    })

    //=======================DATEPICKER TRADUCCION A ESPAÑOL ==========================//
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Anterior',
        nextText: 'Siguiente>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'DD, d MM, yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    //=======================DATEPICKER TRADUCCION A ESPAÑOL ==========================//

})


