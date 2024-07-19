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
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>

<body>

    <div class="menu-bar">
        <a class="navbar-brand" href="../Vista/Inicio.php">
            <img src="../img/icono.png" alt="Icono PassWize" width="85" height="55">
        </a>
        <h1 class="logo">Pass<span>Wize.</span></h1>
        <ul>
            <li><a href="../Vista/Inicio.php">Inicio</a>
            <li><a href="#">Acciones<i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <li><a href="../Vista/IngresarUsuario.php">Ingresar Empleado</a></li>
                        <li><a href="../Vista/CobrosPeaje.php">Gestionar Cobros</a></li>
                        <li><a href="../Vista/CalcularVacaciones.php">Calcular Vacaciones</a></li>
                        <li><a href="../Vista/HorasExtras.php">Calcular Extras</a></li>
                        <li><a href="../Vista/CalculadoraAguinaldo.php">Calcular Aguinaldos</a></li>
                        <li><a href="#">Calcular Incapacidades</a></li>
                        <li><a href="../Vista/Liquidaciones.php">Calcular Liquidaciones</a></li>
                        <li><a href="#">Calcular Salario</a></li>
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
                        <li><a href="../Vista/ReportePromedioDiario.php">Promedio diario de vehiculos por estación</a></li>
                        <li><a href="../Vista/ReporteporHora.php">Cantidad de vehiculos por hora</a></li>
                        <li><a href="../Vista/ReporteCobrosDiarios.php">Historial cobros diarios</a></li>
                        <li><a href="../Vista/ReporteTipoVehiculoEstacion.php">Tipo de vehiculo por estación</a></li>
                        <li><a href="#">Control de pago a trabajadores</a></li>
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
                        <li><a href="../Vista/ConsultaHorariosporEstacion.php">Horarios de operacion por estación</a></li>
                        <li><a href="../Vista/ConsultaTarifasVigentes.php">Tarifas de peaje vigentes</a></li>
                        <li><a href="../Vista/ConsultaHistoricoCobros.php">Histórico de cobros por estación de peaje</a></li>
                        <li><a href="../Vista/ConsultaHorarioTrabajador.php">Horarios de trabajo de los trabajadores del peaje</a></li>
                        <li><a href="../Vista/ConsultaCobroporHora.php">Cobros por hora del dia</a></li>
                        <li><a href="../Vista/ConsultaVehiculosLivianos.php">Vehiculos Livianos que utilizaron el peaje</a></li>
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
                        <li><a href="../Vista/AprobacionHorasExtras.php">Tabla de aprobación de extras</a></li>
                        <li><a href="#">Tabla de pagos por extra</a></li>
                        <li><a href="#">Tabla de pagos de aguinaldo</a></li>
                        <li><a href="#">Tabla de pagos de incapacidades</a></li>
                        <li><a href="#">Tabla de pago de salarios</a></li>
                        <li><a href="#">Tabla de pago de liquidaciones</a></li>
                    </ul>
                </div>
            </li>
            <li class="profile-menu">
                <a href="#" class="user-profile">
                    <img src="../img/FotoPerfil.jpg" alt="User Image">
                    <span class="fas fa-caret-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="Profile">Perfil</a></li>
                    <li><a href="../Controlador/Login.php?action=logout">  Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </div>

</body>

</html>
