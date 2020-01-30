/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#btnARelativa').click(function (evento) {
        evento.preventDefault();
        var fecha = $("#fecha").val();
        var metodo = "relativa";
        $.ajax({
            type: "POST",
            url: "./PConvertirFecha.php",
            data: "metodo=" + metodo + "&fecha=" + fecha,
            success: function (data) {
                console.log(data);
                $("#resultadoRelativa").val(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $('#btnAGregoriana').click(function (evento) {
        evento.preventDefault();
        var numero = $("#numero").val();
        var metodo = "gregoriana";
        $.ajax({
            type: "POST",
            url: "./PConvertirFecha.php",
            data: "metodo=" + metodo + "&numero=" + numero,
            success: function (data) {
                console.log(data);
                $("#resultadoGregoriana").val(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });
});
