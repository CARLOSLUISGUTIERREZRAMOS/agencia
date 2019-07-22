<?php
    require_once("../../../config.php");
    // var_dump($url);die;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Aerolíneas StarPerú</title>
    <link rel="stylesheet" href="https://www.starperu.com/es/css/bootstrap.css">
    <link rel="stylesheet" href="https://www.starperu.com/es/css/font-awesome.css">
    <link rel="stylesheet" href="https://www.starperu.com/es/css/main.css">
    <!-- <meta http-equiv="refresh" content="3; url=https://www.starperu.com/agencias/"> -->
    <meta http-equiv="refresh" content="1; url=<?= $url?>/cp/panel.php">
    <link rel="stylesheet" href="https://www.starperu.com/es/css/app/error.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin">
        <img class="mb-4" src="https://www.starperu.com/es/img/logotipo2.png" alt="">
        <h1 class="h3 mb-3 font-weight-normal">La sesión caducó.</h1>

        <p class="mt-5 mb-3 text-muted">Visa</p>
    </form>
</body>

</html>