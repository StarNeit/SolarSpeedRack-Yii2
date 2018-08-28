<?php
use yii\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = "Products with Invalid Data";
?>
<div class="row">
<?php    
foreach ($all as $cat) {
    echo '<div class="col-md-12"><h1>' . $cat['cname'] . ' (' . count($cat['products']) . ')</h1></div>';
    foreach ($cat['products'] as $product) { ?>
        <div class="col-md-2"><p><?= Html::a($product['product_id'], ['update', 'id'=>$product['product_id']], ['class'=>'btn btn-info', 'target'=>'_blank']) ?></p></div>
    <?php    
    }
}
?>

</div>
