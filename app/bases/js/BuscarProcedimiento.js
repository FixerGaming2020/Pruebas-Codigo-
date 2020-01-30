/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarProcedimiento').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();

    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idProcedimiento = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FModificarProcedimiento.php",
            data: "idProcedimiento=" + idProcedimiento,
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
        $("#mdpBase").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdpNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdpCreacion").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdpEdicion").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdpDescripcion").val($(this).parents("tr").find('td:eq(4)').text());
        $("#ModalDatosProcedimiento").modal({});
    });

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarProcedimiento.php",
            data: $("#formBuscarProcedimiento").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbProcedimientos').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Procedimientos almacenados'
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
