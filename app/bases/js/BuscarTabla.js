/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarTabla').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdtBase").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdtNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdtCreacion").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdtEdicion").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdtProceso").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdtDescripcion").val($(this).parents("tr").find('td:eq(5)').text());
        $("#ModalDatosTabla").modal({});
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idTabla = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FModificarTabla.php",
            data: "idTabla=" + idTabla,
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

    $('#seccionInferior').on('click', '.detalle', function () {
        var idTabla = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FDetalleTabla.php",
            data: "idTabla=" + idTabla,
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
            url: "./PBuscarTabla.php",
            data: $("#formBuscarTabla").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbTablas').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Tablas'
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