$(document).ready(function(){
    $(".danger").click(function(){
        return confirm("Realmente desea borrar este registro?");
    })
});