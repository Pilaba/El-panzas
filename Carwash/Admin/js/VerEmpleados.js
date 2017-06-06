$(function () {
    $("#body .btn-group").click(function () {
        $.ajax({
            url :"ObtenerDatosEmpleado.php",
            cache: false,
            type : "POST",
            dataType : "json",
            data : {idEmp : this.value}, //datos a enviar

            success: function (dataResponse) {
                $("#myModalLabel").text("Trabajador: "+dataResponse.name);
                $("#Nom").val(dataResponse.name)
                $("#Correo").val(dataResponse.mail)
                $("#Telefono").val(dataResponse.tel)
                $("#Direccion").val(dataResponse.address)
                $("#Salario").val(dataResponse.salary)
                $("#FechaIngreso").val(dataResponse.dateIng)
                //Genero
                if(dataResponse.gender=='h'){
                    $("input.gen:eq(0)").attr("checked","checked")
                }else{
                    $("input.gen:eq(1)").attr("checked","checked")
                }
                //Turno
                switch (dataResponse.turn){
                    case 'm': $("input.turn:eq(0)").attr("checked","checked")
                        break;
                    case 'v':$("input.turn:eq(1)").attr("checked","checked")
                        break;
                    case 'd': $("input.turn:eq(2)").attr("checked","checked")
                        break;
                }
                //SE RESETEAN LOS CHECKBOX
                $("input.pibe").prop("checked", false);

                //Se ponen seleccionan los checkbox correctos
                for (var i=0; i<$("input.pibe").length; i++) {
                    for (var j = 0; j < dataResponse.Roles.length; j++) {
                        if ($("input.pibe:eq('" + i + "')").attr("value") == dataResponse.Roles[j]) {
                            $("input.pibe:eq('" + i + "')").prop("checked", true);
                        }
                    }
                }
                $("#idEmp").val(dataResponse.idEmp)

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
        if( $("#Nom").val()==0 ||
            $("#Correo").val()==0  ||
            $("#Telefono").val()==0 ||
            $("#Direccion").val()==0 ||
            $("#Salario").val()==0 ||
            $("#FechaIngreso").val()==0 ||
            !($("#roles td label input.pibe").is(":checked")) ){
            alert("Error, hay campos vacios")
        }else{
            $("#formEditarEmpleado").submit()
        }
    })
})