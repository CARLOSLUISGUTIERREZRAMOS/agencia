<?php 
if($Tipo=='G'){
?>            
    <div id="div-menu-principal">
               <ul>
                   <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>gestor_info_personal.php';" ><div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:180px;"><img src="<?php echo $directorio_imagen;?>images/datospersonales.png" style="position:relative;top:7px;"><a title="Ver Datos Personales del Gestor" href="<?php echo $directorio_personal;?>gestor_info_personal.php" style="top: 0px;left:5px;position: relative;"> datos personales</a></div></li>
                   <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>delegado_listado.php'"><div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:130px;"><img src="<?php echo $directorio_imagen;?>images/delegados.png" style="position:relative;top:7px;"><a title="Ver Listado de Delegados" href="<?php echo $directorio_personal;?>delegado_listado.php" style="top: 0px;left:5px;position: relative;">usuarios</a></div></li>
                   <li onClick="javascript:window.location = '<?php echo $directorio;?>panel.php';"><div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:180px;"><img src="<?php echo $directorio_imagen;?>images/comprar.png" style="position:relative;top:7px;"><a title="Comprar Pasajes" href="<?php echo $directorio;?>panel.php" style="top: 0px;left:5px;position: relative;">comprar pasajes</a></div></li>
                   <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>anular_boleto.php';"><div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:170px;"><img src="<?php echo $directorio_imagen;?>images/cancelarboleto.png" style="position:relative;top:7px;"><a title="Anular Boletos" href="<?php echo $directorio_personal;?>anular_boleto.php" style="top: 0px;left:5px;position: relative;">anular boleto</a></div></li>
                   <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>reporte.php'"><div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:150px;"><img src="<?php echo $directorio_imagen;?>images/movimientos.png" style="position:relative;top:7px;"><a title="Ver Movimientos" href="<?php echo $directorio_personal;?>reporte.php" style="top: 0px;left:5px;position: relative;">movimientos</a></div></li>
               </ul>
     </div>
<?php 
}else{
?> 
    <div id="div-menu-principal">
                <ul>
                    <li onClick="javascript:window.location = '<?php echo $directorio_personal;?>delegado_info_personal.php';"><div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''" style="width:180px;"><img src="<?php echo $directorio_imagen;?>images/datospersonales.png" style="position:relative;top:7px;"><a title="Ver Datos Personales del Delegado" href="<?php echo $directorio_personal;?>delegado_info_personal.php" style="top: 0px;left:5px;position: relative;"> datos personales</a></div></li>
                    <li onClick="javascript:window.location = '<?php echo $directorio;?>panel.php';"><div onMouseOver="javascript:this.className = 'div_hover';" onMouseOut="javascript:this.className = ''"  style="width:180px;"><img src="<?php echo $directorio_imagen;?>images/comprar.png" style="position:relative;top:7px;"><a title="Comprar Pasajes"  href="<?php echo $directorio;?>panel.php" style="top: 0px;left:5px;position: relative;">comprar pasajes</a></div></li>                
                </ul>
    </div>
<?php   
}
?>