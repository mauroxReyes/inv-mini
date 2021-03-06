<?php
  $page_title = 'Lista de productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <form method="post" action="products.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary" onclick="window.location='?producto='+document.querySelector('#sug_input').value;">Búsqueda</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="codigo"  placeholder="Buscar por codigo">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Agregar producto</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Imagen</th>
                <th> Descripción </th>
                <th class="text-center" style="width: 10%;"> Categoría </th>
                <th class="text-center" style="width: 10%;"> Existencias </th>
                <th class="text-center" style="width: 10%;"> Lote</th>
<!--                 <th class="text-center" style="width: 10%;"> Precio de compra </th>
                <th class="text-center" style="width: 10%;"> Precio de venta </th> -->
                <th class="text-center" style="width: 10%;"> Agregado </th>
                <th class="text-center" style="width: 10%;"> Vence </th>
                <th class="text-center" style="width: 100px;"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
                <?php if( (isset($_GET['producto']) && remove_junk($product['codigo'])==$_GET["producto"]) || !isset($_GET['producto']) ){
                ?>
                
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> 
                  <?php echo remove_junk($product['name']); ?>
                  <br>
                  <?php echo remove_junk($product['codigo']); ?>  
                  </td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center" style="background:<?php
                  $cantidad=remove_junk($product['quantity']);
                  if($cantidad < 5 && $cantidad > 3){
                    echo("#e7ef68");
                  }
                  if($cantidad<=1){
                    echo("#e74646");
                  }

                ?>"> <?php echo remove_junk($product['quantity']); ?></td>
                <td class="text-center"><?php echo remove_junk($product['lote']); ?></td>
<!--                 <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td> -->
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center" style="background:<?php

                  if(make_date() >= read_date($product['fecha_vencimiento'])){
                    echo("red;color:black");
                  }else{
                    echo("green;color:white");
                  }


                ?>"> <?php echo read_date($product['fecha_vencimiento']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php }?>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
