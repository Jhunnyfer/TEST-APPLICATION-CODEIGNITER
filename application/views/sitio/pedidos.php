<div class="container bootstrap snipets">
 <h1 class="text-center text-muted">Pedidos</h1>
 <div class="row flow-offset-1">
  <table class="table">
   <thead>
    <tr>
     <th scope="col">Total</th>
     <th scope="col">Estado</th>
     <th scope="col">Fecha</th>
     <th scope="col">#</th>
    </tr>
   </thead>
   <tbody>
   
    <?php foreach($pedidos as $pedido):  ?>
    <tr>
     <td>$<?php echo number_format($pedido['total_pedido']); ?></td>
     <th scope="col">Total</th>
     <td><?php echo $pedido['fecha_pedido']; ?></td>
     <td><a class="btn  btn-success" href="/index.php/inicio/detalle_pedido/<?php echo $pedido['referencia']; ?>">Detalle</a></td>
    </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 </div>
</div>