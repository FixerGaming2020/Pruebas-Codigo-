

<script src="../../../lib/JQuery/jquery.min.js"></script>
<script src="../../../lib/dataTables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        alert("anda");

        $("#tabla").dataTable({
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            select: {
                style: 'multi'
            },
            order: [[1, 'asc']]
        });
    });
</script>

<?php

$filas = "";
for ($index = 0; $index < 100; $index++) {
    $filas .= '
        <tr>
            <td><input type="checkbox" name="check[]" value="' . $index . '"></td>
            <td> FILA NUMERO ' . $index . '</td>
        </tr>';
}

$tabla = "<table id='tabla' border='1'>
    <thead>
        <tr>
            <th><input type='checkbox' id='todos' name='todos'></th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        '.$filas.'
    </tbody>
</table>";

ECHO $tabla;
