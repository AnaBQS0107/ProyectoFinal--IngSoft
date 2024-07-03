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
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes12TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label1">Diciembre (2023):</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes12TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes12TextBox" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes1TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label2">Enero:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes1TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes1TextBox" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes2TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label3">Febrero:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes2TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes2TextBox" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes3TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label4">Marzo:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes3TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes3TextBox" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes4TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label5">Abril:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes4TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes4TextBox" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes5TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label6">Mayo:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes5TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes5TextBox" class="form-control  numeroConFormato">
                </div>
            </div>

            <div class="col-lg-6 col-xs-12">

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes6TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label7">Junio:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes6TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes6TextBox" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes7TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label8">Julio:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes7TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes7TextBox" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes8TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label9">Agosto:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes8TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes8TextBox" disabled="disabled" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes9TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label10">Setiembre:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes9TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes9TextBox" disabled="disabled" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes10TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label11">Octubre:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes10TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes10TextBox" disabled="disabled" class="form-control numeroConFormato">
                </div>

                <div class="form-group">
                    <label for="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes11TextBox" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Label12">Noviembre:</label>
                    <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$Mes11TextBox" type="text" id="ctl00_MainContentPlaceHolder_AguinaldoWebUserControl_Mes11TextBox" disabled="disabled" class="form-control numeroConFormato">
                </div>
            </div>

        </div>

        <div class="row">

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
                        <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$PorcentajeEspecieTextBox" type="number" id="PorcentajeEspecieTextBox" class="form-control" style="display: none;">
                    </div>
                    <div class="form-group">
                        <input type="radio" name="salarioEspecie" value="2" class="salarioEspecioRadio">
                        Monto mensual en especie<br>
                        <input name="ctl00$MainContentPlaceHolder$AguinaldoWebUserControl$MontoMensualEspecieTextBox" type="text" id="MontoMensualEspecieTextBox" class="form-control numeroConFormato" style="display: none;">
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="clear"></div>
        <input type="submit" name="ctl00$MainContentPlaceHolder$CalcularButton" value="Calcular" id="ctl00_MainContentPlaceHolder_CalcularButton" class="btn btn-primary marginCenter">
        <hr>

    </div>

    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>

    <script>

    </script>
</body>

</html>