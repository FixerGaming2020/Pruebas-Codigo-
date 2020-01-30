/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarInstalacion').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idInstalacion = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarInstalacion.php",
            data: "idInstalacion=" + idInstalacion,
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
        $("#mdiSigla").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdiNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdiGerencia").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdiLegajo").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdiResponsable").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdiSitio").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdiPlataforma").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdiRTI").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdiDescripcion").val($(this).parents("tr").find('td:eq(9)').text());
        $("#ModalDatosInstalacion").modal({});
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mceiTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DE LA INSTALACIÓN");
        $("#mceiAccion").val("BAJA");
        $("#mceiIdInstalacion").val($(this).attr("name"));
        $("#mceiNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoInstalacion").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mceiTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DE LA INSTALACIÓN");
        $("#mceiAccion").val("ALTA");
        $("#mceiIdInstalacion").val($(this).attr("name"));
        $("#mceiNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoInstalacion").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoInstalacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoInstalacion.php",
            data: $("#formCambiarEstadoInstalacion").serialize(),
            success: function (data) {
                $('#mceiCuerpo').html(data);
                $('#btnCambiarEstadoInstalacion').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mceiCuerpo").html(div);
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
            url: "./PBuscarInstalacion.php",
            data: $("#formBuscarInstalacion").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbInstalaciones').dataTable({
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
