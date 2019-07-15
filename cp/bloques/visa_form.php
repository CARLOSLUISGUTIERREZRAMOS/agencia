<script type="text/javascript" src="../cp/pasarela/js/jquery-1.7.min.js"></script>
      <script type="text/javascript" src="../cp/pasarela/js/visa.js"></script>
      <!-- <form id="form_visa" action="../cp/pasarela/metodos_pago.php"> -->
      <form id="form_visa" action="../cp/pasarela/metodos_pago.php">
      <script src='<?=$libreriaJsVisa?>'
              data-sessiontoken='<?= $objSessionVisa->sessionKey ?>'
              data-channel='web'
              data-merchantid='<?= $visa->getCodigo_comercio() ?>'
              data-merchantlogo= 'https://www.starperu.com/es/img/Logotipo.png'
              data-formbuttoncolor='#f01515'
              data-purchasenumber= 1234567
              data-amount=127.05
              data-expirationminutes= 5
      >
      </script>
      </form>