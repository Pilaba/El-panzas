
$("table#Tablita .list-group-item").click(function(Event){

    $('#myModal').modal("show")

    $('#nombre').val(this.name)
    $('#precio').val(this.value)
    $("#myModalLabel").text("Modificar \"" +this.name+"\"");


});