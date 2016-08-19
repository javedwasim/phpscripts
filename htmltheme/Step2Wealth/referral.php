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
                    <strong> YOUR UNIQUE REFERRAL LINK </strong>
                </div>
                <div class="panel-body">
                    <div class="col-lg-3"></div>					 
                    <div class=" col-lg-6 text-center">                                           
                        <input type="text" value="" id="" class="form-control" name="" placeholder="http://click2wealth.com/referral?id=123" name="referralLink">
                    </div>
                    <div class="col-lg-3"><a href="javascript:;" class="btn btn-fb "><i class="fa fa-facebook"></i>  Share</a></div>
                </div>	
            </div>	
        </div>
    </div>
    <div class="row">	
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-footer text-center text-24">					
                    <strong> REFERRALS</strong>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">                               
                            <div>
                                <p>One of the easiest ways of making money using Step2Wealth is to refer other users to use the platform. Pending on your product rights, you can earn anywhere from 40-75% on tier 1 referrals and up to 10% on tier 2 referrals!</p>
                                <?php
                                $PremiumLicensePurchased = false;
                                $StandardLicensePurchased = false;
                                if ($productObj->is_premium_license() > 0) {
                                    $PremiumLicensePurchased = true; //Set True
                                    ?>
                                    <p>
                                        <strong>Your current commission structure is 75% Tier 1 referral commissions on products owned and 10% on Tier 2 referral commissions.
                                        </strong>
                                    </p>
                                    <?php
                                } elseif ($productObj->is_standard_license() > 0) {
                                    $StandardLicensePurchased = true; //Set true  
                                    ?>
                                    <p>
                                        <strong>Your current commission structure is 40% Tier 1 referral commissions on products owned and 0% on Tier 2 referral commissions.
                                        </strong>
                                    </p>
                                    <p class="text-center">
                                        <a href="https://sv287.infusionsoft.com/app/orderForms/23" target="_blank" class="btn btn-danger btn-lg">Upgrade your account license rights to Premium and get 75% of tier 1 and 10% of tier 2 referral commissions! </a>
                                    </p>
                                    <?php
                                } else {
                                    $PremiumLicensePurchased = false;
                                    $StandardLicensePurchased = false;
                                    ?>
                                    <p class="text-center">
                                        <a href="https://sv287.infusionsoft.com/app/orderForms/7" class="btn btn-danger btn-lg" target="_blank">Purchase Standard license rights and get 40% of tier 1 and 0% of tier 2 referral commissions!</a>
                                    </p>
                                    <p class="text-center">
                                        <a href="https://sv287.infusionsoft.com/app/orderForms/23" target="_blank" class="btn btn-info btn-lg">Purchase Premium license rights to Premium  and get 75% of tier 1 and 10% of tier 2 referral commissions!</a>
                                    </p>
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
                    <table id="referral_product" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>&nbsp;</th>
                                <th>Price</th>
                                <th>Your Commission &percnt;</th>
                                <th>Potential Commission &percnt;</th>
                                <th>Purchase Status</th>
                                <th>Info</th>

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
                                    <td class="tooltip-demo"><a href="#" data-toggle="tooltip" class="btn btn-info btn-xs" data-placement="top" title="" data-original-title="Info">
                                            <i class="fa fa-info-circle"></i>
                                        </a></td>
                                    <td class="price-font" width="15%"><?php
                                        if (!empty($splan)) {
                                            echo "$ " . $product['ProductPrice'] . "/month";
                                        } else {
                                            echo "$ " . $product['ProductPrice'] . " one time";
                                        }
                                        ?>
                                    </td>
                                    <td>0</td>
                                    <td>0</td>
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
                                    <td>

                                        <?php if (in_array($product['Id'], $productSold)) { ?>
                                            <?php
                                            if ($PremiumLicensePurchased == true || $StandardLicensePurchased == true) {
                                                if ($PremiumLicensePurchased == true) {
                                                    echo '<span class="text-info">You are receiving full commission for this product.</span>';
                                                } elseif ($StandardLicensePurchased == true) {
                                                    echo '<span class="text-success">You can double your commission for this product and earn tier 2 commission if you purchase the Premium  license rights.</span>';
                                                }
                                                ?>
                                            <?php } else { ?>
                                                <span class="text-danger  font-bold">
                                                    You must purchase affiliate package for this product to receive commission for it.
                                                </span>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <span class="text-warning font-bold">You must purchase this product to receive commission for it.</span>
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
    <div class="row">
        <div class="col-lg-4">
            <div class="hpanel">
                <div class="panel-footer text-center text-16">
                    <strong>Total Referral Commission</strong>
                </div>
                <div class="panel-body text-center h-150">	
                    <h3 class="font-extra-bold m-xs text-success text-60">$100,000</h3>	
                    <a href="stats.php" class="btn btn-outline btn-info">View Breakdown</a>
                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="hpanel">
                <div class="panel-footer text-center text-16">
                    <strong>Months Referral Commission</strong>
                </div>
                <div class="panel-body text-center h-150">	
                    <h3 class="font-extra-bold m-xs text-success text-60">$100,000</h3>	

                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="hpanel">
                <div class="panel-footer text-center text-16">
                    <strong>Total Forfeited Commission </strong>
                </div>
                <div class="panel-body text-center h-150">	
                    <h3 class="font-extra-bold m-xs text-danger text-60 ">$50,000.00</h3>	
                    <div>
                        <h5 class="text-center"> You Missed that Amount of Money</h5>
                    </div>
                    <div>
                        <h6 class="text-center">
                            <a href="unlockcommission.php"> <i class="fa fa-unlock"></i>
                                Unlock This Commission</a></h6>
                    </div>					
                </div>

            </div>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
    