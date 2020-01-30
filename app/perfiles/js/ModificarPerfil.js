/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarPerfil").serialize();

    $("#formModificarPerfil").change(function () {
        var formModificado = $("#formModificarPerfil").serialize();
        var disabled = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarPerfil").prop("disabled", disabled);
    });

    $('#formModificarPerfil').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarPerfil.php",
            data: $("#formModificarPerfil").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarPerfil').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarPerfil").prop("disabled", true);
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

