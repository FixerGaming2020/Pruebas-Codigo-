/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    /* EJECUTA LA FUNCION QUE REALIZA LA BUSQUEDA */

    realizarBusqueda();

    /* ENVIA EL FORMULARIO DE BUSQUEDA INDICANDO QUE SE PETICIONO POR EL USUARIO */

    $('#formBuscarProveedor').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.editar', function () {
        var idProveedor = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarProveedor.php",
            data: "idProveedor=" + idProveedor,
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
        $("#mdpNombre").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdpTipo").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdpTelefono").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdpCorreo").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdpProvincia").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdpLocalidad").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdpDireccion").val($(this).parents("tr").find('td:eq(6)').text());
        $("#ModalDatosProveedor").modal();
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mcepTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL PROVEEDOR");
        $("#mcepAccion").val("BAJA");
        $("#mcepIdProveedor").val($(this).attr("name"));
        $("#mcepNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoProveedor").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mcepTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DE LA PROVEEDOR");
        $("#mcepAccion").val("ALTA");
        $("#mcepIdProveedor").val($(this).attr("name"));
        $("#mcepNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoProveedor").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoProveedor').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoProveedor.php",
            data: $("#formCambiarEstadoProveedor").serialize(),
            success: function (data) {
                $('#mcepCuerpo').html(data);
                $('#btnCambiarEstadoProveedor').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mcepCuerpo").html(div);
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
            url: "./PBuscarProveedor.php",
            data: $("#formBuscarProveedor").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbProveedores').dataTable({
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
