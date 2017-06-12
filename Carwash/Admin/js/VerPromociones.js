$(function () {
    $("#body .btn-group").click(function () {
        $.ajax({
            url :"ObtenerDatosPaquete.php",
            cache: false,
            type : "POST",
            dataType : "json",
            data : {idpaquete : this.value}, //datos a enviar

            success: function (dataResponse) {
                $("#myModalLabel").text(dataResponse.nombreP);
                $("#Nom").val(dataResponse.nombreP)
                $("#fecha").val(dataResponse.fechaP)
                $("#importe").val(dataResponse.importe)
                $("#descuento").val(dataResponse.Descuento)
                $("#total").val(dataResponse.Total)

                $("#idProm").val(dataResponse.idPromo)

                //Se guarda un estado por default en caso de que no cambie el toggle
                $("#state").val(dataResponse.state)

                //Cambia el toggle dependiendo del estado del servicio
                $("#toggle").bootstrapToggle( (dataResponse.state==1) ? "on": "off" )

                //En caso de que cambie el estado del toggle button se almacena
                $("#toggle").change(function () {
                    $("#state").val( ($(this).prop('checked')==true) ? 1:0  )
                });
                $("#imgServ").attr("src", "../GetPromotionImage.php?numProm=" + dataResponse.idPromo); //Imagen del servicio
                $("#imgServ").show();

            },
            error : function(dataResponse) { //En caso de fallar
                alert("error")
            }
        });
        $("#myModal").modal("show")

    })

    $("#submitModif").click(function () {
        if( $("#Nom").val()==""){
            alert("Error, hay campos vacios")
        }else{
            $("#formEditaPromo").submit()
        }
    })

    $("#descuento, #importe").change(function () {
        if($(this).val()<0){
            $(this).val(0)
        }
    })

    //=============================================================================//
    /* SI SE SELECCIONA IMAGEN SE DESPLEGARLA EN EL MODAL*/
    $('#archivito').change(function(e) {
        addImage(e);
    });

    function addImage(e){
        var file = e.target.files[0], imageType = /image.*/;
        if (!file.type.match(imageType)){
            return;
        }
        if(! (file.size > 0 && file.size <= 950000) ) {
            alert("Imagen demasiado grande")
            $("#archivo").val("")
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




})