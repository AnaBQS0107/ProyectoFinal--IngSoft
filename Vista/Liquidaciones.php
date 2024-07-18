<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de liquidaciones</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Liquidaciones.css">
</head>

<body>
<?php
        require_once '../Vista/header.php';
    ?>
<br><br><br><br>
    <center>
        <h1>Calcular liquidaciones</h1>
    </center>
    <div>
        <form  class="container">
            
            <div class="row">
                <div class="col-md-2 position-relative">
                    <label for="fechaEntrada" class="form-label">Fecha de entrada</label>
                    <input type="date" class="form-control" id="fechaEntrada" name="fechaEntrada" required>
                </div>

                <div class="col-md-2 position-relative">
                    <label for="fechaSalida" class="form-label">Fecha de salida</label>
                    <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>
                </div>

                <div class="col-md-2 position-relative">
                    <label for="preaviso" class="form-label">Preaviso ejercido</label>
                    <select class="select_registro" id="preaviso" name="preaviso" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option value="Renuncia">Preaviso trabajado total</option>
                    </select>
                </div>

                <div class="col-md-2 position-relative">
                    <label for="tipoPago" class="form-label">Motivo de salida</label>
                    <select class="select_registro" id="salida" name="salida" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option value="Renuncia">Renuncia</option>
                        <option value="con">Despido con responsabilidad patronal</option>
                        <option value="sin">Despido sin responsabilidad patronal</option>
                    </select>
                </div>

                <div class="col-md-2 position-relative">
                    <label for="tipoPago" class="form-label">Tipo de pago</label>
                    <select class="select_registro" id="tipoPago" name="tipoPago" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option value="quincenal">Pago quincenal</option>
                        <option value="mensual">Pago mensual</option>
                    </select>
                </div>

                <div class="col-md-2 position-relative">
                    <label for="saldoVacaciones" class="form-label">Saldo de vacaciones</label>
                    <input type="number" class="form-control" id="saldoVacaciones" name="saldoVacaciones" required>
                </div>
            </div>

          <div class="row mt-3">
                <div class="row mt-3">
                    <div class="col-auto">
                        <div class="div_btn">
                       <center><button type="submit" class="btn_calcular">Calcular</button>  </center> 
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleMenu() {
            var navbarLinks = document.getElementById("navbarLinks");
            if (navbarLinks.style.display === "flex") {
                navbarLinks.style.display = "none";
            } else {
                navbarLinks.style.display = "flex";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            var navbarLinks = document.getElementById("navbarLinks");
            var hamburgerMenu = document.querySelector(".hamburger-menu");

            hamburgerMenu.addEventListener("click", function () {
                if (navbarLinks.classList.contains("active")) {
                    navbarLinks.classList.remove("active");
                    document.body.style.overflow = "auto"; 
                } else {
                    navbarLinks.classList.add("active");
                    document.body.style.overflow = "hidden"; 
                }
            });

            var dropdownMenu = document.querySelector(".nav-item.dropdown .dropdown-menu");

            dropdownMenu.addEventListener("mouseenter", function () {
                navbarLinks.classList.add("expanded");
            });

            dropdownMenu.addEventListener("mouseleave", function () {
                setTimeout(function () {
                    navbarLinks.classList.remove("expanded");
                }, 200);
            });
        });
    </script>

    <footer>
    <?php include 'Footer.php'; ?>
    </footer>    

</body>

</html>
