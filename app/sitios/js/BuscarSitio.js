/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    /* EJECUTA LA FUNCION QUE REALIZA LA BUSQUEDA */

    realizarBusqueda();

    /* ENVIA EL FORMULARIO DE BUSQUEDA INDICANDO QUE SE PETICIONO POR EL USUARIO */

    $('#formBuscarSitio').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdsCodigo").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdsTipo").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdsNombre").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdsProvincia").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdsCiudad").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdsCodigoPostal").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdsDireccion").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdsOrigen").val($(this).parents("tr").find('td:eq(7)').text());
        $("#ModalDatosSitio").modal();
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.editar', function () {
        var idSitio = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FModificarSitio.php",
            data: "idSitio=" + idSitio,
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
        $("#mcesTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL SITIO");
        $("#mcesAccion").val("BAJA");
        $("#mcesIdSitio").val($(this).parents("tr").find("td").eq(0).html());
        $("#mcesNombre").val($(this).parents("tr").find('td:eq(2)').text());
        $("#ModalCambioEstadoSitio").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mcesTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DEL SITIO");
        $("#mcesAccion").val("ALTA");
        $("#mcesIdSitio").val($(this).parents("tr").find("td").eq(0).html());
        $("#mcesNombre").val($(this).parents("tr").find('td:eq(2)').text());
        $("#ModalCambioEstadoSitio").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION DE ALTA O BAJA Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoSitio').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoSitio.php",
            data: $("#formCambioEstadoSitio").serialize(),
            success: function (data) {
                $('#mcesCuerpo').html(data);
                $('#btnCambiarEstadoSitio').hide();
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
            url: "./PBuscarSitio.php",
            data: $("#formBuscarSitio").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbSitios').dataTable({
                    lengthChange: false,
                    language: {url: "../../../lib/JQuery/Spanish.json"}
                });
            },
            error: function (data) {
                console.log(data);
                var men = '<strong>No se procesó la petición (Informe al administrador)</strong>';
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

