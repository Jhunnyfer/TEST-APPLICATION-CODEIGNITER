<div class="container">
   <div class="card shopping-cart">
   	<form action="/index.php/inicio/save_order" method="POST">
            <div class="card-header bg-dark text-light">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                Carrito de Compras
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                    <!-- PRODUCT -->
                    <?php $toProductsTo = 0; ?>
                    <?php foreach($products as $product):  ?>
                    <?php $toProductsTo += $product['precio']; ?>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-2 text-center">
                                <img width="100%" src="/public/products/<?php echo $product['img_ppla']; ?>" alt="">
                        </div>
                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                            <h4 class="product-name"><strong><?php echo $product['nombre']; ?></strong></h4>
                            <h4>
                                <small><?php echo $product['descripcion']; ?></small>
                            </h4>
                        </div>
                        <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                            <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                                <h6><strong>$<?php echo number_format($product['precio']); ?><span class="text-muted">x</span></strong></h6>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4">
                                <div class="quantity">
                                    <input name="products[]" type="hidden" value="<?php echo $product['id']; ?>" >
                                    <input name="qtys[]" type="number" step="1" max="1" readonly=""  min="1" value="1" title="Qty" class="qty"
                                           size="4">
                                    
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 text-right">
                                <button type="button" class="btn btn-outline-danger btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php endforeach; ?>
                    <!-- END PRODUCT -->
            </div>
            <div class="card-footer">
                
                <div class="pull-right" style="margin: 10px">
                    <?php if ($this->session->userdata('logueado')){  ?>
                    <button type="submit" class="btn btn-success pull-right">Guardar Pedido</button>
                    <?php }else{?> 
                    <a href="/index.php/inicio/ingreso" class="btn btn-success">Ingreso para guardar Pedido</a>
                    <?php } ?>
                    <div class="pull-right" style="margin: 5px">
                        Total: <b> $<?php echo number_format($toProductsTo); ?></b>
                    </div>
                </div>
            </div>
            </form>
        </div>
</div>

<br>
<br>
<br>