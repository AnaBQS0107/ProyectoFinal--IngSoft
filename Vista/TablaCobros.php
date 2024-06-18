<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Aguinaldos</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Filtros.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'header.php'?>
    <br><br><br><br>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tipo de vehiculo</th>
                    <th scope="col">Código</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Persona que tramita</th>
                    <th scope="col">Estación</th>
                    <th scope="col">Acciones</th>
                    



                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>
                    <td>Vehiculo Liviano</td>
                    <td>L</td>
                    <td>340</td>
                    <td>Juan Pérez Gómez</td>
                    <td>Alajuela</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Autobuses</td>
                    <td>A</td>
                    <td>680</td>
                    <td>Carla Quesada Barrantes</td>
                    <td>Cartago</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Otros</td>
                    <td>O</td>
                    <td>850</td>
                    <td>Melissa Ledezma Segura</td>
                    <td>Heredia</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Vehiculo Liviano</td>
                    <td>L</td>
                    <td>340</td>
                    <td>Damaris Orozco Pérez</td>
                    <td>Puntarenas</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Vehiculo Liviano</td>
                    <td>L</td>
                    <td>340</td>
                    <td>Jairo Brenes Hidalgo</td>
                    <td>Cartago</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Autobuses</td>
                    <td>A</td>
                    <td>680</td>
                    <td>Jeison Jiménez Carranza</td>
                    <td>Guanacaste</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>Vehiculo Liviano</td>
                    <td>L</td>
                    <td>340</td>
                    <td>Elena Castillo Calvo</td>
                    <td>Alajuela</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                <td>Otros</td>
                    <td>O</td>
                    <td>850</td>
                    <td>Dario Vásquez Rojas</td>
                    <td>Alajuela</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                <td>Vehiculo Liviano</td>
                    <td>L</td>
                    <td>340</td>
                    <td>Isis Mena Rojas</td>
                    <td>Guanacaste</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                <td>Vehiculo Liviano</td>
                    <td>L</td>
                    <td>340</td>
                    <td>Sebastián Blanco Blanco</td>
                    <td>Puntarenas</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                <td>Otros</td>
                    <td>O</td>
                    <td>850</td>
                    <td>Melissa Ledezma Segura</td>
                    <td>Heredia</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>
                <td>Autobuses</td>
                    <td>A</td>
                    <td>680</td>
                    <td>Francisco Bastos Campos</td>
                    <td>Alajuela</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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
    <div class="div_btn">
        <center> <button type="submit" class="btn_asignar">Asignar un nuevo aguinaldo</button></center>
    </div>
    <br>
    <div class="div_btn">
        <center> <button type="submit" class="btn_registrar">Exportar PDF</button></center>
    </div>
</body>

</html>