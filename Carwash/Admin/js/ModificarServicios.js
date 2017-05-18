
$( function() {

    //===========================================================================//
    //CUANDO SE HACE CLICK EN UN SEVICIO//
    $("table#Tablita .list-group-item").click(function (Event) { //Evento para desplegar el modal

        $("#myModalLabel").text("Modificar " + this.name + " "); //Titulo del modal

        $('#nombre').val(this.name); //Nombre del servicio
        $('#precio').val(this.value); //Precio del servicio

        var Idservicio= this.title.substring(0,this.title.length-1);//Id Servicio
        $('#idserv').val(Idservicio);

        var Estado=this.title.substring(this.title.length-1,this.title.length) //estado servicio
        $("select#estado").val(Estado);

        $("#imgServ").attr("src", "GetImage.php?id=" + Idservicio); //Imagen del servicio
        $("#imgServ").show();

        // Cambio de color al boton de ativo e inactivo
        if(Estado==1){
            $("select#estado").attr("class","alert-success text-justify")
        }else{
            $("select#estado").attr("class","alert-danger text-justify")
        }

        $("select#estado").click(function () {
            if(this.value==1){
                $("select#estado").attr("class","alert-success text-justify")
            }else{
                $("select#estado").attr("class","alert-danger text-justify")
            }
        });
        //

        $('#myModal').modal("show");//Despliega el modal
    });


    $("#submitModif").click(function (Event) { //Cuando se guardan las modificaciones se sube el formulario
        $("#subir").submit();
    });


    //=============================================================================//
    /* SI SE SELECCIONA IMAGEN DESPLEGARLA EN EL MODAL*/
    $('#archivoI').change(function(e) {
        addImage(e);
    });

    function addImage(e){
        var file = e.target.files[0], imageType = /image.*/;
        if (!file.type.match(imageType)){
            return;
        }

        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    }
    function fileOnload(e) {
        var result=e.target.result;
        $('#imgServ').attr("src",result);
        $('#imgServ').show();
    }



});

