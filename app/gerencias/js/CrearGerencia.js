
$(document).ready(function () {

    $('#formCrearGerencia').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCrearGerencia.php",
            data: $("#formCrearGerencia").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearGerencia")[0].reset();
                    $("select#jefe").val('').trigger('change');
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

    $('select#jefe').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./PSeleccionarEmpleadoJefe.php",
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
