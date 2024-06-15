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
</head>
<body>
<header>
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="../Vista/Inicio.php">
                <img src="../img/icono.png" alt="IconoPassWize" width="85" height="55">
            </a>
            <a class="navbar-title" href="#">Servicio de Peajes PassWize</a>
            <div class="hamburger-menu" onclick="toggleMenu()">
                &#9776;
            </div>
        </div>
            <div class="navbar-links" id="navbarLinks">
                <ul>
                    <?php if ($user) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" onmouseover="expandDropdownMenu()">
                            <?php echo htmlspecialchars($user['nombre']); ?> (<?php echo htmlspecialchars($user['nombre_rol']); ?>)
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="../Vista/Index.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="../Vista/Inicio.php">Página Principal</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Vista/IngresarUsuario.php">Ingresar usuario</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Vista/ListaDeEmpleados.php">Lista de Empleados</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Vista/CobrosPeaje.php">Cobrar Peajes</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Vista/Filtros.php">Conteo de Peajes</a></li>
                </ul>
            </div>
       
    </nav>
</header>

<script>
    function toggleMenu() {
    var navbarLinks = document.getElementById("navbarLinks");
    if (navbarLinks.style.display === "flex") {
        navbarLinks.style.display = "none";
    } else {
        navbarLinks.style.display = "flex";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var navbarLinks = document.getElementById("navbarLinks");
    var hamburgerMenu = document.querySelector(".hamburger-menu");

    hamburgerMenu.addEventListener("click", function() {
        if (navbarLinks.classList.contains("active")) {
            navbarLinks.classList.remove("active");
            document.body.style.overflow = "auto"; // Restaurar desplazamiento del cuerpo
        } else {
            navbarLinks.classList.add("active");
            document.body.style.overflow = "hidden"; // Ocultar desplazamiento del cuerpo
        }
    });

    var dropdownMenu = document.querySelector(".nav-item.dropdown .dropdown-menu");

    dropdownMenu.addEventListener("mouseenter", function() {
        navbarLinks.classList.add("expanded");
    });

    dropdownMenu.addEventListener("mouseleave", function() {
        setTimeout(function() {
            navbarLinks.classList.remove("expanded");
        }, 200);
    });
});
</script>

</body>