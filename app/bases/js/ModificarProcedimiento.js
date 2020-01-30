/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarProcedimiento").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarProcedimiento").change(function () {
        var formModificado = $("#formModificarProcedimiento").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarProcedimiento").prop("disabled", habilitar);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarProcedimiento').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarProcedimiento.php",
            data: $("#formModificarProcedimiento").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarProcedimiento').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarProcedimiento").prop("disabled", true);
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