/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("select#nivel").change(function () {
        var nivel = $(this).val();
        var activar = (nivel === '1') ? true : false;
        $("#padre").prop("disabled", activar);
        $("#link").prop("disabled", activar);
        $("#padre").prop("required", !activar);
        $("#link").prop("required", !activar);
    });

    $('#formCrearPermiso').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCrearPermiso.php",
            data: $("#formCrearPermiso").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearPermiso")[0].reset();
                    $("select#padre").val('').trigger('change');
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

    $('select#padre').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../vistas/PSeleccionarPermiso.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, nivel: 'Menu'};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

});