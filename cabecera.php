 <?php 
$Entidad=$_SESSION['s_entidad'];
$RazonSocial=$_SESSION['nombre_entidad'];
$Nombres=$_SESSION['s_nombre'];
$ApellidoPaterno=$_SESSION['s_apellido_paterno'];
$ApellidoMaterno=$_SESSION['s_apellido_materno'];
$Tipo=$_SESSION['s_tipo'];
?>
<style type="text/css">
    ._23fv {
        bottom: 21px;
        left: 20px;
        overflow: hidden;
        width: 160px;
    }
    .logoEntidadCambiar {
        bottom: 30px;
        left: 15px;
        text-align: center;
        top: auto;
        width: 170px;
    }
    .logoEntidadCambiar{
        position: absolute;
        z-index: 5;
    }
    ._156n {
        display: block;
        overflow: hidden;
        position: relative;
        text-align: left;
    }
</style>
<div id="div-header">
    <div id="div-header-content">
        <div id="div-header-logo">
            <a href="<?php echo $directorio;?>panel.php">
                <img src="<?php echo $directorio;?>images/LogoStar.png" title="" border="0" />
            </a>
            <!-- <div class="logoEntidadCambiar _23fv">
                <div class="_156n _23fw _1o59" data-ft="{&quot;tn&quot;:&quot;+B&quot;}">
                    <a href="#" class="_156p _1o5e" ajaxify="/profile/picture/menu_dialog/?context_id=u_0_11&amp;profile_id=100003814295686" rel="dialog" role="button" id="u_0_1d" tabindex="0">
                        <div class="_3-95">
                            <i class="fa fa-camera _1din _156q _1o6f img sp_C-eevkKqVp7 sx_fc264a"></i>
                        </div>Actualizar
                    </a>
                </div>
            </div> -->
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