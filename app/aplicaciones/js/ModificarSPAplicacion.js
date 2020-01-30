/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarSPAplicacion").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarSPAplicacion").change(function () {
        var formModificado = $("#formModificarSPAplicacion").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarAplicacion").prop("disabled", habilitar);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarSPAplicacion').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarSPAplicacion.php",
            data: $("#formModificarSPAplicacion").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarSPAplicacion').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarAplicacion").prop("disabled", true);
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

    $('select#sproduccion').select2({
        placeholder: 'Escriba nombre del servidor',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../servidores/vistas/PSeleccionarServidor.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, ambiente: 'Produccion', tipo: 'Aplicaciones'};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#stest').select2({
        placeholder: 'Escriba nombre del servidor',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../servidores/vistas/PSeleccionarServidor.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, ambiente: 'Test', tipo: 'Aplicaciones'};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

});

