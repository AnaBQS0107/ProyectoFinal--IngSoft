<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize</title>
    <link rel="stylesheet" href="Estilos/header.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="../Vista/Inicio.php">
                <img src="../img/icono.png" alt="IconoPassWize" width="85" height="55">
            </a>
            <a class="navbar-title">Servicio de Peajes PassWize</a>
            
            <div class="hamburger-menu" onclick="toggleMenu()">
                &#9776;
            </div>
        </div>
        <div class="navbar-links" id="navbarLinks">
            <ul>
                <?php if ($user && isset($user['Nombre'], $user['Nombre_Rol'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">
                            <?php echo htmlspecialchars($user['Nombre']); ?> (<?php echo htmlspecialchars($user['Nombre_Rol']); ?>)
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../Controlador/Login.php?action=logout">Cerrar sesión</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="../Vista/Inicio.php">Página Principal</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAcciones" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Acciones
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownAcciones">
                    <a class="dropdown-item" href="../Vista/IngresarUsuario.php">Ingresar Usuario</a>
                        <a class="dropdown-item" href="../Vista/EditarCobro.php">Editar Cobro</a>
                        <a class="dropdown-item" href="../Vista/CobrosPeaje.php">Gestionar Cobros</a>
                        <a class="dropdown-item" href="../Vista/Liquidaciones.php">Calcular Liquidaciones</a>
                        <a class="dropdown-item" href="../Vista/HorasExtras.php">Calcular Extras</a>
                        <a class="dropdown-item" href="../Vista/ActualizarMonto.php">Actualizar Monto</a>
                        <a class="dropdown-item" href="../Vista/ActualizarEmpleado.php">Actualizar Empleado</a>
                        <a class="dropdown-item" href="../Vista/IngresarNuevoMonto.php">Nuevo Vehículo</a>
                        
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownConsultas" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search"></i> Consultas
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownConsultas">
                        <a class="dropdown-item" href="../Vista/ConsultaTipoyEstacion.php">Tipo y Estación</a>
                        <a class="dropdown-item" href="../Vista/ConsultaTrabajadoresporEstacion.php">Trabajadores por Estacion</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMantenimiento" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i> Mantenimiento
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMantenimiento">
                        <a class="dropdown-item" href="../Vista/ListaDeEmpleados.php">Tabla Empleados</a>
                        <a class="dropdown-item" href="../Vista/TablaCobros.php">Tabla Cobros de Peaje</a>
                        <a class="dropdown-item" href="../Vista/TablaRoles.php">Tabla Roles</a>
                        <a class="dropdown-item" href="../Vista/TablaMontoVehiculos.php">Tabla Montos</a>
                        <a class="dropdown-item" href="../Vista/TablaAguinaldos.php">Tabla Aguinaldos</a>
                        <a class="dropdown-item" href="../Vista/TablaReportes.php">Tabla Liquidaciones</a>
                        <a class="dropdown-item" href="../Vista/TablaVehiculos.php">Tabla Vehículos</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script>
    function toggleMenu() {
        var navbarLinks = document.getElementById("navbarLinks");
        navbarLinks.style.display = navbarLinks.style.display === "flex" ? "none" : "flex";
    }

    document.addEventListener("DOMContentLoaded", function() {
        var navbarLinks = document.getElementById("navbarLinks");
        var hamburgerMenu = document.querySelector(".hamburger-menu");

        hamburgerMenu.addEventListener("click", function() {
            if (navbarLinks.classList.contains("active")) {
                navbarLinks.classList.remove("active");
                document.body.style.overflow = "auto";
            } else {
                navbarLinks.classList.add("active");
                document.body.style.overflow = "hidden";
            }
        });

        var dropdownMenus = document.querySelectorAll(".nav-item.dropdown .dropdown-menu");

        dropdownMenus.forEach(function(dropdownMenu) {
            dropdownMenu.addEventListener("mouseenter", function() {
                navbarLinks.classList.add("expanded");
            });

            dropdownMenu.addEventListener("mouseleave", function() {
                setTimeout(function() {
                    navbarLinks.classList.remove("expanded");
                }, 200);
            });
        });
    });
</script>
</body>
</html>
