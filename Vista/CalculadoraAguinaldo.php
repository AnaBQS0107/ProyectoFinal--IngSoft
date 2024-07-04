<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobación Horas Extras</title>
    <link rel="stylesheet" href="Estilos/HorasExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="MainContentPlaceDiv">

        <br>
        <h1>Calculadora de aguinaldo</h1>

        <div class="row">
            <div class="col-xs-12">
                <hr>
                <h2 class="Left">Salario bruto de los últimos meses</h2>
                <br><br>
                <ul>
                    <li>En cada una de las siguientes casillas se debe digitar el salario bruto devengado en cada mes según corresponda (Salario Bruto: Salario que incluye horas extras, comisiones, bonificaciones, sin rebajas de cargas sociales ni renta). <br><br></li>
                </ul>
                <hr>
            </div>
            <div class="col-lg-6 col-xs-12">
                <div class="form-group">
                    <label for="" id="">Diciembre (2023):</label>
                    <input name="" type="text" id="" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="">Enero:</label>
                    <input name="" type="text" id="" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Febrero:</label>
                    <input name="" type="text" id="" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Marzo:</label>
                    <input name="" type="text" id="" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Abril:</label>
                    <input name="" type="text" id="" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Mayo:</label>
                    <input name="" type="text" id="" class="form-control  numeroConFormato">
                </div>
            </div>

            <div class="col-lg-6 col-xs-12">

                <div class="form-group">
                    <label for="" id="">Junio:</label>
                    <input name="" type="text" id="" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Julio:</label>
                    <input name="" type="text" id="" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Agosto:</label>
                    <input name="" type="text" id="" disabled="disabled" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Setiembre:</label>
                    <input name="" type="text" id="" disabled="disabled" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Octubre:</label>
                    <input name="" type="text" id="" disabled="disabled" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="" id="">Noviembre:</label>
                    <input name="" type="text" id="" disabled="disabled" class="form-control numeroConFormato">
                </div>
            </div>

        </div>

        <div class="row"

            <div class="col-xs-12 SalarioEspecieContainer">
                <hr>
                <div class="Left">
                    <h2>Salario en especie</h2>
                    (Si aplica)
                </div>
                <div class="Left">
                    <div class="form-group">
                        <input type="radio" name="salarioEspecie" value="0" class="salarioEspecioRadio" checked="checked">
                        Sin salario en especie<br>

                    </div>
                    <div class="form-group">
                        <input type="radio" name="salarioEspecie" value="1" class="salarioEspecioRadio">
                        Porcentaje de salario en especie<br>
                        <input name="" type="number" id="PorcentajeEspecieTextBox" class="form-control" style="display: none;">
                    </div>
                    <div class="form-group">
                        <input type="radio" name="salarioEspecie" value="2" class="salarioEspecioRadio">
                        Monto mensual en especie<br>
                        <input name="" type="text" id="MontoMensualEspecieTextBox" class="form-control numeroConFormato" style="display: none;">
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="clear"></div>
        <input type="submit" name="" value="Calcular" id="" class="btn btn-primary marginCenter">
        <hr>

    </div>

    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>

    <script>

    </script>
</body>

</html>