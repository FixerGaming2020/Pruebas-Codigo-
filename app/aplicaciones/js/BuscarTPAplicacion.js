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
            url: "./FModificarTPAplicacion.php",
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

    /* ABRE EL MODAL CON LOS DATOS BASICOS CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdaSigla").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdaNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdaTipo").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdaSeguridad").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdaTecnologia").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdaProveedor").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdaConfidencialidad").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdaIntegridad").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdaDisponibilidad").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdaCriticidad").val($(this).parents("tr").find('td:eq(9)').text());
        $("#mdaDescripcion").val($(this).parents("tr").find('td:eq(10)').text());
        $("#ModalDatosAplicacion").modal({});
    });

    /* ENVIA LA PETICION AJAX PARA CARGAR EL RESULTADO PREVIO DE UNA BUSQUEDA */

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarTPAplicacion.php",
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
