<?php
$page_title = 'Reporte de Entradas';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $results      = find_entradas_by_dates($start_date,$end_date);
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;

  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
  }
?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Reporte de salidas</title>
     <link rel="stylesheet" href="libs/css/bootstrap.min.css" />
   <style>
    .imprimir{
      width:90%;
      margin: 0 auto;
    }
    .no_imprimir{
      text-align:center;
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h3,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h3{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.sale-head h3,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }tfoot{
       color:#000;
       text-transform: uppercase;
       font-weight: 500;
     }
   @media print {
    .imprimir{
      margin:0;
    }
    .no_imprimir{
      display:none;
    }
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
      .sale-head.pull-right{
        
      }
    }
    
   </style>
</head>
<body>
  <?php if($results): ?>
    <div class="imprimir">
      <div class="pull-left">
        <img src="uploads\img\logo.jpg" alt="" style="width:100px;height:100px;margin-top:2em">
      </div>
       <div class="sale-head pull-right">
           <h3>Reporte de salidas</h3>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> a <?php if(isset($end_date)){echo $end_date;}?> </strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Fecha</th>
              <th>Descripción</th>
<!--               <th>Precio de compra</th>
              <th>Precio de salida</th> -->
              <th>Cantidad total</th>
              <!-- <th>TOTAL</th> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): ?>
           <tr>
              <td class=""><?php echo remove_junk(explode(" ",$result['fecha'])[0]);?></td>
              <td class="desc">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-right"><?php echo remove_junk($result['total_sales']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot style="display:none">
         <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1"> Total </td>
           <td> $
           <?php echo number_format(@total_price($results)[0], 2);?>
          </td>
         </tr>
         <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1">Utilidad</td>
           <td> $<?php echo number_format(@total_price($results)[1], 2);?></td>
         </tr>
        </tfoot>
      </table>
    </div>

    <div class="no_imprimir">
      <a class="btn btn-primary" onclick="window.print()">Imprimir</a>
      <a class="btn btn-secondary" href="/gustavo/admin.php">Volver</a>
    </div>
  <?php
    else:
        $session->msg("d", "No se encontraron salidas. ");
        redirect('sales_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
