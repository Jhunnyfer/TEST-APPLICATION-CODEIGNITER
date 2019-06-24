<?php //var_dump(); ?>
<div class="container bootstrap snipets">
 <h1 class="text-center text-muted">Detalle Pedido</h1>
 <table class="table table-bordered">
  <tbody>
   <tr>
    <td>
     <strong>Fecha:</strong>
    </td>
    <td>
     <?php echo $pedido[0]['fecha_pedido']; ?>
    </td>
   </tr>
   <tr>
    <td>
     <strong>Total:<strong>
    </td>
    <td>
     $
     <?php echo number_format($pedido[0]['total_pedido']); ?>
    </td>
   </tr>


    <?php if(@$ultimo[0]["estado"]== 'PENDING' || @$ultimo[0]["estado"]=='APPROVED'){ ?>
       
    <?php }else{?>
      <tr>
    <td>
     <strong>&nbsp;<strong>
    </td>
    <td>
     <form action="/index.php/pago/pago_basico" method="POST" >
       <input type="hidden" name="reference" value="<?php echo $pedido[0]['referencia']; ?>" >

       <button type="submit" name="btn_pagar">
<img src="https://dev.placetopay.com/web/wp-content/uploads/2019/02/p2p-logo.svg" width="200px" class="attachment-120x120 size-120x120" alt="">
</button>
<br/> 
        <input type="checkbox" value="1" required="" name="chk_terminos">Acepta Terminos y Condiciones?
        <br/>   
        <a href="#" data-remote="false" data-toggle="modal" data-target="#myModal">Terminos y Condiciones</a>
     </form>
    </td>
    </tr>

    <?php } ?>
   

  </tbody>
 </table>
 <br>
 <br>

 <table id="dataTable" cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
  <thead class="thead-dark">
   <tr>
    <th>
     <strong>Imagen</strong>
    </th>
    <th>
     <strong>Nombre</strong>
    </th>
    <th>
     <strong>Precio</strong>
    </th>
    <th>
     <strong>Cantidad</strong>
    </th>
   </tr>
  </thead>
  <tbody>
   <?php $toProducts = 0; ?>
   <?php $toProductsTo = 0; ?>
   <?php foreach ($detalle as $row): ?>
   <tr>
    <td>
     <img src="/public/products/<?php echo $row['img_ppla']; ?>" height="75px">
    </td>
    <td width="45%">
     <?php echo $row['nombre']; ?>
    </td>
    <td>
     $
     <?php echo number_format($row['precio']); ?>
     <?php $toProductsTo += $row['precio']; ?>
    </td>
    <td>
     <?php echo $row['cantidad']; ?>
     <?php $toProducts += $row['cantidad']; ?>
    </td>
   </tr>
   <?php endforeach; ?>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Cantidad Total</strong></td>
    <td>
     <strong>
      <?php echo $toProducts; ?></strong>
    </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    <td>
     <strong>$
      <?php echo number_format($toProductsTo); ?></strong>
    </td>
   </tr>
  </tbody>
 </table>

 <h2 class="text-center text-muted">Pagos</h2>

  <table id="dataTable" cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
  <thead class="thead-dark">
   <tr>
    <th>
     <strong>Fecha</strong>
    </th>
    <th>
     <strong>Estado</strong>
    </th>
   </tr>
  </thead>
  <tbody>
   <?php foreach ($pagos as $row): ?>
   <tr>
    <td>
      <?php echo ($row["fecha"]); ?>
    </td>
    <td>
      <?php echo ($row["estado"]); ?>
    </td>
    
   </tr>
   <?php endforeach; ?>

  </tbody>
 </table>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">TERMINOS Y CONDICIONES</h4>
        </div>
        <div class="modal-body">
            Cualquier persona que realice un compra en el sitio http://127.0.0.1/, actuando libre
        y voluntariamente, autoriza a JhumaShop, a través del proveedor del servicio
        EGM Ingeniería Sin Fronteras S.A.S y/o Place to Pay para que consulte y solicite
        información del comportamiento crediticio, financiero, comercial y de servicios a
        terceros, incluso e
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
</div>