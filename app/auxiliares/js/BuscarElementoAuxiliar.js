/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarAuxiliar').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idAuxiliar = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarElementoAuxiliar.php",
            data: "idAuxiliar=" + idAuxiliar,
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
        $("#mdaSigla").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdaNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdaGerencia").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdaLegajo").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdaDelegado").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdaSitio").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdaCantidad").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdaRTI").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdaDescripcion").val($(this).parents("tr").find('td:eq(7)').text());
        $("#ModalDatosAuxiliar").modal();
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mceaTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL ELEMENTO AUXILIAR");
        $("#mceaAccion").val("BAJA");
        $("#mceaIdAuxiliar").val($(this).attr("name"));
        $("#mceaNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoAuxiliar").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mceaTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DEL ELEMENTO AUXILIAR");
        $("#mceaAccion").val("ALTA");
        $("#mceaIdAuxiliar").val($(this).attr("name"));
        $("#mceaNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoAuxiliar").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoAuxiliar').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoElementoAuxiliar.php",
            data: $("#formCambiarEstadoAuxiliar").serialize(),
            success: function (data) {
                $('#mceaCuerpo').html(data);
                $('#btnCambiarEstadoAuxiliar').hide();
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
            url: "./PBuscarElementoAuxiliar.php",
            data: $("#formBuscarAuxiliar").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbAuxiliares').dataTable({
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

