
$(document).ready(function () {

    /* EJECUTA LA FUNCION QUE REALIZA LA BUSQUEDA */

    realizarBusqueda();

    /* ENVIA EL FORMULARIO DE BUSQUEDA INDICANDO QUE SE PETICIONO POR EL USUARIO */

    $('#formBuscarServidor').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.editar', function () {
        var idServidor = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarServidor.php",
            data: "idServidor=" + idServidor,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<strong>No se procesó la petición (Informe al administrador)</strong>';
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
        $("#mcesTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL SERVIDOR");
        $("#mcesAccion").val("BAJA");
        $("#mcesIdServidor").val($(this).attr("name"));
        $("#mcesNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoServidor").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mcesTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DE LA SERVIDOR");
        $("#mcesAccion").val("ALTA");
        $("#mcesIdServidor").val($(this).attr("name"));
        $("#mcesNombre").val($(this).parents("tr").find("td").eq(0).html());
        $("#ModalCambioEstadoServidor").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL CON LOS DATOS BASICOS CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdsIP").val($(this).parents("tr").find("td").eq(0).html());
        $("#mdsNombre").val($(this).parents("tr").find("td").eq(1).html());
        $("#mdsAmbiente").val($(this).parents("tr").find("td").eq(2).html());
        $("#mdsTipo").val($(this).parents("tr").find("td").eq(3).html());
        $("#mdsDescripcion").val($(this).parents("tr").find("td").eq(4).html());
        $("#ModalDatosServidor").modal({});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $("#btnCambiarEstadoServidor").click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoServidor.php",
            data: $("#formCambiarEstadoServidor").serialize(),
            success: function (data) {
                $('#mcesCuerpo').html(data);
                $('#btnCambiarEstadoServidor').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<strong>No se procesó la petición (Informe al administrador)</strong>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mcesCuerpo").html(div);
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
            url: "./PBuscarServidor.php",
            data: $("#formBuscarServidor").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbServidores').dataTable({
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