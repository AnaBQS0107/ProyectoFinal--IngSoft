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
<<<<<<< HEAD
    <br>
=======
    <style>
    <style>body {
        font-family: Arial, sans-serif;
    }

    .table-container {
        max-width: 1000px;
        margin: 20px auto;
        padding: 0 15px;
    }

    .table {
        width: 100%;
        background-color: white;
        border-collapse: collapse;
    }

    .table thead th {
        background-color: #004d40;
        color: white;
        text-align: center;
        padding: 10px;
    }

    .table tbody tr {
        text-align: center;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .btn-edit {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        display: block;
        margin: 20px auto;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .table th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #004d40;
        color: white;
    }

    .table td {
        color: black;
    }

    .actions {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .btn_registrar {
        width: auto;
        padding: 10px;
        background-color: #9fc131;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn_registrar:hover {
        background-color: #bdf227;
    }

    .btn_asignar {
        background-color: #004d40;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: auto;
        padding: 10px;
    }
    </style>
>>>>>>> 2d5161e56d1feb2b7d2c797ab7ffa1c5416d2696
    <div class="div_btn">
        <center> <button type="submit" class="btn_registrar">Exportar PDF</button></center>
    </div>
</body>

</html>