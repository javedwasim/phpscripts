<?php include_once('header.php'); ?>
<?php
/*
 * 
 * PRODUCT SECTION-----------------------------------------------
 * 
 */
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
                <div class="panel-footer text-center text-24">					
                    <strong>&nbsp;</strong>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">                               
                            <div>
                                
                                <?php
                                $PremiumLicensePurchased = false;
                                $StandardLicensePurchased = false;
                                if ($productObj->is_premium_license() > 0) {
                                    $PremiumLicensePurchased = true; //Set True
                                    ?>
                                    <p>
                                        <strong>Your current commission structure is 75% Tier 1 referral commissions on products owned.
                                        </strong>
                                    </p>
                                    <?php
                                } elseif ($productObj->is_standard_license() > 0) {
                                    $StandardLicensePurchased = true; //Set true  
                                    ?>
                                   <p class="text-center">
                                        <a href="https://sv287.infusionsoft.com/app/orderForms/23" target="_blank" class="btn btn-danger btn-lg">Upgrade your account license rights to Premium and get 75% of tier 1 and 10% of tier 2 referral commissions! </a>
                                    </p>
                                    <?php
                                } else {
                                    $PremiumLicensePurchased = false;
                                    $StandardLicensePurchased = false;
                                    ?>
                                    <p>It appears that you have generated signups for Step2Wealth, however your account 
                                        has not been credited your funds because you have not purchased the correct product license to receive your referral commission. 
                                        The following is a breakdown of the products you have generated sales for but have not received commission for, along with a way to purchase 
                                        the corresponding licenses for your account</p>
                                    
                                <?php } ?>
                            </div>                               
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>   
     <div class="row">	
       <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-footer text-center text-24">					
                    <strong> Products You’re Getting Commission For</strong>
                </div>
                <div class="panel-body">
                    <table id="unlockcommission_product" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>Purchase Status</th>
                                <th>Your Commission</th>
                                <th>Potential Commission</th>
                                <th>Forfeited Commission</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $product) {
                                $splan = $productObj->SubscriptionPlan($product['Id'])
                                ?>
                                <tr>
                                    <td><?php echo $product['Id']; ?></td>
                                    <td><?php echo $product['ProductName']; ?></td>
                                    <td class="text-center">
                                        <?php if (!in_array($product['Id'], $productSold)) { ?>
                                            <a href="#" class="btn btn-success btn-xs">
                                                <i class="fa fa-shopping-cart text-12"> </i> Buy Now
                                            </a>

                                        <?php } else { ?>
                                            <a class="btn btn-primary btn-xs">
                                                <i class="fa fa-dollar text-12"></i> Purchased
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>0%</td>
                                    <td>0%</td>
                                    <td>$0</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>	
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
    