/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarDepartamento").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarDepartamento").change(function () {
        var formModificado = $("#formModificarDepartamento").serialize();
        var valor = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarDepartamento").prop("disabled", valor);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarDepartamento').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarDepartamento.php",
            data: $("#formModificarDepartamento").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#btnModificarDepartamento").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                var men = '<strong>No se procesó la petición (Informe al administrador)</strong>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionResultado").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#seccionResultado").offset().top}, '1250');
            }
        });
    });

    $('select#gerencia').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "./PSeleccionarGerencia.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, estado: "Activa"};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

});
