<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Aguinaldos</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaCobros.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'header.php'?>
    <br><br><br><br>
    <center>
        <h1> Tabla Vehiculos </h1>
    </center>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tipo de vehiculo</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>

                    <td>Vehiculo Liviano</td>
                    <td>18/06/2024</td>
                    <td>502</td>
                    <td class="actions">
                            <button class="btn-edit">Editar</button>
                            <button class="btn-delete" onclick="confirmarEliminar(<?php echo $cobro['idCobrosPeaje']; ?>)">Eliminar</button>
                        </td>
                </tr>
                <tr>
                    <td>Autobuses</td>
                    <td>23/02/2024</td>
                    <td>1234</td>
                    <td class="actions">
                            <button class="btn-edit">Editar</button>
                            <button class="btn-delete" onclick="confirmarEliminar(<?php echo $cobro['idCobrosPeaje']; ?>)">Eliminar</button>
                        </td>
                </tr>
                <tr>
                    <td>Otros</td>
                    <td>02/01/2024</td>
                    <td>125</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Vehiculos liviano</td>
                    <td>04/11/2023</td>
                    <td>2056</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Autobuses</td>
                    <td>23/12/2023</td>
                    <td>856</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Otros</td>
                    <td>15/01/2024</td>
                    <td>569</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Vehículo Liviano</td>
                    <td>14/02/2024</td>
                    <td>7415</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Autobuses</td>
                    <td>30/05/2024</td>
                    <td>125</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Otros</td>
                    <td>19/04/2024</td>
                    <td>657</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Vehiculo Liviano</td>
                    <td>30/04/2024</td>
                    <td>9876</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Autobuses</td>
                    <td>27/01/2024</td>
                    <td>345</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Otros</td>
                    <td>12/01/2024</td>
                    <td>890</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                

            </tbody>
        </table>
    </div>
    <br>
    <div class="div_btn">
        <center> <button type="submit" class="btn_registrar">Exportar PDF</button></center>
    </div>
</body>

</html>