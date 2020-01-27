<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="jquery.min.js"></script>
        <script src="ajax.js"></script>
    </head>
    <body>
        <div>
            <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                <input type="file" name="archivo" id="archivo">
                <input type="submit" value="Importar">
            </form>
        </div>
        <br>
        <div id="resultado"></div>
    </body>
</html>
