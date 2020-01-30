/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarActivoPadre').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idActivoPadre = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarActivoPadre.php",
            data: "idActivoPadre=" + idActivoPadre,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#contenido").offset().top}, '1250');
            }
        });
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mceaTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL ACTIVO PADRE");
        $("#mceaAccion").val("BAJA");
        $("#mceaIdActivoPadre").val($(this).attr("name"));
        $("#mceaNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoActivoPadre").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mceaTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DEL ACTIVO PADRE");
        $("#mceaAccion").val("ALTA");
        $("#mceaIdActivoPadre").val($(this).attr("name"));
        $("#mceaNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoActivoPadre").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoActivoPadre').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoActivoPadre.php",
            data: $("#formCambiarEstadoActivoPadre").serialize(),
            success: function (data) {
                $('#mceaCuerpo').html(data);
                $('#btnCambiarEstadoActivoPadre').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mceaCuerpo").html(div);
            }
        });
    });

    /* ACTUALIZA LA PANTALLA LUEGO DE HACER EL ALTA O BAJA */

    $('#btnRefrescarPantalla').click(function () {
        location.reload();
    });

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarActivoPadre.php",
            data: $("#formBuscarActivoPadre").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbActivosPadres').dataTable({
                    lengthChange: false,
                    language: {url: "../../../lib/JQuery/Spanish.json"}
                });
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            },
            complete: function () {
                setTimeout(function () {
                    $('#ModalCargando').modal('hide');
                }, 1000);
                $('html,body').animate({scrollTop: $("#seccionInferior").offset().top}, '1250');
            }
        });
    }

});

