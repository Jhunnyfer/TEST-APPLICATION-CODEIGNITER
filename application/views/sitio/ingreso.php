<div id="logreg-forms">
 <form class="form-signin" action="/index.php/inicio/login" method="POST">

  <?php if ($this->session->flashdata('msg')) { ?>
      <div class="alert alert-success"> <?= $this->session->flashdata('msg') ?> </div>
  <?php } ?>
  <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">INGRESO</h1>
  <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Correo Electronico" required="" autofocus="">
  <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required="">
  <button class="btn btn-success btn-block" type="submit">Ingresar</button>
  <hr>
  <!-- <p>Don't have an account!</p>  -->
  <a class="btn btn-primary btn-block" href="/index.php/inicio/registro"></i>Registro</a>
 </form>
 <br>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />