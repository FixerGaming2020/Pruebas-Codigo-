/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {


    realizarBusqueda();

    $('#formBuscarHardware').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idHardware = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarHardware.php",
            data: "idHardware=" + idHardware,
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

    /* ABRE EL MODAL CON LOS DATOS BASICOS CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdhTipo").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdhSigla").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdhNombre").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdhDominio").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdhAmbiente").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdhSwBase").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdhUbicacion").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdhMarca").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdhModelo").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdhArquitectura").val($(this).parents("tr").find('td:eq(9)').text());
        $("#mdhCore").val($(this).parents("tr").find('td:eq(10)').text());
        $("#mdhProcesador").val($(this).parents("tr").find('td:eq(11)').text());
        $("#mdhMhz").val($(this).parents("tr").find('td:eq(12)').text());
        $("#mdhMemoria").val($(this).parents("tr").find('td:eq(13)').text());
        $("#mdhDisco").val($(this).parents("tr").find('td:eq(14)').text());
        $("#mdhRaid").val($(this).parents("tr").find('td:eq(15)').text());
        $("#mdhRed").val($(this).parents("tr").find('td:eq(16)').text());
        $("#mdhRTI").val($(this).parents("tr").find('td:eq(17)').text());
        $("#mdhFuncion").val($(this).parents("tr").find('td:eq(18)').text());
        $("#ModalDatosHardware").modal({});
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mcehTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL HARDWARE");
        $("#mcehAccion").val("BAJA");
        $("#mcehIdHardware").val($(this).attr("name"));
        $("#mcehNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoHardware").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mcehTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DEL HARDWARE");
        $("#mcehAccion").val("ALTA");
        $("#mcehIdHardware").val($(this).attr("name"));
        $("#mcehNombre").val($(this).parents("tr").find("td").eq(0).html());
        $("#ModalCambioEstadoHardware").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoHardware').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoHardware.php",
            data: $("#formCambiarEstadoHardware").serialize(),
            success: function (data) {
                $('#mcehCuerpo').html(data);
                $('#btnCambiarEstadoHardware').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mcehCuerpo").html(div);
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
            url: "./PBuscarHardware.php",
            data: $("#formBuscarHardware").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbHardwares').dataTable({
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

