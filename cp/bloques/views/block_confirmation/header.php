<?php
if ($tipo_viaje_cc == 'R') {
    ?>
    <table width="900" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="6" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
        </tr>
        <tr>
            <td height="3" colspan="6" style="background:#fdb813;"></td>
        </tr>
        <tr>
            <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
            <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
            <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
            <td width="104" align="left" class="subtitleTabla">Clase</td>
            <td width="104" align="left" class="subtitleTabla">Equipaje</td>
        </tr>
        <tr style="background: #F0F0F0">
            <td align="left" class="bgTable_data"><?=date("d/m/Y", strtotime($fecha_salida_ida_cc))?></td>
            <td align="left" class="bgTable_data"><strong><?=$hora_salida_ida_cc?></strong></td>
            <td align="left" class="bgTable_data"><?=$numero_vuelo_ida_cc?></td>
            <td align="left" class="bgTable_data"><?= $clase_ida_cc ?></td>
            <td align="left" class="bgTable_data">23 KG</td>
        </tr>
        <tr>
            <td align="left" class="subtitleTabla">Fecha de Regreso</td>
            <td align="left" class="subtitleTabla">Hora de Salida</td>
            <td align="left" class="subtitleTabla">N° de Vuelo</td>
            <td align="left" class="subtitleTabla">Clase</td>
            <td align="left" class="subtitleTabla">Equipaje</td>
        </tr>
        <tr style="background: #F0F0F0">
            <td align="left" class="bgTable_data"><?= date("d/m/Y", strtotime($fecha_salida_vuelta_cc)) ?></td>
            <td align="left" class="bgTable_data"><strong><?=$hora_llegada_vuelta_cc ?></td>
            <td align="left" class="bgTable_data"><?= $numero_vuelo_vuelta_cc ?></td>
            <td align="left" class="bgTable_data"><?=$clase_vuelta_cc ?></td>
            <td align="left" class="bgTable_data">23 KG</td>
        </tr>
    </table>

<?php
} elseif ($tipo_viaje_cc == 'O') {
    ?>
    <table width="900" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="6" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
        </tr>
        <tr>
            <td height="3" colspan="6" style="background:#fdb813;"></td>
        </tr>
        <tr>
            <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
            <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
            <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
            <td width="104" align="left" class="subtitleTabla">Clase</td>
            <td width="104" align="left" class="subtitleTabla">Equipaje</td>
        </tr>
        <tr style="background: #F0F0F0">
            <td align="left" class="bgTable_data"><?=date("d/m/Y", strtotime($fecha_salida_ida_cc))?></td>
            <td align="left" class="bgTable_data"><strong><?=$hora_salida_ida_cc?></strong></td>
            <td align="left" class="bgTable_data"><?=$numero_vuelo_ida_cc?></td>
            <td align="left" class="bgTable_data"><?= $clase_ida_cc ?></td>
            <td align="left" class="bgTable_data">23 KG</td>
        </tr>
    </table>
<?php
}
?>