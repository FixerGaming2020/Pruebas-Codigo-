/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    var formOriginal = $("#formModificarComunicacion").serialize();

    $("#formModificarComunicacion").change(function () {
        var formModificado = $("#formModificarComunicacion").serialize();
        var disabled = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarComunicacion").prop("disabled", disabled);
    });

    $('#formModificarComunicacion').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarComunicacion.php",
            data: $("#formModificarComunicacion").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarComunicacion').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarComunicacion").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionResultado").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#seccionResultado").offset().top}, '1250');
            }
        });
    });


    $('select#ubicacion').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../../sitios/vistas/PSeleccionarSitio.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, tipo: 'TODOS'};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#gerencia').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../../gerencias/vistas/PSeleccionarGerencia.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, estado: "Activa"};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#delegado').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../../gerencias/vistas/PSeleccionarEmpleado.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, estado: "Activa"};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#proveedor').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../../proveedores/vistas/PSeleccionarProveedor.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, estado: "Activo"};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });


});

