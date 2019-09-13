<?php
    error_reporting(E_ALL);
    ini_set("display_errors",0);
    date_default_timezone_set('America/Lima');
    if($_SESSION['s_entra']==0){
        header('Location:../../index.php');
    }
    $error_visa=$_SESSION['error_visa'];
    $denegaciones=[
        '101'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta Vencida.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta Vencida. Verifique los datos en su tarjeta e ingréselos correctamente.'],
        '102'=>['descripcion_sistema' => 'Operación Denegada. Contactar con la entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '104'=>['descripcion_sistema' => 'Operación Denegada. Operación no permitida para esta tarjeta.',   'descripcion_cliente' => 'Operación Denegada. Operación no permitida para esta tarjeta. Contactar con la entidad emisora de su tarjeta.'],
        '106'=>['descripcion_sistema' => 'Operación Denegada. Exceso de intentos de ingreso de clave secreta.',   'descripcion_cliente' => 'Operación Denegada. Intentos de clave secreta excedidos. Contactar con la entidad emisora de su tarjeta.'],
        '107'=>['descripcion_sistema' => 'Operación Denegada. Contactar con la entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con la entidad emisora de su tarjeta.'],
        '108'=>['descripcion_sistema' => 'Operación Denegada. Exceso de actividad.',   'descripcion_cliente' => 'Operación Denegada. Contactar con la entidad emisora de su tarjeta.'],
        '109'=>['descripcion_sistema' => 'Operación Denegada. Identificación inválida de establecimiento.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '110'=>['descripcion_sistema' => 'Operación Denegada. Operación no permitida para esta tarjeta.',   'descripcion_cliente' => 'Operación Denegada. Operación no permitida para esta tarjeta. Contactar con la entidad emisora de su tarjeta.'],
        '111'=>['descripcion_sistema' => 'Operación Denegada. El monto de la transacción supera el valor máximo permitido para operaciones virtuales',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '112'=>['descripcion_sistema' => 'Operación Denegada. Se requiere clave secreta.',   'descripcion_cliente' => 'Operación Denegada. Se requiere clave secreta.'],
        '116'=>['descripcion_sistema' => 'Operación Denegada. Fondos insuficientes.',   'descripcion_cliente' => 'Operación Denegada. Fondos insuficientes. Contactar con entidad emisora de su tarjeta'],
        '117'=>['descripcion_sistema' => 'Operación Denegada. Clave secreta incorrecta.',   'descripcion_cliente' => 'Operación Denegada. Clave secreta incorrecta.'],
        '118'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta inválida.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta Inválida. Contactar con entidad emisora de su tarjeta.'],
        '119'=>['descripcion_sistema' => 'Operación Denegada. Exceso de intentos de ingreso de clave secreta.',   'descripcion_cliente' => 'Operación Denegada. Intentos de clave secreta excedidos. Contactar con entidad emisora de su tarjeta.'],
        '121'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '126'=>['descripcion_sistema' => 'Operación Denegada. Clave secreta inválida.',   'descripcion_cliente' => 'Operación Denegada. Clave secreta inválida.'],
        '129'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta no operativa.',   'descripcion_cliente' => 'Operación Denegada. Código de seguridad invalido. Contactar con entidad emisora de su tarjeta'],
        '180'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta inválida.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta Inválida. Contactar con entidad emisora de su tarjeta.'],
        '181'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta con restricciones de Débito.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta con restricciones de débito. Contactar con entidad emisora de su tarjeta.'],                
        '182'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta con restricciones de Crédito.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta con restricciones de crédito. Contactar con entidad emisora de su tarjeta.'],
        '183'=>['descripcion_sistema' => 'Operación Denegada. Error de sistema.',   'descripcion_cliente' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'],
        '190'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '191'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '192'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '199'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '201'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta vencida.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta vencida. Contactar con entidad emisora de su tarjeta.'],
        '202'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta'],
        '204'=>['descripcion_sistema' => 'Operación Denegada. Operación no permitida para esta tarjeta.',   'descripcion_cliente' => 'Operación Denegada. Operación no permitida para esta tarjeta. Contactar con entidad emisora de su tarjeta.'],
        '206'=>['descripcion_sistema' => 'Operación Denegada. Exceso de intentos de ingreso de clave secreta.',   'descripcion_cliente' => 'Operación Denegada. Intentos de clave secreta excedidos. Contactar con la entidad emisora de su tarjeta.'],
        '207'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta..'],
        '208'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta perdida.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '209'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta robada.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta'],
        '263'=>['descripcion_sistema' => 'Operación Denegada. Error en el envío de parámetros.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '264'=>['descripcion_sistema' => 'Operación Denegada. Entidad emisora no está disponible para realizar la autenticación.',   'descripcion_cliente' => 'Operación Denegada. Entidad emisora de la tarjeta no está disponible para realizar la autenticación.'],
        '265'=>['descripcion_sistema' => 'Operación Denegada. Clave secreta del tarjetahabiente incorrecta.',   'descripcion_cliente' => 'Operación Denegada. Clave secreta del tarjetahabiente incorrecta. Contactar con entidad emisora de su tarjeta.'],
        '266'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta vencida.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta Vencida. Contactar con entidad emisora de su tarjeta.'],
        '280'=>['descripcion_sistema' => 'Operación Denegada. Clave errónea.',   'descripcion_cliente' => 'Operación Denegada. Clave secreta errónea. Contactar con entidad emisora de su tarjeta.'],
        '290'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '300'=>['descripcion_sistema' => 'Operación Denegada. Número de pedido del comercio duplicado. Favor no atender.',   'descripcion_cliente' => 'Operación Denegada. Número de pedido del comercio duplicado. Favor no atender.'],
        '306'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '401'=>['descripcion_sistema' => 'Operación Denegada. Tienda inhabilitada.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '402'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '403'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta no autenticada',   'descripcion_cliente' => 'Operación Denegada. Tarjeta no autenticada.'],
        '404'=>['descripcion_sistema' => 'Operación Denegada. El monto de la transacción supera el valor máximo permitido.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '405'=>['descripcion_sistema' => 'Operación Denegada. La tarjeta ha superado la cantidad máxima de transacciones en el día.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '406'=>['descripcion_sistema' => 'Operación Denegada. La tienda ha superado la cantidad máxima de transacciones en el día.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '407'=>['descripcion_sistema' => 'Operación Denegada. El monto de la transacción no llega al mínimo permitido.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '408'=>['descripcion_sistema' => 'Operación Denegada. CVV2 no coincide.',   'descripcion_cliente' => 'Operación Denegada. Código de seguridad no coincide. Contactar con entidad emisora de su tarjeta'],
        '409'=>['descripcion_sistema' => 'Operación Denegada. CVV2 no procesado por entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Código de seguridad no procesado por la entidad emisora de la tarjeta'],
        '410'=>['descripcion_sistema' => 'Operación Denegada. CVV2 no procesado por no ingresado.',   'descripcion_cliente' => 'Operación Denegada. Código de seguridad no ingresado.'],
        '411'=>['descripcion_sistema' => 'Operación Denegada. CVV2 no procesado por entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Código de seguridad no procesado por la entidad emisora de la tarjeta'],
        '412'=>['descripcion_sistema' => 'Operación Denegada. CVV2 no reconocido por entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Código de seguridad no reconocido por la entidad emisora de la tarjeta'],
        '413'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '414'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '415'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '416'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '417'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '418'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '419'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '420'=>['descripcion_sistema' => 'Operación Denegada. Tarjeta no es VISA.',   'descripcion_cliente' => 'Operación Denegada. Tarjeta no es VISA.'],
        '421'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'],
        '422'=>['descripcion_sistema' => 'Operación Denegada. El comercio no está configurado para usar este medio de pago.',   'descripcion_cliente' => 'Operación Denegada. El comercio no está configurado para usar este medio de pago. Contactar con el comercio.'],
        '423'=>['descripcion_sistema' => 'Operación Denegada. Se canceló el proceso de pago.',   'descripcion_cliente' => 'Operación Denegada. Se canceló el proceso de pago.'],
        '424'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada.'],
        '666'=>['descripcion_sistema' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.',   'descripcion_cliente' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'],
        '667'=>['descripcion_sistema' => 'Operación Denegada. Transacción sin autenticación. Inicio del Proceso de Pago',   'descripcion_cliente' => 'Operación Denegada. Transacción sin respuesta de Verified by Visa.'],
        '668'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '669'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '670'=>['descripcion_sistema' => 'Operación Denegada. Módulo antifraude.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '672'=>['descripcion_sistema' => 'Operación Denegada. Transacción sin respuesta de Antifraude.',   'descripcion_cliente' => 'Operación Denegada. Módulo antifraude.'],
        '673'=>['descripcion_sistema' => 'Operación Denegada. Transacción sin respuesta del Autorizador.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '674'=>['descripcion_sistema' => 'Operación Denegada. Sesión no válida.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '675'=>['descripcion_sistema' => 'Inicialización de transacción',   'descripcion_cliente' => 'Inicialización de transacción'],
        '676'=>['descripcion_sistema' => 'Operación Denegada. No activa la opción Revisar Enviar al Autorizador.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '677'=>['descripcion_sistema' => 'Operación Denegada. Respuesta Antifraude con parámetros nos válidos.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '678'=>['descripcion_sistema' => 'Operación Denegada. Valor ECI no válido.',   'descripcion_cliente' => 'Operación Denegada. Contactar con el comercio.'],
        '682'=>['descripcion_sistema' => 'Operación Denegada. Intento de Pago fuera del tiempo permitido.',   'descripcion_cliente' => 'Operación Denegada. Operación Denegada.'],
        '683'=>['descripcion_sistema' => 'Operación Denegada. Registro incorrecto de sesión.',   'descripcion_cliente' => 'Operación Denegada. Registro incorrecto de sesión.'],
        '684'=>['descripcion_sistema' => 'Operación Denegada Registro Incorrecto Antifraude',   'descripcion_cliente' => 'Operación Denegada Registro Incorrecto Antifraude'],
        '685'=>['descripcion_sistema' => 'Operación Denegada Registro Incorrecto Autorizador',   'descripcion_cliente' => 'Operación Denegada Registro Incorrecto Autorizador'],
        '904'=>['descripcion_sistema' => 'Operación Denegada. Formato de mensaje erróneo.',   'descripcion_cliente' => 'Operación Denegada.'],
        '909'=>['descripcion_sistema' => 'Operación Denegada. Error de sistema.',   'descripcion_cliente' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'],
        '910'=>['descripcion_sistema' => 'Operación Denegada. Error de sistema.',   'descripcion_cliente' => 'Operación Denegada.'],
        '912'=>['descripcion_sistema' => 'Operación Denegada. Entidad emisora no disponible.',   'descripcion_cliente' => 'Operación Denegada. Entidad emisora de la tarjeta no disponible'],
        '913'=>['descripcion_sistema' => 'Operación Denegada. Transmisión duplicada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '916'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada.'],
        '928'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada.'],
        '940'=>['descripcion_sistema' => 'Operación Denegada. Transacción anulada previamente.',   'descripcion_cliente' => 'Operación Denegada.'],
        '941'=>['descripcion_sistema' => 'Operación Denegada. Transacción ya anulada previamente.',   'descripcion_cliente' => 'Operación Denegada.'],
        '942'=>['descripcion_sistema' => 'Operación Denegada.',   'descripcion_cliente' => 'Operación Denegada.'],
        '943'=>['descripcion_sistema' => 'Operación Denegada. Datos originales distintos.',   'descripcion_cliente' => 'Operación Denegada.'],
        '945'=>['descripcion_sistema' => 'Operación Denegada. Referencia repetida.',   'descripcion_cliente' => 'Operación Denegada.'],
        '946'=>['descripcion_sistema' => 'Operación Denegada. Operación de anulación en proceso.',   'descripcion_cliente' => 'Operación Denegada. Operación de anulación en proceso.'],
        '947'=>['descripcion_sistema' => 'Operación Denegada. Comunicación duplicada.',   'descripcion_cliente' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'],
        '948'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada.'],
        '949'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada.'],
        '965'=>['descripcion_sistema' => 'Operación Denegada. Contactar con entidad emisora.',   'descripcion_cliente' => 'Operación Denegada.']
    ];
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
                                                    <?php if($error_visa->dataVisa->ACTION_CODE): ?>
                                                        <?php if($denegaciones[$error_visa->dataVisa->ACTION_CODE]): ?>
                                                            <br>
                                                            <?= $denegaciones[$error_visa->dataVisa->ACTION_CODE]['descripcion_cliente']?>
                                                        <?php endif?>
                                                    <?php endif?>
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