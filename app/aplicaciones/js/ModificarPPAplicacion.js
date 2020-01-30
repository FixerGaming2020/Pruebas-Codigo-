/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarAplicacion").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarAplicacion").change(function () {
        var formModificado = $("#formModificarAplicacion").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarAplicacion").prop("disabled", habilitar);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarAplicacion').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarPPAplicacion.php",
            data: $("#formModificarAplicacion").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarAplicacion').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarAplicacion").prop("disabled", true);
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

    $('select#proveedor').select2({
        placeholder: 'Escriba nombre de proveedor',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../proveedores/vistas/PSeleccionarProveedor.php",
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

    $('select#herramienta').select2({
        placeholder: 'Escriba nombre de herramienta',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../herramientas/vistas/PSeleccionarHerramienta.php",
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

    $('select#lenguaje').select2({
        placeholder: 'Escriba nombre del lenguaje',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../lenguajes/vistas/PSeleccionarLenguaje.php",
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

    $('select#base').select2({
        placeholder: 'Escriba nombre de la base',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../bases/vistas/PSeleccionarBase.php",
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

    $('select#plataforma').select2({
        placeholder: 'Escriba nombre de la base',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../plataformas/vistas/PSeleccionarPlataformaSO.php",
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

    $('select#modo').select2({
        placeholder: 'Escriba modo de procesamiento',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../procesamientos/vistas/PSeleccionarModoProcesamiento.php",
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

    $('select#lugar').select2({
        placeholder: 'Escriba lugar de procesamiento',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../procesamientos/vistas/PSeleccionarLugarProcesamiento.php",
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

    $('select#sdesarrollo').select2({
        placeholder: 'Escriba nombre del servidor',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../servidores/vistas/PSeleccionarServidor.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, ambiente: 'Desarrollo', tipo: 'Aplicaciones'};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#delegado').select2({
        placeholder: 'Escriba nombre del delegado',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "../../gerencias/vistas/PSeleccionarEmpleado.php",
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
