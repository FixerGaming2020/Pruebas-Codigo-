/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#btnEncriptar').click(function (evento) {
        evento.preventDefault();
        var metodo = "encriptar";
        $.ajax({
            type: "POST",
            url: "./PEncriptar.php",
            data: $("#formEncriptar").serialize() + "&metodo=" + metodo,
            success: function (data) {
                $("#resultadoEncriptar").val(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $('#btnDesencriptar').click(function (evento) {
        evento.preventDefault();
        var metodo = "desencriptar";
        $.ajax({
            type: "POST",
            url: "./PEncriptar.php",
            data: $("#formDesencriptar").serialize() + "&metodo=" + metodo,
            success: function (data) {
                $("#resultadoDesencriptar").val(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

});