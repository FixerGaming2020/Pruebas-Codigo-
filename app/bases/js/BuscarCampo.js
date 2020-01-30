/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarCampo').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idColumna = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FModificarCampo.php",
            data: "idColumna=" + idColumna,
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
        $("#mdcBase").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdcTabla").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdcNombre").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdcNulos").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdcTipo").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdcMaximo").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdcDescripcion").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdcFechaProceso").val($(this).parents("tr").find('td:eq(7)').text());
        $("#ModalDatosColumna").modal({});
    });

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarCampo.php",
            data: $("#formBuscarCampo").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbCampos').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Columnas'
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
                $('html, body').animate({scrollTop: $("#seccionInferior").offset().top}, '1250');
            }
        });
    }

});

