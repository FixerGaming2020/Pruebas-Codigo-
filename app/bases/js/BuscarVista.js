/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarVista').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.datos', function () {
        $("#mdvBase").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdvNombre").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdvConsulta").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdvFecha").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdvDescripcion").val($(this).parents("tr").find('td:eq(4)').text());
        $("#ModalDatosVista").modal({});
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idVista = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FModificarVista.php",
            data: "idVista=" + idVista,
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

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarVista.php",
            data: $("#formBuscarVista").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbVistas').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Vistas'
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
