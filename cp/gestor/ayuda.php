<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
        
        include '../cd/Navegador/index.php';
        
	if($_SESSION['s_entra']==0){
	    header('Location:../../index.php');
	}
	$Tipo=$_SESSION['s_tipo'];
	$directorio='../';
	$directorio_imagen='../';
	require_once("../../config.php");
?>

<?php ob_start(); ?>
	<link href="<?=$url?>/cp/css/gestor.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	</script>
	<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<br>
<div id="div-gestor">
    <table  width="900" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;background-color: #F0F0F0;">
        <tr>
            <td height="26" colspan="4" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Videos</td>
        </tr>
        <tr>
            <td height="3" colspan="4"  style="background:#fdb813;"></td>
        </tr>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
        <tr>
            <td>
                <div class="row">
                  <div class="col-lg-4 col-md-12 mb-4">
                    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-body mb-0 p-0">
                            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                              <iframe class="embed-responsive-item" src="../../cp/videos/registrar usuario.mp4"
                                allowfullscreen></iframe>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                              <span class="mr-4"><b>Registrar Usuario</b></span>
                            <button type="button" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <a><img class="img-fluid z-depth-1" src="../../cp/images/registrar_usuario.jpg" alt="video"
                        data-toggle="modal" data-target="#modal1"></a>
                  </div>
                    
                  <div class="col-lg-4 col-md-6 mb-4">
                    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-body mb-0 p-0">
                            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                              <iframe class="embed-responsive-item" src="../../cp/videos/comprar pasajes.mp4"
                                allowfullscreen></iframe>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                              <span class="mr-4"><b>Comprar Pasajes</b></span>
                            <button type="button" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal" >Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <a><img class="img-fluid z-depth-1" src="../../cp/images/comprar_pasajes.jpg" alt="video"
                        data-toggle="modal" data-target="#modal2"></a>
                  </div>
                    
                  <div class="col-lg-4 col-md-6 mb-4">
                    <div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-body mb-0 p-0">
                            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                                <iframe class="embed-responsive-item" src="../../cp/videos/anular boleto.mp4"
                                allowfullscreen></iframe>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                              <span class="mr-4"><b>Anular Boletos</b></span>
                            <button type="button" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <a><img class="img-fluid z-depth-1" src="../../cp/images/anular_boletos.jpg" alt="video"
                        data-toggle="modal" data-target="#modal3"></a>
                  </div>
                    
                  <div class="col-lg-4 col-md-12 mb-4">
                    <div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-body mb-0 p-0">
                            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                                <iframe class="embed-responsive-item" src="../../cp/videos/editar datos de agencia.mp4"
                                allowfullscreen></iframe>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                              <span class="mr-4"><b>Editar Datos Agencia</b></span>
                            <button type="button" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                      <a><img class="img-fluid z-depth-1" src="../../cp/images/editar_datos_agencia.jpg" alt="video"
                        data-toggle="modal" data-target="#modal4"></a>
                  </div> 
                    
                  <div class="col-lg-4 col-md-12 mb-4">
                    <div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-body mb-0 p-0">
                            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                                <iframe class="embed-responsive-item" src="../../cp/videos/movimientos.mp4"
                                allowfullscreen></iframe>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                              <span class="mr-4"><b>Ver Reporte<br>Exportar Reporte en Excel</b></span>
                            <button type="button" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                      <a><img class="img-fluid z-depth-1" src="../../cp/images/ver_exportar_reporte.jpg" alt="video"
                        data-toggle="modal" data-target="#modal5"></a>
                  </div>
                    
                   <div class="col-lg-4 col-md-12 mb-4">
                    <div class="modal fade" id="modal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-body mb-0 p-0">
                            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                                <iframe class="embed-responsive-item" src="../../cp/videos/registrar_agencia.mp4"
                                allowfullscreen></iframe>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                              <span class="mr-4"><b>Registrar Agencia</b></span>
                            <button type="button" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                       <a><img class="img-fluid z-depth-1" src="../../cp/images/registrar_agencia.jpg" alt="video"
                        data-toggle="modal" data-target="#modal6"></a>
                  </div>
                    
                </div>
            </td>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
    </table>
    <br>
    <table width="900" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;background-color: #F0F0F0;">
        <tr>
            <td height="26" colspan="4" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Manual</td>
        </tr>
        <tr>
            <td height="3" colspan="4"  style="background:#fdb813;"></td>
        </tr>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
        <tr>
            <td>
                Haz click en el botón para descargar el manual de usuario. <a class="btn" href="../../cp/pdf/MANUAL DE USUARIO.pdf" download="MANUAL DE USUARIO" style="background: -webkit-linear-gradient(#f01515, darkred) !important;color:white"><i class="fa fa-file-pdf"></i></a>
            </td>
        </tr>
        <tr>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
    </table>
</div>
<?php include(FOOTER_PATH); ?>