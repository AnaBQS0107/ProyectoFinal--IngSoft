<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Liquidaciones</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaCobros.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'header.php'?>
    <br><br><br><br>
    <center>
        <h1> Tabla Liquidaciones </h1>
    </center>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Primer Apellido</th>
                    <th scope="col">Segundo Apellido</th>
                    <th scope="col">Fecha de ingreso</th>
                    <th scope="col">Fecha de salida</th>
                    <th scope="col">Motivo de salida</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>

                    <td>Ana</td>
                    <td>Gamboa</td>
                    <td>Duarte</td>
                    <td>15/01/2020</td>
                    <td>30/02/2023</td>
                    <td>Despido</td>
                    <td>₡450,500</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>

                    <td>Octavio</td>
                    <td>Grillo</td>
                    <td>Rojas</td>
                    <td>30/03/2013</td>
                    <td>22/10/2023</td>
                    <td>Pensión</td>
                    <td>₡950,300</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>

                    <td>Elena</td>
                    <td>Zamora</td>
                    <td>Picado</td>
                    <td>20/05/2022</td>
                    <td>15/10/2023</td>
                    <td>Renuncia</td>
                    <td>₡310,000</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                </tr>
                <tr>

                    <td>Daniel</td>
                    <td>Alvarado</td>
                    <td>Campos</td>
                    <td>19/01/2022</td>
                    <td>05/07/2023</td>
                    <td>Despido</td>
                    <td>₡560,300</td>
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
        <center>    <button type="submit" class="btn_registrar">Exportar PDF</button></center>
    </div>
    <?php include 'Footer.php'; ?>
</body>

</html>