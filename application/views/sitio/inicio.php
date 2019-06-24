<div class="container bootstrap snipets">
   <h1 class="text-center text-muted">Perfumes Exclusivos</h1>
   <div class="row flow-offset-1">
    <?php foreach($products as $product):  ?>
     <div class="col-xs-6 col-md-4">
       <div class="product tumbnail thumbnail-3"><a href="#"><img width="100%" src="/public/products/<?php echo $product['img_ppla']; ?>" alt=""></a>
         <div class="caption">
           <h6 class="text-center"><a href="#"><?php echo $product['nombre']; ?></a></h6>
           <div class="price text-center">
             $<?php echo number_format($product['precio']); ?>
           </div>
         </div>
       </div>
     </div>
     <?php endforeach; ?>
   </div>
 </div>
 <br><br>
 