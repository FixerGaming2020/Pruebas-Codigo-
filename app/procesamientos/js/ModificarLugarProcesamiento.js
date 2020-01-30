/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarLugar").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarLugar").change(function () {
        var formModificado = $("#formModificarLugar").serialize();
        var disabled = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarLugar").prop("disabled", disabled);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarLugar').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarLugarProcesamiento.php",
            data: $("#formModificarLugar").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarLugar').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarLugar").prop("disabled", true);
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

