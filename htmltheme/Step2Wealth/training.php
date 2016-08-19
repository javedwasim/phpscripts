<?php include_once("header.php"); ?>
<?php
$productObj = new Products();
$productObj->setContact_id($userID);
$invoices = $productObj->get_invoice();
$productSold = array();
foreach ($invoices as $invoice) {
    $productSold[] = $invoice['ProductSold'];
}
if (!empty($productSold)) {
    $_SESSION['purchasedprod'] = $productSold;
} else {
    $_SESSION['purchasedprod'] = "";
}
//print_r($_SESSION['purchasedprod']);
$products = $productObj->get_product_detail();
?>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">
                    <table id="training" class="display table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="hidecol">Id</th>
                                <th>Name</th>
                                <th style = "display:none;">Price</th>
                                <th class="hidecol">&nbsp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $product) {
                                $splan = $productObj->SubscriptionPlan($product['Id']);
                                if($product['Id']==7 || $product['Id']==23){ 
                                    //Skip Affiliate Fee (Standard) and Full License Rights (Premium).
                                    continue;
                                }
                                
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td class="hidecol"><?php echo $product['Id']; ?></td>
                                    <td><?php echo $product['ProductName']; ?></td>
                                    <td class="price-font" style = "display:none;"><?php
                                        if (!empty($splan)) {
                                            echo "$ " . $product['ProductPrice'] . "/month";
                                        } else {
                                            echo "$ " . $product['ProductPrice'] . " One Time";
                                        }
                                        ?></td>
                                    <td class="hidecol">&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("footer.php"); ?>	
