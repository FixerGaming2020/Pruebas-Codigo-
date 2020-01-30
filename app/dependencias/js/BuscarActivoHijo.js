/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarActivoHijo').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idActivoHijo = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarActivoHijo.php",
            data: "idActivoHijo=" + idActivoHijo,
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
        $("#mceaTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL ACTIVO HIJO");
        $("#mceaAccion").val("BAJA");
        $("#mceaIdActivoHijo").val($(this).attr("name"));
        $("#mceaNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoActivoHijo").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mceaTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DEL ACTIVO HIJO");
        $("#mceaAccion").val("ALTA");
        $("#mceaIdActivoHijo").val($(this).attr("name"));
        $("#mceaNombre").val($(this).parents("tr").find("td").eq(0).html());
        $("#ModalCambioEstadoActivoHijo").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoActivoHijo').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoActivoHijo.php",
            data: $("#formCambiarEstadoActivoHijo").serialize(),
            success: function (data) {
                $('#mceaCuerpo').html(data);
                $('#btnCambiarEstadoActivoHijo').hide();
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
            url: "./PBuscarActivoHijo.php",
            data: $("#formBuscarActivoHijo").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbActivosHijos').dataTable({
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

