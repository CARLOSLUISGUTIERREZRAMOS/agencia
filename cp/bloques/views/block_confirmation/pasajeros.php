<table width="900" border="0" cellpadding="0" cellspacing="0" class="bgTable_data">
    <tr>
        <td colspan="7" align="left" class="titleTable gradiante" style="color:white;"><strong>Pasajeros</strong></td>

    </tr>
    <tr>
        <td height="3" colspan="7" style="background:#fdb813;"></td>
    </tr>
    <tr>
        <td width="120" class="subtitleTabla">Tipo</td>
        <td width="252" align="left" class="subtitleTabla">Nombre</td>
        <td width="252" align="left" class="subtitleTabla">Apellido</td>
        <td width="142" align="left" class="subtitleTabla">Doc. Identidad</td>
        <td width="132" align="center" class="subtitleTabla">Boleto Electr&oacute;nico</td>
    </tr>

    <?php
    $array = $_SESSION['pasajeros'];

    for ($i = 0; $i < count($array); $i++) {

        if ($array[$i]['Tipo_Pasajero'] == 'ADT') {
            $letra_tipo_pasajero = 'Adulto';
        } elseif ($array[$i]['Tipo_Pasajero'] == 'CNN') {
            $letra_tipo_pasajero = 'Niño';
        } else {
            $letra_tipo_pasajero = 'Infante';
        }
        if ($array[$i]['Tipo_Documento'] == 'NI') {
            $letra_tipo_documento = 'DNI';
        } elseif ($array[$i]['Tipo_Documento'] == 'PP') {
            $letra_tipo_documento = 'Pasaporte';
        }

        $_SESSION['ticket'] = $tickets[$i];
        
        ?>
        <tr style="background: #F0F0F0">
            <td height="18" align="left" class="bgTable_data"><?=$letra_tipo_pasajero?></td>
            <td align="left" class="bgTable_data"><?=$array[$i]['Nombres']?></td>
            <td align="left" class="bgTable_data"><?=$array[$i]['Apellidos']?></td>
            <td align="left" class="bgTable_data"><?=$letra_tipo_documento . ' ' . $array[$i]['Numero_Documento'] ?></td>
            <td align="center" class="bgTable_data"><a title="Click para visualizar el Boleto" href="imprimir_ticket.php?ticket=<?=$_SESSION['ticket'] ?>" target="_blank"><img src="../images/ticket.png" width="16" height="16" border="0" style="cursor: pointer" /></a></td>
        </tr>
    <?php
    }
    ?>
    
</table>


