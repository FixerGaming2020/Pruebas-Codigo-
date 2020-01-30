/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    /* EJECUTA LA FUNCION QUE REALIZA LA BUSQUEDA */

    realizarBusqueda();

    /* ENVIA EL FORMULARIO DE BUSQUEDA INDICANDO QUE SE PETICIONO POR EL USUARIO */

    $('#formBuscarLenguaje').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    /* ENVIA LA PETICION AJAX PARA CARGAR EL RESULTADO PREVIO DE UNA BUSQUEDA */

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PConsultarLenguaje.php",
            data: $("#formBuscarLenguaje").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbLenguajes').dataTable({
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



