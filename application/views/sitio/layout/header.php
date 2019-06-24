<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="JhumaDev">
  <title>JhumaShop</title>
  <link href="/public/sitio/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/public/sitio/css/shop-homepage.css" rel="stylesheet">
  <link href="/public/sitio/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <a class="navbar-brand" href="/">JhumaShop</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="fixed-top">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/index.php/inicio/preguntas">Preguntas Frecuentes (FAQ)</a>
      </li>
      
    </ul>
    <span class="navbar-text">
      <a href="/index.php/inicio/cart" style="color: blue;"><i class="fa fa-shopping-cart"></i></a>&nbsp;&nbsp;&nbsp;
      <?php if ($this->session->userdata('logueado')){  ?>
        Usuario:<strong><?php echo $this->session->userdata('name'); ?></strong>&nbsp;&nbsp;
        <a href="/index.php/inicio/pedidos">Pedidos</a>&nbsp;&nbsp;
        <a href="/index.php/inicio/cerrarsesion">Cerrar Session</a>
      <?php  }else{ ?>
        <a href="/index.php/inicio/ingreso">Ingreso</a>
      <?php }  ?>
    </span>
  </div>
</nav>