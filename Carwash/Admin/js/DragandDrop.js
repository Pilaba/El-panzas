$( function() { //Cuando este listo el DOM
    //Galeria <ul> y servicios <div>
    var $gallery = $( "#gallery" ),
        $paquete = $( "#paquete-container" );

    $vararray   = new Array()
    $ArrayPromo = new Array()
    // los items de la galeria se hacen draggables
    $( "li", $gallery ).draggable({
        cancel: "a.glyphicon", // clickear el icono no se activara el drag
        revert: "invalid", // cuando no se droppea en otra posicion, el item vuelve a su posicion inicial
        containment: "document",
        helper: "clone", //el item se clona
        cursor: "pointer", //el cursor cambia cuando se esta moviendo el item
        zIndex: 2 //Para que este encima de cualquier otra caja
    });

    $("#panelBody").droppable({
        accept: "div#paquete-container > ul > li", //si hay problemas usar "ul > li" para mas facil - solo acepta items <li> dentro del elemento con el id #paquete-container
        classes: {
            "ui-droppable-active": "custom-state-active"
        },
        drop: function( event, ui ) {//Cuando un item se dropea en galeria este llama a otra funcion, el evento no se toma en cuenta, solo el elemento draggable
            recycleImage( ui.draggable );
        }
    });


    // el paquete donde se almacenaran los items se hace droppable
    $paquete.droppable({
        accept: "#gallery > li", //solo se permiten elementos <li> que tengan como id galleria
        classes: {
            "ui-droppable-active": "ui-state-highlight" //se activa cuando un item puede ser dropeado dentro del paquete
        },
        drop: function( event, ui ) { //funcion cuando se dropea un item dentro del paquete
            deleteImage(ui.draggable)
        }
    });

    var recycle_icon = "<a href='#' class='glyphicon glyphicon-minus'>Eliminar X</a>"; //se agregara este icono cuando este dentro del paquete
    function deleteImage( $item ) {
        $item.fadeOut(function() { /*$item = elemento que se eliminara -> ui.draggable*/
            /* con el operador ternario se verifica que exista una <ul> en "#paquete-container" y que contenga elementos,
             *  en caso de que no existe tal <ul> la variable toma una referencia a un <ul> vacio en "#paquete-container"
             *  en caso de que ya exista tal lista y tenga elementos simplemente se añade un nuevo item a la lista <ul> que tenga la clase "list-group"
             * */
            //En donde se almacenara el nuevo item utilizando un operador ternario
            var $list = $( "ul", $paquete ).length ?
                $( "ul", $paquete ) :
                $( "<ul class='list-group' id='paquete'/>" ).appendTo( $paquete );

            //SOY UN MENDIGO GENIO :D - Se verifica si en el array de servicios esta el servicio, si no existe se procede a agreagarlo
            if( !($vararray.indexOf($item.find("input.nombre").attr("value")) >=0) ){

                //En caso de ser promo se desactivaran los servicios que contiene la promocion y se eliminar del paquete
                if($item.find("input.promo").attr("value") == 1){
                    var idProm=$item.find("input.id").attr("value")
                    $.ajax({
                        url  : "AjaxPetitions/getServicesInPromo.php",
                        type : "POST",
                        dataType : "json",
                        data : {idPaquete : idProm },
                        success: function(dataResponse) {
                            //Si se agrega un paquete se eliminan los servicios que ya se seleccionaron
                            $.each(dataResponse.NomServicios, function (K,V) {
                                $.each( $("ul#paquete > li"), function () {
                                    if(V==$(this).find("input.nombre").val()){
                                        $(this).css({"pointer-events": "none", "filter": "gray" , "-webkit-filter" : "grayscale(1)"})
                                        $(this).find("a").click()
                                    }
                                })
                            })

                            //Los servicios dentro de la promocion se desabilitan y las promociones tambien
                            $.each(dataResponse.idServicios, function (key,value) {
                                $.each($("#gallery li.Servicio"), function () {
                                    if(value==$(this).find("input.id").val()){
                                        $(this).css({"pointer-events": "none", "filter": "gray" , "-webkit-filter" : "grayscale(1)"}) //Gris y disable
                                    }
                                })
                                $("#gallery li.promo").css({"pointer-events": "none", "filter": "gray" , "-webkit-filter" : "grayscale(1)"}) //Las promos se inhabilitan
                            })
                            $ArrayPromo.push(idProm) //Se agrega el id del promo que se selecciono
                        }
                    })
                }

                //para agregar item a la canasta o paquete
                nombreServicio=$item.find("input.nombre").attr("value")
                $vararray.push(nombreServicio)  /*Nombre del servicio */
                $vararray.push($item.find("input.precio").attr("value"))  /*Precio base del servicio */
                $vararray.push($item.find("input.id").attr("value"))

                $item.find( "a.glyphicon-plus" ).remove(); /*Eliminas el icono para poder remplazarlo con el nuevo  */

                sortable($vararray) //LLamada a la funcion para que actualice el detalle de los servicios

                $item.append( $(recycle_icon ,"a").text("Eliminar "+nombreServicio)  ).appendTo( $list ).fadeIn()  //agreaga el nuevo icono al item, este item se agrega a la lista y se a�ade un efecto
            }
        });
    }

    // Image recycle function
    var trash_icon = "<a href='#' class='glyphicon glyphicon-plus'>Agregar X</a>"; //se agregara este icono cuando este dentro de servicios
    function recycleImage( $item ) {
        //para eliminar item de la canasta o paquete
        //Se verifica si en el array de servicios existe tal servicio, en caso de que si, se procede a eliminarlo
        if( ( $vararray.indexOf($item.find("input.nombre").attr("value") ) >=0) ){

            //En caso de ser promo
            if($item.find("input.promo").attr("value") == 1){
                $("#gallery li.Servicio").removeAttr("style")
                $("#gallery li.promo").removeAttr("style")
                $ArrayPromo.pop();
            }

            //para eliminar item de la canasta o paquete
            removeElemnet=$item.find("input.nombre").attr("value")
            $vararray.splice($vararray.indexOf(removeElemnet),3)

            sortable($vararray) //LLamada a la funcion para que actualice el detalle de los servicios

            $item.fadeOut(function() { // item elemento que se regresara a servicios  */
                $item.find( "a.glyphicon-minus" )
                    .remove()      //Busca el icono en el item y lo elimina
                    .end()
                    .append( $(trash_icon ,"a").text("Agregar "+removeElemnet) ) //agrega el nuevo icono
                    .appendTo( $gallery ) ////este item se agrega a la lista y se a�ade un efecto
                    .fadeIn();
            });
        }
    }

    // comportamiento de los iconos junto a la imagen
    //Para si das click en el "+" o "-" quite a agregue apropiadamente
    $("ul#gallery > li").on( "click", function( event ) { //escucha un click en los elementos <li> del <ul> que tenga como id "gallery"
        var $item = $( this ),     //item que se le dio click
            $target = $( event.target ); //a que icono del item se le dio click

        if ($target.is( "a.glyphicon-plus" ) ) { //si el icono fue "-" el servicio se manda a paquete, pasando como referencia el propio item
            deleteImage( $item );
        } else if ( $target.is( "a.glyphicon-minus" ) ) {
            recycleImage( $item );
        }
        return false;
    });

    function sortable(ArrayServicios){ //SOY UN CAPO :D SIRVE PARA ORDENAR EL DETALLE DE LOS SERVICIOS
        if( ArrayServicios.length/3 < $("#paquete li").length){ //Si se elimina un servicio se reseteara el descuento a 0
            $("#discount").val(0)
        }

        var Valordescuento=$("#discount").val()  //Guarda el descuento que se ingreso

        $TablaDetalles=$("#tablitaDetalles > tbody")

        $("tr",$TablaDetalles).remove()//Elimina todos los datos anteriores para generar nuevamente el detalle

        var contador = 1,Indice=0,suma=0; //Contador para llevar la cuenta {array, Indice para ArrayServicios, suma para saber la suma de los servicios}
        //Se agregan los detalles del servicio al panel de detalles
        for(contador; contador<=ArrayServicios.length/3; contador++,Indice+=3){
            $TablaDetalles.append("<tr> <td>"+ contador +" </td> <td>"+ArrayServicios[Indice] +"</td> <td>"+ArrayServicios[Indice+1] +"</td></tr>");
            suma+= parseInt(ArrayServicios[Indice+1])
        }

        /*Subtotal del paquete y hace la insercion en la tabla*/
        $TablaDetalles.append("<tr id='subtotal' > " +
            "<td></td> <td>Subtotal</td> <td id='sub'>"+ suma +"</td>" +
            "</tr>");

        /*Descuento del paquete y hace la insercion en la tabla*/
        $TablaDetalles.append("<tr id='descuento' > " +
            "<td></td> <td> Descuento </td> " +
            "<td><input type='number' min='0'  id='discount' value="+ 0 +"></td>" +
            "</tr>");
        $("#discount").val(Valordescuento)

        /*Total y hace la insercion en la tabla*/
        $TablaDetalles.append("<tr title='Total' id='total' class='alert-success'> <td></td> <td> Total </td> <td id='sum' >"+ suma +" </td></tr>");

        //Actualizamos el total en caso de agregar nuevos servicios
        if(isNaN(parseInt( Valordescuento ))){
            $("tr#total > td")[2].innerHTML=suma
        }else{
            $("tr#total > td")[2].innerHTML=suma-parseInt(Valordescuento)
        }

        //Se actualiza el total en caso de cambiar el descuento
        $("#discount").change(function(){
            $("#sum").text( (parseInt($("#sub").text() - parseInt(this.value))) )
            $( "#spiner" ).slider("option", "value", parseInt(this.value))
        });

        $( "#spiner" ).slider({
            range: "max",
            min: 0,
            max: suma,
            value: $("#discount").val(),
            slide: function( event, ui ) {
                $( "#discount" ).val( ui.value );
                $("#sum").text( (parseInt($("#sub").text() - ui.value )) )
            }
        });
    }

    //PARA SUBIR LOS ELEMENTOS
    $("#botonPaquete").click(function (ev) {
        ev.preventDefault()
        //Comprobar que halla servicios en el paquete
        //O tambien $("#paquete").children("li").length==0

        if($("li","#paquete").length==0){
            $("#paquete-container").tooltip().mouseover()
            return false;
        }

        //Comprobar que se coloco la matricula
        if($("#matricula").val()==""){
            $("#matricula").tooltip().mouseover()
            return false;
        }

        //Comprobar que se coloco el tipo de vehiculo
        if($("#tipoVehiculo").val()==0){
            $("#tipoVehiculo").tooltip().mouseover()
            return false;
        }

        if(parseInt($("#sum").text()) < 0){
            alert("¡El total no puede ser negativo!")
            return false;
        }

        var matricula=$("#matricula").val()
        var descuentu= (isNaN(parseInt($("#discount").val()))) ? 0 : parseInt($("#discount").val());
        var subtotal= parseInt( $("td#sub").text() ) ;
        var Idvehiculo=$("#tipoVehiculo").val();

        //Mandando los datos al servidor php para que los inserte a la BD
        $.ajax({
            url  : "RegistrarPaquete.php",
            cache: false,
            type : "POST",
            data : {servicios : $vararray,
                promo : $ArrayPromo,
                matric: matricula,
                desc: descuentu,
                sub: subtotal,
                idvehiculo: Idvehiculo},

            success: function(dataResponse) {
                $Mensajito=$("#MensajeGeneral");
                $Mensajito.attr("class","alert alert-success text-center")
                $Mensajito.find("strong").text(
                    "No. Orden: "+$("em#NumOrden").text()+" " +
                    "Matricula: "+$("#matricula").val()+" " +
                    "Total: "+$("#sum").text()
                );

                $Mensajito.show();
                $Mensajito.fadeTo(4000, 1000).slideUp(1000, function(){
                    $Mensajito.slideUp(1000);
                });

                $("#matricula").val("")
                $("#tipoVehiculo").val(0)
                $("#discount").val(0)
                $("#sum").val(0)
                $("#matr").text("")
                $("#tip").text("")

                $("ul#paquete > li > a").click();
                $vararray=new Array();
                $("em#NumOrden").text(dataResponse);
            },
            error : function(dataResponse) {
                alert("Error")
            }
        })
    });

    $("#matricula").change(function(){
        $("#matr").text($("#matricula").val())
        $.ajax({
            url  : "ObtenervecesdeMatricula.php", //Direccion url que recibira la peticion ajax
            cache: false,
            type : "POST", //modo
            data :{matricula: $("#matricula").val()},
            success: function (dataResponse) { //En caso de ser positiva
                $("#numVeces").text("Num. veces que se han registrado paquetes -> "+dataResponse)
            },
            error : function(dataResponse) { //En caso de fallar
                $("#numVeces").text(0)
            }
        });

    });

    $("#tipoVehiculo").change(function(){
        $("#tip").text(this[this.value].innerHTML) //OMG :o soy un mendigo :D - WADAFAK XD
    });

    /////////////////////////////////////////////MODAL USUARIO
    $("#MiCuenta").click(function () { //Obtener los datos de la cuenta
        $.ajax({
            url  : "../ObtenerDatosdeUsuario.php", //Direccion url que recibira la peticion ajax
            cache: false,
            dataType : "json",
            type : "POST", //modo
            success: function (dataResponse) { //En caso de ser positiva
                $Modal=$('#myModal');

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
        $('#myModal').modal("show");//Despliega el modal
    })

} );