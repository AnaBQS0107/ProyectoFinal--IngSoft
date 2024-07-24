<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cobros -- PassWize</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/CobrosPeaje.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="Estilos/Footer2.css">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br>
    <center>
        <h2>¿Cuál tipo de vehiculo pasará por la estación?</h2>
    </center>
    <br>
    <div class="row justify-content-center gap-3" id="cards-container">
        <!-- Las cards se cargarán aquí -->
    </div>

    <form id="pagoForm" class="pagoForm">
        <input type="hidden" name="codigo" id="codigo">
        <table id="tabla" class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tipo de Vehiculo</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Código</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Persona que lo tramita</th>
                    <th scope="col">Estación</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
            </tbody>
        </table>
        <br>
        <center><button type="button" class="btn btn-success" onclick="confirmarPago()">Aceptar pago</button></center>
        <br><br>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            cargarTiposVehiculos();
        });

        function cargarTiposVehiculos() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../Modelo/ObtenerTiposVehiculos.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var tiposVehiculos = JSON.parse(xhr.responseText);
                    var container = document.getElementById("cards-container");
                    container.innerHTML = ""; // Asegúrate de limpiar el contenedor antes de agregar nuevos elementos
                    tiposVehiculos.forEach(function(tipo) {
                        var card = document.createElement("div");
                        card.className = "card border-success mb-3";
                        card.style.maxWidth = "18rem";

                        card.innerHTML = `
                            <div class="card-header">Código: ${tipo.Codigo}</div>
                            <div class="card-body text-success">
                                <h5 class="card-title">${tipo.Tipo}</h5>
                                <p class="card-text">Monto: ${tipo.Tarifa}</p>
                                <center><button type="button" class="btn btn-success" onclick="seleccionar('${tipo.Codigo}')">Seleccionar</button></center>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                }
            };
            xhr.send();
        }

        function seleccionar(codigo) {
            document.getElementById('codigo').value = codigo;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../Controlador/ObtenerDatosPeajes.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.querySelector("#tabla tbody").innerHTML = xhr.responseText;
                }
            };
            xhr.send("codigo=" + codigo);
        }

        function confirmarPago() {
            var filas = document.querySelectorAll("#tabla tbody tr").length;
            if (filas === 0) {
                Swal.fire({
                    title: 'No hay datos',
                    text: "No hay datos en la tabla para procesar el pago.",
                    icon: 'error'
                });
                return;
            }

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas proceder con el pago?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, pagar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var codigo = document.getElementById('codigo').value;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../Controlador/ObtenerDatosPeajes.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.querySelector("#tabla tbody").innerHTML = xhr.responseText;
                        }
                    };
                    xhr.send("codigo=" + codigo + "&insert=true");
                    Swal.fire(
                        'Pagado!',
                        'El pago ha sido procesado.',
                        'success'
                    );
                } else {
                    document.querySelector("#tabla tbody").innerHTML = '';
                }
            });
        }
    </script>

<footer id="footer"></footer>
<script src="../JS/footer.js"></script>
</body>

</html>
