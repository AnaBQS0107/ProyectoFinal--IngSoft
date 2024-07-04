<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="Estilos/header2.css">
    <title>Dropdown Menu</title>
</head>

<body>

    <div class="menu-bar">
        <a class="navbar-brand" href="../Vista/Inicio.php">
            <img src="../img/icono.png" alt="Icono PassWize" width="85" height="55">
        </a>
        <h1 class="logo">Pass<span>Wize.</span></h1>
        <ul>
            
            <li><a href="#">Acciones<i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <li>    <a class="nav-link" href="#" role="button">
                        <?php echo htmlspecialchars($user['Nombre']); ?> (<?php echo htmlspecialchars($user['Nombre_Rol']); ?>)
                    </a></li>
                    <li><a href="../Vista/IngresarUsuario.php">Ingresar Usuario</a></li>
                    <li><a href="../Vista/CobrosPeaje.php">Gestionar Cobros</a></li>
                        <li><a href="../Vista/Liquidaciones.php">Calcular Liquidaciones</a></li>
                        <li><a href="../Vista/HorasExtras.php">Calcular Extras</a></li>
                        <li><a href="#">Calcular Aquinaldos</a></li>
                        <li><a href="#">Calcular Incapacidades</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#">Reportes<i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <li><a href="../Vista/ReporteCobroMes.php">Cobro Tipo de Vehículo</a></li>
                        <li><a href="../Vista/ReporteCobroporEstacion.php">Cobro por estación</a></li>
                        <li><a href="../Vista/ReporteCobradoGeneral.php">Monto total recaudado</a></li>
                        <li><a href="../Vista/ReporteTotalporMes.php">Monto total por mes</a></li>
                        <li><a href="#">Tipo de vehiculo por estación</a></li>
                        <li><a href="#">Control de pago a trabajadores</a></li>
                        <li><a href="#">Cantidad de vehiculo por tipo y estación</a></li>
                        <li><a href="#">Historial cobros diarios</a></li>
                        <li><a href="#">Promedio diario de vehiculos por estación</a></li>
                        <li><a href="#">Cantidad de vehiculos por hora</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#">Consultas<i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <li><a href="../Vista/ConsultaTipoyEstacion.php">Tipo y Estación</a></li>
                        <li><a href="../Vista/ConsultaTrabajadoresporEstacion.php">Trabajadores por Estacion</a></li>
                        <li><a href="../Vista/ConsultaCobrosporTrabajador.php">Cobros por trabajador</a></li>
                        <li><a href="../Vista/ConsultaMontoAlMes.php">Monto cobrado por mes</a></li>
                        <li><a href="#">Ingresos por periodo de tiempo</a></li>
                        <li><a href="#">Horarios de operacion por estación</a></li>
                        <li><a href="#">Tarifas de peaje vigentes</a></li>
                        <li><a href="#">Histórico de cobros por estación de peaje</a></li>
                        <li><a href="#">Horarios de trabajo de los trabajadores del peaje</a></li>
                        <li><a href="#">Cobros por hora del dia</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#">Mantenimiento<i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <li><a href="../Vista/ListaDeEmpleados.php">Tabla Empleados</a></li>
                        <li><a href="../Vista/TablaCobros.php">Tabla Cobros de Peaje</a></li>
                        <li><a href="../Vista/TablaRoles.php">Tabla Roles</a></li>
                        <li><a href="../Vista/TablaMontoVehiculos.php">Tabla Montos</a></li>
                        <li><a href="#">Tabla de pagos por extra automaticos</a></li>
                        <li><a href="#">Tabla de aprobación de extras</a></li>
                        <li><a href="#">Tabla de pagos de incapacidades</a></li>
                        <li><a href="#">Tabla de pagos de aguinaldo autómatico</a></li>
                        <li><a href="#">Tabla de pago de salarios</a></li>
                        <li><a href="#">Tabla de pago de liquidaciones</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</body>

</html>
