$( function() { //Cuando este listo el DOM
    //Galeria <ul> y servicios <div>
    var $gallery = $( "#gallery" ),
        $paquete = $( "#paquete-container" );

    $vararray=new Array()
    // los items de la galeria se hacen draggables
    $( "li", $gallery ).draggable({
        cancel: "a.glyphicon", // clickear el icono no se activara el drag
        revert: "invalid", // cuando no se droppea en otra posicion, el item vuelve a su posicion inicial
        containment: "document",
        helper: "clone", //el item se clona
        cursor: "move", //el cursor cambia cuando se esta moviendo el item
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

    var recycle_icon = "<a href='#' class='glyphicon glyphicon-minus'>Eliminar</a>"; //se agregara este icono cuando este dentro del paquete
    function deleteImage( $item ) {
        $item.fadeOut(function() { /*$item = elemento que se eliminara -> ui.draggable*/
            /* con el operador ternario se verifica que exista una <ul> en "#paquete-container" y que contenga elementos,
             *  en caso de que no existe tal <ul> la variable toma una referencia a un <ul> vacio en "#paquete-container"
             *  en caso de que ya exista tal lista y tenga elementos simplemente se añade un nuevo item a la lista <ul> que tenga la clase "list-group"
             * */
            var $list = $( "ul", $paquete ).length ?
                $( "ul", $paquete ) :
                $( "<ul class='list-group' id='paquete'/>" ).appendTo( $paquete );

            $item.find( "a.glyphicon-plus" ).remove(); /*Eliminas el icono para poder remplazarlo con el nuevo  */

            //para agregar item a la canasta o paquete
            $vararray.push($item.find("input#nombre").attr("value"))  /*Nombre del servicio */
            $vararray.push($item.find("input#precio").attr("value"))  /*Precio base del servicio */
            $vararray.push($item.find("input#id").attr("value"))

            sortable($vararray) //LLamada a la funcion para que actualice el detalle de los servicios

            $item.append( recycle_icon ).appendTo( $list ).fadeIn(function() { //agreaga el nuevo icono al item, este item se agrega a la lista y se añade un efecto
                $item
                    .animate()
                    .find( "img" )
                    .animate();
            });

        });
    }

    // Image recycle function
    var trash_icon = "<a href='#' class='glyphicon glyphicon-plus'>Agregar</a>"; //se agregara este icono cuando este dentro de servicios
    function recycleImage( $item ) {
        //para eliminar item de la canasta o paquete
        removeElemnet=$item.find("input#nombre").attr("value")
        $vararray.splice($vararray.indexOf(removeElemnet),3)

        sortable($vararray) //LLamada a la funcion para que actualice el detalle de los servicios

        $item.fadeOut(function() { // item elemento que se regresara a servicios  */
            $item.find( "a.glyphicon-minus" )
                .remove()      //Busca el icono en el item y lo elimina
                .end()
                .css( "width", "") //No modifica el css
                .append( trash_icon ) //agrega el nuevo icono
                .find( "img" )
                .css( "height", "" )
                .end()
                .appendTo( $gallery ) ////este item se agrega a la lista y se añade un efecto
                .fadeIn();
        });
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
        var descuento=$("#discount").val() //Guarda el descuento que se ingreso

        $("#tablitaDetalles > tbody > tr").remove()//Elimina todos los datos anteriores para generar nuevamente el detalle

        var contador = 1,Indice=0,suma=0; //Contador para llevar la cuenta {array, Indice para ArrayServicios, suma para saber la suma de los servicios}
        //Se agregan los detalles del servicio al panel de detalles
        for(contador; contador<=ArrayServicios.length/3; contador++,Indice+=3){
            $("#tablitaDetalles > tbody").append("<tr> <td>"+ contador +" </td> <td>"+ArrayServicios[Indice] +"</td> <td>"+ArrayServicios[Indice+1] +"</td></tr>");
            suma+= parseInt(ArrayServicios[Indice+1])
        }

        /*Subtotal del paquete y hace la insercion en la tabla*/
        $("#tablitaDetalles > tbody").append("<tr id='subtotal' > " +
            "<td></td> <td>Subtotal</td> <td id='sub'>"+ suma +"</td>" +
            "</tr>");
        /*Descuento del paquete y hace la insercion en la tabla*/
        $("#tablitaDetalles > tbody").append("<tr id='descuento' > " +
            "<td></td> <td> Descuento </td> " +
            "<td><input type='number' id='discount' value="+ descuento +"></td>" +
            "</tr>");
        /*Total y hace la insercion en la tabla*/
        $("#tablitaDetalles > tbody").append("<tr id='total' class='alert-success'> <td></td> <td> Total </td> <td id='sum'>"+ suma +" </td></tr>");

        //Actualizamos el total en caso de agregar nuevos servicios
        if(isNaN(parseInt( $("#discount").val() ))){
            $("tr#total > td")[2].innerHTML=suma
        }else{
            $("tr#total > td")[2].innerHTML=suma-parseInt($("#discount").val())
        }

        //Se actualiza el total en caso de cambiar el descuento
        $("#discount").change(function(){
            $("tr#total > td")[2].innerHTML=(parseInt($("tr#subtotal > td")[2].innerHTML))-this.value
        });
    }

    //PARA SUBIR LOS ELEMENTOS
    $("#botonPaquete").click(function (evento) {
        evento.preventDefault()

        //Comprobar que halla servicios en el paquete
        //O tambien $("#paquete").children("li").length==0
        if($("li","#paquete").length==0){
            alert("Oops! No hay servicios seleccionados")
            return false;
        }

        //Comprobar que se coloco la matricula
        if($("#matricula").val()==""){
            alert("Oops! Falta la matricula")
            return false;
        }

        //Comprobar que se coloco el tipo de vehiculo
        if($("#tipoVehiculo").val()==0){
            alert("Oops! Selecciona Tipo de Vehiculo")
            return false;
        }

        var matricula=$("#matricula").val()
        var descuentu= (isNaN(parseInt($("#discount").val()))) ? 0 : parseInt($("#discount").val());
        var subtotal= parseInt($("tr#subtotal > td")[2].innerHTML);
        var Idvehiculo=$("#tipoVehiculo").val();

        //Mandando los datos al servidor php para que los inserte a la BD
        $.ajax({
            url  : "RegistrarPaquete.php",
            cache: false,
            type : "POST",
            data : {servicios : $vararray,
                    matric: matricula,
                    desc: descuentu,
                    sub: subtotal,
                    idvehiculo: Idvehiculo},

            success: function(dataResponse) {
                alert(dataResponse)
            },

            error : function(dataResponse) {
                alert(dataResponse);
            }
        })
    })

    $("#matricula").change(function(){
        $("div.panel-heading > strong")[0].innerHTML=$("#matricula").val()
    });

    $("#tipoVehiculo").change(function(){
        //alert(this[this.value].innerHTML) //SOY UN PERRO DEL AGUA :D
        $("div.panel-heading > strong")[1].innerHTML=this[this.value].innerHTML //OMG :o soy un mendigo :D
    });



    //SE VE HERMOSO :,), para quitar la alerta
    /*$("#dismisThis").fadeTo(2000, 500).slideUp(500, function(){
        $("#dismisThis").slideUp(500);
    });*/


} );



























