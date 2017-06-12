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
            },
            error : function(dataResponse) { //En caso de fallar
                alert("error")
            }
        });
        $("#myModal").modal("show")
    })

    $("#submitModif").click(function () {
        if($("#Nom").val()==0 ){
            alert("Error, hay campos vacios")
        }else{
            $("#formEditaPromo").submit()
        }
    })
})