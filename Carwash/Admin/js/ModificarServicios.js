
$( function() {

    $("table#Tablita .list-group-item").click(function (Event) { //Evento para desplegar el modal

        $('#myModal').modal("show")//Despliega el modal

        $("#myModalLabel").text("Modificar " + this.name + " "); //Titulo del modal

        $('#nombre').val(this.name) //Nombre del servicio
        $('#precio').val(this.value)

        var Idservicio= this.title.substring(0,this.title.length-1)
        var Estado=this.title.substring(this.title.length-1,this.title.length)

        $('#idserv').val(Idservicio)

        $("#imgServ").attr("src", "GetImage.php?id=" + Idservicio);
        $("#imgServ").show();
        $("select").val(Estado)
    });


    $("#submitModif").click(function (Event) { //Evento para desplegar el modal
        $("#subir").submit();
    });





});

