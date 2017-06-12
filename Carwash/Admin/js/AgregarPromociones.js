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
            //SOY UN MENDIGO GENIO :D - Se verifica si en el array de servicios esta el servicio, si no existe se procede a agreagarlo
            if( !($vararray.indexOf($item.find("input.id").attr("value")) >=0) ){
                var $list = $( "ul", $paquete ).length ?
                    $( "ul", $paquete ) :
                    $( "<ul class='list-group' id='paquete'/>" ).appendTo( $paquete );

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

        if($("#nombrePromo").val()==0){
            $("#nombrePromo").tooltip().mouseover()
            return false;
        }

        if(parseInt($("#sum").text()) < 0){
            alert("¡El total no puede ser negativo!")
            return false;
        }

        if(parseInt($("#discount").val()) < 0){
            alert("¡El descuento no puede ser negativo!")
            return false;
        }

        if(! $("#imgSalida").hasClass("true") ){
            $("#archivo").tooltip().mouseover()
            return false;
        }

        var nombrePromo= $("#nombrePromo").val();
        var descuentu= (isNaN(parseInt($("#discount").val()))) ? 0 : parseInt($("#discount").val());
        var subtotal= parseInt( $("td#sub").text() ) ;

        //Mandando los datos al servidor php para que los inserte a la BD
        $.ajax({
            url  : "AgregarPromo.php",
            cache: false,
            type : "POST",
            dataType : "json",
            data : {servicios : $vararray,
                desc: descuentu,
                sub: subtotal,
                nombreP: nombrePromo},

            success: function(dataResponse) {
                if(dataResponse.Error=="Error"){
                    alert("Ya existe una promocion con este nombre");
                }else{
                    $vararray=new Array(); //Se borran los servicios en la promo
                    $("#idPromo").val(dataResponse.IDpaq) //Se pasa el id  al formulario para subir la imagen
                    $("#NomPromo").val(nombrePromo) //Nombre de promo
                    $("#FormUpload").submit()
                }
            },
            error : function(dataResponse) {
                alert("Ya existe una promocion con este nombre");
            }
        })
    });

    //Para agregar imagen de la promocion
    $('#archivo').change(function(e) {
        var clone = $(this).clone();
            clone.attr({'id':"clone","name":"Archii"});
            $("#clone").replaceWith(clone)
        addImage(e);
    });

    function addImage(e){
        var file = e.target.files[0],
            imageType = /image.*/;
        if (!file.type.match(imageType)){
            return;
        }

        //Validar tamaño de imagen
        if(! (file.size > 0 && file.size <= 950000) ) {
            alert("Imagen demasiado grande")
            $("#container").removeAttr("style");
            $("#imgSalida").remove()
            $("#archivo").val("")
            return;
        }
        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    }

    function fileOnload(e) {
        var result=e.target.result;
        //Se reemplaza la imagen anterior, con la nueva que se selecciono
        $("#container").css("height","400px").html(
            $("<img id='imgSalida' class='true'>").attr({ "src": result , "height" :"100%" , "width" :"100%"}).show()
        )
    }
});