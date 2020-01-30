$(document).ready(function () {

    $('#formCrearEmpleado').submit(function (event) {
        if ($("#departamento").val() === null) {
            $("#departamento").append($('<option>', {value: 'NO', text: ''}));
        }
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCrearEmpleado.php",
            data: $("#formCrearEmpleado").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearEmpleado")[0].reset();
                    $("select#departamento").val('').trigger('change');
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

    $('select#departamento').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./PSeleccionarDepartamento.php",
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