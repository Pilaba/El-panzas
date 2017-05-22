
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

        //Se guarda un estado por default en caso de que no cambie el toggle
        $("#state").val(Estado)

        //Cambia el toggle dependiendo del estado del servicio
        $("#toggle").bootstrapToggle( (Estado==1) ? "on": "off" )

        //En caso de que cambie el estado del toggle button se almacena
        $("#toggle").change(function () {
            $("#state").val( ($(this).prop('checked')==true) ? 1:0  )
        });

        $("#imgServ").attr("src", "GetImage.php?id=" + Idservicio); //Imagen del servicio
        $("#imgServ").show();

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

