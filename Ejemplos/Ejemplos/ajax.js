/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formulario').submit(function (event) {
        event.preventDefault();
        if ($('input#archivo').val() !== "") {

            var formData = new FormData(document.getElementById("formulario"));
            formData.append("dato", "valor");

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./recibeArchivo.php",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function (data) {
                    $('#resultado').html(data[0]['resultado']);
                },
                error: function (data) {
                    console.log(data);
                    var div = '<div class="alert alert-danger text-center" role="alert">No se procesó la petición por un error interno</div>';
                    $("#resultado").html(div);
                }
            });
            return false;
        } else {
            var div = 'Seleccione un archivo para importar';
            $("#resultado").html(div);
        }


    });



});
