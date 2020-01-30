$(document).ready(function () {

    $('#formCrearProveedor').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCrearProveedor.php",
            data: $("#formCrearProveedor").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearProveedor")[0].reset();
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

    $('#cbTodosServicios').change(function () {
        var habilitar = ($(this).is(':checked')) ? true : false;
        $("input[name='servicios[]']").each(function () {
            $(this).prop('checked', habilitar);
        });
    });

});
