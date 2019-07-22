<?php
    error_reporting(E_ALL);
    ini_set("display_errors",0);
    date_default_timezone_set('America/Lima');
    if($_SESSION['s_entra']==0){
        header('Location:../../index.php');
    }
    $error_visa=$_SESSION['error_visa'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
        <link type="text/css" href="css/jquery/jquery.ui.all.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="js/thickbox/thickbox.css"/>
        <script type="text/javascript" src="js/jquery-1.7.min.js"></script>
        <script language="javascript" src="js/thickbox/thickbox-compressed.js"></script>
        <script language="javascript">
            function show(){
                $("#checkthickbox").click();
            }
        </script>
        <script type="text/javascript" language="javascript1.2" src="js/funciones.js"></script>
        <link href="css/estilos.css" rel="stylesheet" type="text/css" />
        <style>
            a {
                color: #CF2337;
                text-decoration: none;
                background-color: transparent;
                -webkit-text-decoration-skip: objects;
            }
            .gradiante{
                background: linear-gradient(#f01515, darkred) !important;
                background: -webkit-linear-gradient(#f01515, darkred) !important;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f01515', endColorstr='darkred');
            }
            .alert-danger {
                color: #721c24;
                background-color: #f8d7da;
                border-color: #f5c6cb;
            }
            .alert-info {
                color: #0c5460;
                background-color: #d1ecf1;
                border-color: #bee5eb;
            }
            .alert {
                position: relative;
                padding: .75rem 1.25rem;
                margin-bottom: 1rem;
                border: 1px solid transparent;
                border-radius: .25rem;
                text-align: center;
            }
            .cabecera>thead>tr>th{
                background-color: #F0F0F0 !important;
                padding: 10px;
            }
            .table {
                width: 100%;
                max-width: 100%;
            }
            .table>tbody>tr>td, .table>tbody>tr>th {
                padding: 8px;
                line-height: 1.42857143;
                vertical-align: top;
                font-weight: bold;
                /* border-top: 1px solid #ddd; */
            }
            .table>tbody>tr>th{
                text-align: right;
            }
            .table>tbody>tr>td {
                color: #383737cc;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <center>
            <table width="900" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF">
                <tr>
                    <td height="20" align="center" style="background-color: #FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td height="40" align="center">
                        <table width="800" cellpadding="0" cellspacing="0" border="0">
                            <tr style="color:#000000;">
                                <td >1. FECHA</td>
                                <td >2. VUELOS</td>
                                <td >3. PRECIO</td>
                                <td >4. PASAJEROS</td>
                                <td style="text-decoration: underline;color: #cf2337;">5. CONFIRMACIÓN</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="340" align="center" style="background-color: #FFFFFF">
                        <table width="900" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table  width="900">
                                        <tr>
                                            <th>
                                                <div class="alert alert-danger" role="alert">
                                                    Surgió un error <?= $error_visa->cod_error_visa?> al realizar el pago <br>
                                                    <?= $error_visa->dataVisa->ACTION_DESCRIPTION?>
                                                </div>
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table class="cabecera" width="900">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h2 align="center">Datos de la Compra:</h2>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th align="right">Código de reserva:</th>
                                                                <td><?= $error_visa->pnr_reserva?></td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">Moneda:</th>
                                                                <td>USD</td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">Monto de la Transacción</th>
                                                                <td>$ <?= $error_visa->dataVisa->AMOUNT?></td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">Numero de Tarjeta:</th>
                                                                <td><?= $error_visa->dataVisa->CARD?></td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">Fecha y Hora del pedido:</th>
                                                                <td> <?= date('d-m-Y H:i:s')?></td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">Nombre del TarjetaHabiente:</th>
                                                                <td><?= $error_visa->TarjetaHabiente?></td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">Código de error</th>
                                                                <td><?= $error_visa->dataVisa->ECI_DESCRIPTION?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table width="900">
                                        <tr>
                                            <th>
                                                <div class="alert alert-info" role="alert">
                                                    Si su compra fué denegada lo puede intentar de nuevo presionando <a href="paso1.php">presionando aquí</a>
                                                </div>
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
<?php unset($_SESSION['error_visa']);?>