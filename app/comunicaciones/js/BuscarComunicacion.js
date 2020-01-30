/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarComunicacion').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idComunicacion = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarComunicacion.php",
            data: "idComunicacion=" + idComunicacion,
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

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdcSigla").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdcNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdcGerencia").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdcLegajo").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdcDelegado").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdcSitio").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdcProveedor").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdcCantidad").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdcRTI").val($(this).parents("tr").find('td:eq(9)').text());
        $("#mdcDescripcion").val($(this).parents("tr").find('td:eq(8)').text());
        $("#ModalDatosComunicacion").modal();
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mcecTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DE LA COMUNICACIÓN");
        $("#mcecAccion").val("BAJA");
        $("#mcecIdComunicacion").val($(this).attr("name"));
        $("#mcecNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoComunicacion").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mcecTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DE LA COMUNICACIÓN");
        $("#mcecAccion").val("ALTA");
        $("#mcecIdComunicacion").val($(this).attr("name"));
        $("#mcecNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoComunicacion").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoComunicacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoComunicacion.php",
            data: $("#formCambiarEstadoComunicacion").serialize(),
            success: function (data) {
                $('#mcecCuerpo').html(data);
                $('#btnCambiarEstadoComunicacion').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mcecCuerpo").html(div);
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
            url: "./PBuscarComunicacion.php",
            data: $("#formBuscarComunicacion").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbComunicaciones').dataTable({
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


