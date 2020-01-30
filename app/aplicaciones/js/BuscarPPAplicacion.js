/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    /* EJECUTA LA FUNCION QUE REALIZA LA BUSQUEDA */

    realizarBusqueda();

    /* ENVIA EL FORMULARIO DE BUSQUEDA INDICANDO QUE SE PETICIONO POR EL USUARIO */

    $('#formBuscarAplicacion').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.editar', function () {
        var idAplicacion = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarPPAplicacion.php",
            data: "idAplicacion=" + idAplicacion,
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
        $("#mceaTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DE LA APLICACIÓN");
        $("#mceaAccion").val("BAJA");
        $("#mceaIdAplicacion").val($(this).attr("name"));
        $("#mceaNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoAplicacion").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mceaTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DE LA APLICACIÓN");
        $("#mceaAccion").val("ALTA");
        $("#mceaIdAplicacion").val($(this).attr("name"));
        $("#mceaNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoAplicacion").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL CON LOS DATOS BASICOS CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdaSigla").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdaNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdaTipo").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdaSeguridad").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdaTecnologia").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdaProveedor").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdaNombreHerramienta").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdaVersionHerramienta").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdaNombreLenguaje").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdaVersionLenguaje").val($(this).parents("tr").find('td:eq(9)').text());
        $("#mdaBaseDatos").val($(this).parents("tr").find('td:eq(10)').text());
        $("#mdaModo").val($(this).parents("tr").find('td:eq(11)').text());
        $("#mdaLugar").val($(this).parents("tr").find('td:eq(12)').text());
        $("#mdaGerencia").val($(this).parents("tr").find('td:eq(13)').text());
        $("#mdaDelegado").val($(this).parents("tr").find('td:eq(14)').text());
        $("#mdaServidorProduccion").val($(this).parents("tr").find('td:eq(15)').text());
        $("#mdaPuertoProduccion").val($(this).parents("tr").find('td:eq(16)').text());
        $("#mdaServidorTest").val($(this).parents("tr").find('td:eq(17)').text());
        $("#mdaPuertoTest").val($(this).parents("tr").find('td:eq(18)').text());
        $("#mdaServidorDesarrollo").val($(this).parents("tr").find('td:eq(19)').text());
        $("#mdaPuertoDesarrollo").val($(this).parents("tr").find('td:eq(20)').text());
        $("#mdaRTI").val($(this).parents("tr").find('td:eq(21)').text());
        $("#mdaDescripcion").val($(this).parents("tr").find('td:eq(22)').text());
        $("#ModalDatosAplicacion").modal({});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $("#btnCambiarEstadoAplicacion").click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoAplicacion.php",
            data: $("#formCambiarEstadoAplicacion").serialize(),
            success: function (data) {
                $('#mceaCuerpo').html(data);
                $('#btnCambiarEstadoAplicacion').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mceaCuerpo").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#seccionInferior").offset().top}, '1250');
            }
        });
    });

    /* ACTUALIZA LA PANTALLA LUEGO DE HACER EL ALTA O BAJA */

    $('#btnRefrescarPantalla').click(function () {
        location.reload();
    });

    /* ENVIA LA PETICION AJAX PARA CARGAR EL RESULTADO PREVIO DE UNA BUSQUEDA */

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarPPAplicacion.php",
            data: $("#formBuscarAplicacion").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbAplicaciones').dataTable({
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


