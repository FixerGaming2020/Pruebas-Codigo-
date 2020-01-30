/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarServidor").serialize();

    $("#formModificarServidor").change(function () {
        var formModificado = $("#formModificarServidor").serialize();
        var disabled = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarServidor").prop("disabled", disabled);
    });

    $('#formModificarServidor').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarServidor.php",
            data: $("#formModificarServidor").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarServidor').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarServidor").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionResultado").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#seccionResultado").offset().top}, '1250');
            }
        });
    });

});