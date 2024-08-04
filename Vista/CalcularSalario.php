<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de liquidaciones</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="/ProyectoFinal--IngSoft/Vista/Estilos/Footer2.css">
    <link rel="stylesheet" href="/ProyectoFinal--IngSoft/Vista/Estilos/Liquidaciones.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br><br>
<div class="MainContentPlaceDiv">                       
    <br>
    <h1>Calculadora de salario</h1>
    <hr>
    <form action="../Controlador/CalcularSalario.php" id="calcularsalarioform" class="container" method="post">

    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="form-group">
                <span>Cédula empleado</span>
                <input name="persona_cedula" type="text" id="persona_cedula" class="form-control" value="<?=$modelo_salario->persona_cedula ?>"  > 
                <!--imput =elemento que viaja al controlador  value= valor de lo que ingreso en el texto-->
            </div>
            <div class="form-group">
                <span>Salario Base</span>
                <input name="salario_base" type="text" id="persona_cedula" class="form-control" value="<?=$modelo_salario->salario_base ?>"  > 
                <!--elemento que viaja al controlador -->
            </div>

            <div class="form-group">
                <span>Fecha de Inicio</span>
                <input name="fecha_inicio" type="text" id="fecha_inicio" class="form-control" placeholder="ejemplo (YYYY-MM-DD HH:MM:SS" value="<?=$modelo_salario->fecha_inicio ?>"><!--caja de texto -->
            </div>

            <div class="form-group">
                <span >Fecha de final</span>
                <input name="fecha_final" type="text" id="fecha_final" class="form-control" placeholder="ejemplo (YYYY-MM-DD HH:MM:SS" value="<?=$modelo_salario->fecha_final ?>"> <!--caja de texto -->
            </div>

            <div class="form-group">
                <span>Su salario calculado total es:</span>
                <input name="salario_calculado_total" type="text" id="salario_calculado_total" class="form-control" value="<?=$modelo_salario->salario_calculado_total ?>" > <!--caja de texto -->
            </div>
        </div>

    </div>
    <div class="row">
    <div class="col-lg-6 col-xs-12">
        <center><button type="submit" id="calcularBtn" class="btn_calcular" >Calcular</button></center>
        </div>
    </div>
    </form>
    <br>
<hr>
<div class="LegendCalc">Estimado Usuario: En caso de tener alguna duda o consulta, puede preguntar
     con el personal de recursos humanos  <!--mensaje al usuario abajo -->
        </div>
 </div>

</body>