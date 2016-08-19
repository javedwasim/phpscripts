<?php include_once("header.php"); ?>
<?php
$productObj = new Products();
$productObj->setContact_id($userID);
$invoices = $productObj->get_invoice();
$productSold = array();
foreach ($invoices as $invoice) {
    $productSold[] = $invoice['ProductSold'];
}
$products = $productObj->get_product_detail();
?>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">
                    <table id="example2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="hidecol">Id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $product) {
                                $splan = $productObj->SubscriptionPlan($product['Id']);
                                ?>
                                <tr>
                                    <td class="hidecol"><?php echo $product['Id']; ?></td>
                                    <td><?php echo $product['ProductName']; ?></td>
                                    <td class="price-font"><?php
                                        if (!empty($splan)) {
                                            echo "$ " . $product['ProductPrice'] . "/month";
                                        } else {
                                            echo "$ " . $product['ProductPrice'] . " one time";
                                        }
                                        ?></td>
                                    <td class="tooltip-demo text-center">

                                        <a href="info/<?php echo $product['Id']; ?>" data-toggle="tooltip" class="btn btn-info btn-xs" data-placement="top" title="" data-original-title="Info" target = "blank">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!in_array($product['Id'], $productSold)) { ?>
                                            <a href="#" class="btn btn-success btn-xs">
                                                <i class="fa fa-shopping-cart text-12"></i> Buy Now
                                            </a>

                                        <?php } else { ?>
                                            <a class="btn btn-primary btn-xs">
                                                <i class="fa fa-dollar text-12"></i> Purchased
                                            </a>
                                        <?php } ?>
                                    </td>
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
