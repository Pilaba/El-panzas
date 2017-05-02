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
            $vararray.push($item.find("input#none").attr("value"))

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
        removeElemnet=$item.find("input#none").attr("value")
        $vararray.splice($vararray.indexOf(removeElemnet),1)

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


    //PARA SUBIR LOS ELEMENTOS
    $("#botonPaquete").click(function () {
        //adding  elements to a form
        if($("#nombrecliente").val()==""){
            alert("Oops! Falto ingresar el nombre del cliente")
            return false;
        }

        var contenedor=$("#formChingon")

        for ($i=0; $i<$vararray.length; $i++){
            contenedor.append("<input type='hidden' value="+$vararray[$i]+" name=elemento"+$i+">")
        }

        alert("Cliente: "+$("#nombrecliente").val()+"\nServicios: "+$vararray)
        contenedor.submit()

        return false; //Probando
    })

    //SE VE HERMOSO :,), para quitar la alerta
    $("#dismisThis").fadeTo(2000, 500).slideUp(500, function(){
        $("#dismisThis").slideUp(500);
    });

} );



























