/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formCrearSwitch').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCrearSwitch.php",
            data: $("#formCrearSwitch").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearSwitch")[0].reset();
                    $("#sitio").val('').trigger('change');
                    $("#instalacion").val('').trigger('change');
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

    $('select#sitio').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../../sitios/vistas/PSeleccionarSitio.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, tipo: 'TODOS'};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#instalacion').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../../instalaciones/vistas/PSeleccionarInstalacion.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

});
