/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarBase').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idBase = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FModificarBase.php",
            data: "idBase=" + idBase,
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
        $("#mdbNombre").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdbCreacion").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdbMotor").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdbCollation").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdbIPProduccion").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdbNombreProduccion").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdbIPTest").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdbNombreTest").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdbIPDesarrollo").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdbNombreDesarrollo").val($(this).parents("tr").find('td:eq(9)').text());
        $("#mdbEstado").val($(this).parents("tr").find('td:eq(10)').text());
        $("#mdbRTI").val($(this).parents("tr").find('td:eq(11)').text());
        $("#mdbFechaProceso").val($(this).parents("tr").find('td:eq(12)').text());
        $("#mdbTablas").val($(this).parents("tr").find('td:eq(13)').text());
        $("#mdbVistas").val($(this).parents("tr").find('td:eq(14)').text());
        $("#mdbSPS").val($(this).parents("tr").find('td:eq(15)').text());
        $("#ModalDatosBase").modal({});
    });

    $('#seccionInferior').on('click', '.detalle', function () {
        var idBase = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FDetalleBase.php",
            data: "idBase=" + idBase,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
    });

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarBase.php",
            data: $("#formBuscarBase").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbBases').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Bases de datos'
                        }
                    ],
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