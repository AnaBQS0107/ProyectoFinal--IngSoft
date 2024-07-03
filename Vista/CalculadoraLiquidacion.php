<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora liquidación</title>
    <link rel="stylesheet" href="Estilos/CalcLiquidacion.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="ContentContainer col-sm-9">
        <div class="ContentContainer">
            <!-- user messages -->

            <!-- validation summary -->
            <div id="ctl00_ValidationSummary" class="UserMessagesPlace ErrorMessage ValidationSummary" style="color:Red;display:none;">

            </div>
            <!-- content place holder -->
            <div class="MainContentPlaceDiv">

                <br>
                <h1>Calculadora de liquidación</h1>
                <hr>
                <div class="row">

                    <div class="col-lg-6 col-xs-12">

                        <div class="form-group">
                            <span id="ctl00_MainContentPlaceHolder_Label1">Fecha de ingreso</span>
                            <input name="ctl00$MainContentPlaceHolder$FechaIngresoTextBox" type="text" id="ctl00_MainContentPlaceHolder_FechaIngresoTextBox" class="form-control" placeholder="ejemplo 1/1/2015">
                        </div>

                        <div class="form-group">
                            <span id="ctl00_MainContentPlaceHolder_Label2">Fecha de salida</span>
                            <input name="ctl00$MainContentPlaceHolder$FechaSalidaTextBox" type="text" id="ctl00_MainContentPlaceHolder_FechaSalidaTextBox" class="form-control" placeholder="ejemplo 31/5/2015">
                        </div>

                        <div class="form-group">
                            <span id="ctl00_MainContentPlaceHolder_Label5">Se ha ejercido el preaviso </span>
                            <select name="ctl00$MainContentPlaceHolder$PreavisoATiempoDropDownList" id="PreavisoATiempoDropDownList" class="form-control">
                                <option value="0">Preaviso trabajado total</option>
                                <option value="1">Preaviso a pagar total</option>
                                <option value="2">Días pendientes de preaviso:</option>

                            </select>
                            <select name="ctl00$MainContentPlaceHolder$PreavisoParcialDropDownList" id="PreavisoParcialDropDownList" class="form-control" style="display: none;">
                                <option value="1">1 día</option>
                                <option value="2">2 días</option>
                                <option value="3">3 días</option>
                                <option value="4">4 días</option>
                                <option value="5">5 días</option>
                                <option value="6">6 días</option>
                                <option value="7">7 días</option>
                                <option value="8">8 días</option>
                                <option value="9">9 días</option>
                                <option value="10">10 días</option>
                                <option value="11">11 días</option>
                                <option value="12">12 días</option>
                                <option value="13">13 días</option>
                                <option value="14">14 días</option>
                                <option value="15">15 días</option>
                                <option value="16">16 días</option>
                                <option value="17">17 días</option>
                                <option value="18">18 días</option>
                                <option value="19">19 días</option>
                                <option value="20">20 días</option>
                                <option value="21">21 días</option>
                                <option value="22">22 días</option>
                                <option value="23">23 días</option>
                                <option value="24">24 días</option>
                                <option value="25">25 días</option>
                                <option value="26">26 días</option>
                                <option value="27" class="mayorA26">27 días</option>
                                <option value="28" class="mayorA26">28 días</option>
                                <option value="29" class="mayorA26">29 días</option>
                                <option value="30" class="mayorA26">30 días</option>

                            </select>
                        </div>

                    </div>


                    <div class="col-lg-6 col-xs-12">


                        <div class="form-group">
                            <span id="ctl00_MainContentPlaceHolder_Label6">Motivo de la salida</span>


                            <select name="ctl00$MainContentPlaceHolder$MotivoSalidaDropDownList" id="MotivoSalidaDropDownList" class="form-control">
                                <option value="3">despido con responsabilidad patronal</option>
                                <option value="2">despido sin responsabilidad patronal</option>
                                <option value="0">renuncia</option>
                                <option value="1" class="hidden">renuncia con responsabilidad patronal</option>
                                <option value="5">se acoge a la pensión</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <span id="ctl00_MainContentPlaceHolder_Label3">Tipo de pago</span>
                            <select name="ctl00$MainContentPlaceHolder$TipoPagoDropDownList" id="ctl00_MainContentPlaceHolder_TipoPagoDropDownList" class="form-control TipoPagoDropDownList">
                                <option value="quincenal / mensual">quincenal / mensual</option>
                                <option value="semanal">semanal</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <span id="ctl00_MainContentPlaceHolder_Label4">Saldo de vacaciones</span>
                            <input name="ctl00$MainContentPlaceHolder$SaldoDeVacacionesTextBox" type="number" value="0" id="ctl00_MainContentPlaceHolder_SaldoDeVacacionesTextBox" class="form-control">
                        </div>

                        <div class="clear"></div>
                        <div class="marginCenter text-center">
                            <input type="submit" name="ctl00$MainContentPlaceHolder$ContinuarButton" value="Continuar" id="ctl00_MainContentPlaceHolder_ContinuarButton" class="btn btn-primary">
                            <a href="Liquidacion.aspx" class="btn btn-default">Nuevo cálculo</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>

    <script>



    </script>
</body>

</html>