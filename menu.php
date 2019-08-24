<?php if ($Tipo=='G'): ?>
    <div id="div-menu-principal">
        <ul>
            <li onClick="javascript:window.location = '<?php echo $url;?>/cp/gestor/agencia_info.php';" >
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:180px;">
                    <img src="<?php echo $directorio_imagen;?>images/datospersonales.png" style="position:relative;top:5px;">
                    <a title="Ver Datos de la Agencia" href="<?php echo $url;?>/cp/gestor/agencia_info.php" style="top: 7px;left:5px;position: relative;"> datos agencia</a>
                </div>
            </li>
            <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>gestor_info_personal.php';" >
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:180px;">
                    <img src="<?php echo $directorio_imagen;?>images/datospersonales.png" style="position:relative;top:5px;">
                    <a title="Ver Datos Personales del Administrador" href="<?php echo $directorio_personal;?>gestor_info_personal.php" style="top: 7px;left:5px;position: relative;"> datos personales</a>
                </div>
            </li>
            <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>delegado_listado.php'">
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:130px;">
                    <img src="<?php echo $directorio_imagen;?>images/delegados.png" style="position:relative;top:5px;">
                    <a title="Ver Listado de Usuarios" href="<?php echo $directorio_personal;?>delegado_listado.php" style="top: 7px;left:5px;position: relative;">usuarios</a>
                </div>
            </li>
            <li onClick="javascript:window.location = '<?php echo $directorio;?>panel.php';">
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:180px;">
                    <img src="<?php echo $directorio_imagen;?>images/comprar.png" style="position:relative;top:5px;">
                    <a title="Comprar Pasajes" href="<?php echo $directorio;?>panel.php" style="top: 7px;left:5px;position: relative;">comprar pasajes</a>
                </div>
            </li>
            <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>anular_boleto.php';">
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:170px;">
                    <img src="<?php echo $directorio_imagen;?>images/cancelarboleto.png" style="position:relative;top:5px;">
                    <a title="Anular Boletos" href="<?php echo $directorio_personal;?>anular_boleto.php" style="top: 7px;left:5px;position: relative;">anular boleto</a>
                </div>
            </li>
            <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>reporte.php'">
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:150px;">
                    <img src="<?php echo $directorio_imagen;?>images/movimientos.png" style="position:relative;top:5px;">
                    <a title="Ver Movimientos" href="<?php echo $directorio_personal;?>reporte.php" style="top: 7px;left:5px;position: relative;">movimientos</a>
                </div>
            </li>
            <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>ayuda.php'">
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:150px;">
                    <img src="<?php echo $directorio_imagen;?>images/movimientos.png" style="position:relative;top:5px;">
                    <a title="Ver Movimientos" href="<?php echo $directorio_personal;?>ayuda.php" style="top: 7px;left:5px;position: relative;">manuales</a>
                </div>
            </li>
        </ul>
    </div>
<?php else: ?>
    <div id="div-menu-principal">
        <ul>
            <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>delegado_info_personal.php';">
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:180px;">
                    <img src="<?php echo $directorio_imagen;?>images/datospersonales.png" style="position:relative;top:5px;">
                    <a title="Ver Datos Personales del Counter" href="<?php echo $directorio_personal;?>delegado_info_personal.php" style="top: 7px;left:5px;position: relative;"> datos personales</a>
                </div>
            </li>
            <li onClick="javascript:window.location = '<?php echo $directorio;?>panel.php';">
                <div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''"  style="width:180px;">
                    <img src="<?php echo $directorio_imagen;?>images/comprar.png" style="position:relative;top:5px;">
                    <a title="Comprar Pasajes"  href="<?php echo $directorio;?>panel.php" style="top: 7px;left:5px;position: relative;">comprar pasajes</a>
                </div>
            </li>                
        </ul>
    </div>
<?php endif ?>