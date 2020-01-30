/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $("#formConsultarHistorico").submit(function () {
        var historico = $("#elemento").val();
        var hoy = new Date();
        var fecha = hoy.getDate() + "" + (hoy.getMonth() + 1) + "" + hoy.getFullYear() + "" + hoy.getHours() + "" + hoy.getMinutes();
        var inventario = $("#inventario").val();
        var elemento = $("#elemento :selected").text();
        var titulo = "INV" + inventario + "_" + elemento + "_" + fecha;
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./" + historico + ".php",
            data: $("#formConsultarHistorico").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbHistoricos').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: titulo
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
    });

    $('select#inventario').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./PSeleccionarInventario.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

});
