/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formCrearPerfil').submit(function (evento) {
        evento.preventDefault();
        var cantidad = $('input[name="permisos[]"]:checked').length;
        if (cantidad > 0) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./PCrearPerfil.php",
                data: $("#formCrearPerfil").serialize(),
                success: function (data) {
                    $('#seccionResultado').html(data[0]['resultado']);
                    if (data[0]['exito'] === true) {
                        $("#formCrearPerfil")[0].reset();
                    }
                },
                error: function (data) {
                    console.log(data);
                    var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                    var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                    $('#seccionResultado').html(div);
                },
                complete: function () {
                    $('html,body').animate({scrollTop: $("#seccionResultado").offset().top}, '1250');
                }
            });
        } else {
            var men = '<b>No se procesó la petición (Informe al administrador)</b>';
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $('#seccionResultado').html(div);
            $('html,body').animate({scrollTop: $("#seccionResultado").offset().top}, '1250');
        }
    });

    $('#nombre').change(function () {
        var valor = ($(this).val().length < 3) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

    $('#cbTodosPermisos').change(function () {
        var habilitar = ($(this).is(':checked')) ? true : false;
        $("input[name='permisos[]']").each(function () {
            $(this).prop('checked', habilitar);
        });
    });

});
