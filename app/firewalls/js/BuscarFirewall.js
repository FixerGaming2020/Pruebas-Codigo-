/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarFirewall').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idFirewall = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarFirewall.php",
            data: "idFirewall=" + idFirewall,
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
        $("#mdfNombre").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdfMarca").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdfModelo").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdfNroSerie").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdfVersion").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdfIp").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdfSucursal").val($(this).parents("tr").find('td:eq(6)').text());
        $("#ModalDatosFirewall").modal();
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mcefTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL FIREWALL");
        $("#mcefAccion").val("BAJA");
        $("#mcefIdFirewall").val($(this).attr("name"));
        $("#mcefNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoFirewall").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mcefTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DEL FIREWALL");
        $("#mcefAccion").val("ALTA");
        $("#mcefIdFirewall").val($(this).attr("name"));
        $("#mcefNombre").val($(this).parents("tr").find("td").eq(0).html());
        $("#ModalCambioEstadoFirewall").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoFirewall').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoFirewall.php",
            data: $("#formCambiarEstadoFirewall").serialize(),
            success: function (data) {
                $('#mcefCuerpo').html(data);
                $('#btnCambiarEstadoFirewall').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mcefCuerpo").html(div);
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
            url: "./PBuscarFirewall.php",
            data: $("#formBuscarFirewall").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbFirewalls').dataTable({
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


