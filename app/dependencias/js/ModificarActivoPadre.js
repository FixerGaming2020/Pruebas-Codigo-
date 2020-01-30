/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarActivoPadre").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarActivoPadre").change(function () {
        var formModificado = $("#formModificarActivoPadre").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarActivoPadre").prop("disabled", habilitar);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarActivoPadre').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarActivoPadre.php",
            data: $("#formModificarActivoPadre").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarActivoPadre').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarActivoPadre").prop("disabled", true);
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

    $('#cbTodosHijos').change(function () {
        var habilitar = ($(this).is(':checked')) ? true : false;
        $("input[name='hijos[]']").each(function () {
            $(this).prop('checked', habilitar);
        });
    });

});

