<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de liquidaciones</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Liquidaciones.css">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <br><br><br><br>
<div class="MainContentPlaceDiv">
       <?php  echo 'prueba'.$modelo_salario->persona_cedula; ?>                             
    <br>
    <h1>Calculadora de salario</h1>
    <hr>
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
                <input name="fecha_inicio" type="text" id="fecha_inicio" class="form-control" placeholder="ejemplo 1/1/2015" ><!--caja de texto -->
            </div>

            <div class="form-group">
                <span >Fecha de final</span>
                <input name="fecha_final" type="text" id="fecha_final" class="form-control" placeholder="ejemplo 1/1/2015" > <!--caja de texto -->
            </div>

            <div class="form-group">
                <span>total de horas horas_trabajadas</span>
                <input name="horas_trabajadas" type="text" id="horas_trabajas" class="form-control" placeholder="ejemplo: 6" > <!--caja de texto -->
            </div>

            <div class="form-group">
                <span>Su salario calculado total es:</span>
                <input name="salario_calculado_total" type="text" id="salario_calculado_total" class="form-control" > <!--caja de texto -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-12">

            <div class="marginCenter text-center">
                <input type="submit" name="Calcular" value="Calcular" id="" class="btn btn-primary" >     
            </div>
        </div>
    </div>
    <br>
<hr>
<div class="LegendCalc">Estimado Usuario: En caso de tener alguna duda o consulta, puede preguntar
     con el personal de recursos humanos  <!--mensaje al usuario abajo -->
        </div>
 </div>

</body>