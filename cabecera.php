 <?php 
$Entidad=$_SESSION['s_entidad'];
$RazonSocial=$_SESSION['nombre_entidad'];
$Nombres=$_SESSION['s_nombre'];
$ApellidoPaterno=$_SESSION['s_apellido_paterno'];
$ApellidoMaterno=$_SESSION['s_apellido_materno'];
$Tipo=$_SESSION['s_tipo'];
$LogoEntidad=$_SESSION['s_agencia']->LogoEntidad;
// echo "$LogoEntidad";die;
?>
<div id="div-header">
    <div id="div-header-content">
        <div id="div-header-logo">
            <a href="<?php echo $directorio;?>panel.php" class="a-logo">
                <?php $img = $url.($LogoEntidad ? $LogoEntidad : '/cp/images/LogoStar.png')  ?>
                <img src="<?=$img?>" title="" border="0" style="width: 181px;height: 60px;">
            </a>
            <?php if ($Tipo=='G'): ?>
                <div class="_icon_logo">
                    <div class="_156n">
                        <div class="icon">
                            <i class="fa fa-camera"></i>
                        </div>
                        <span>Actualizar</span>
                    </div>
                </div>
                <form id="form-logo" enctype="multipart/form-data">
                    <input type="file" id="LogoEntidad" name="LogoEntidad" accept=".png,.jpeg,.jpg" style="display: none">
                </form>
            <?php endif ?>
        </div>
        <div id="div-header-info-usuario">
            <div id="div-info-usuario-content">
                <div style="float:left; margin:0 5px 0 0; text-align:right;">
                    <?php echo utf8_encode($RazonSocial);?><br/><?php echo utf8_encode($Nombres.' '.$ApellidoPaterno.' '.$ApellidoMaterno); ?><br/>[<?php if($Tipo=='G'){echo 'Administrador';}else{echo 'Counter';} ?>]
                </div>
                <div style="float:left; margin:0 0 20px 0;">
                    <img src="<?php echo $directorio;?>images/usuario.png">
                </div>
                <div style="clear:both; text-align:right;">
                    <a href="<?php echo $directorio;?>logout.php">Salir</a>
                    <img src="<?php echo $directorio;?>images/salir.png" class="img-salir"style="margin:0 4px 0 4px; vertical-align:middle; cursor:pointer;" onClick="javascript:window.location = '<?php echo $directorio;?>logout.php'">
                </div>
            </div>
        </div>
    </div>
</div> 