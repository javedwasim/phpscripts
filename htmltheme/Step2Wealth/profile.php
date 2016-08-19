
<?php include_once('header.php'); ?>

<!-- Main Wrapper -->

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-4">
            <div class="hpanel hgreen">
                <div class="panel-body">
                    <div class="pull-right text-right">
                        <div class="btn-group">
                            <i class="fa fa-facebook btn btn-default btn-xs"></i>
                            <i class="fa fa-twitter btn btn-default btn-xs"></i>
                            <i class="fa fa-linkedin btn btn-default btn-xs"></i>
                        </div>
                    </div>
                    <img alt="logo" class="img-circle m-b m-t-md" src="<?= $contactProfilePic ?>">
                    <h3><a href=""><?= $contaFullName; ?></a></h3>
                    <div class="text-muted font-bold m-b-xs">California, LA</div>

                </div>
                <div class="border-right border-left">

                </div>

                <div class="panel-footer contact-footer">
                    <div class="row">
                        <div class="col-md-4 border-right">
                            <div class="contact-stat"><span>Commission: </span> <strong>$1200</strong></div>
                        </div>
                        <div class="col-md-4 border-right">
                            <div class="contact-stat"><span>Slides Show: </span> <strong>20</strong></div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-stat"><span>Clicks: </span> <strong>10400</strong></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-8">
            <div class="hpanel">
                <div class="hpanel">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1">Account Info</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2">Payout Info</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3">Payout Schedule</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-4">My Billing Options</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal">

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-lg-6">
                                                    <label>Full Name</label>
                                                    <input type="text" value="<?= $contaFullName; ?>" id="" class="form-control" name="" placeholder="Full Name" name="fullName">
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Email Address</label>
                                                    <input type="email" value="<?= $currentUserEmail; ?>" id="" class="form-control" name="" placeholder="user@email.com" name="email">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <label>Address</label>
                                                    <input type="text" value="California, LA" id="" class="form-control" name="address" placeholder="Address">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-6">
                                                    <label>Username</label>
                                                    <input type="email" value="<?= $currentUserEmail; ?>" id="" class="form-control" name="username" placeholder="User Name">
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Password</label>
                                                    <input type="password" value="123456" id="" class="form-control" name="" placeholder="******" name="password">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <button class="btn btn-success btn-md">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                       
                                </form>
                            </div>
                        </div>

                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body no-padding">

                                <div class="panel-body">
                                    <form method="post" class="form-horizontal">

                                        <div class="form-group">
                                            <div class="col-lg-9">	
                                                <div class="radio radio-info radio-inline radio-success">
                                                    <input type="radio" id="payment" value="payment" name="PaymentMethod">
                                                    <label for="payment">Payment</label>
                                                </div>
                                                <div class="radio radio-info radio-inline radio-success">
                                                    <input type="radio" id="paypal" value="paypal" name="PaymentMethod">
                                                    <label for="paypal">Paypal</label>
                                                </div>
                                                <div class="radio radio-info radio-inline radio-success">
                                                    <input type="radio" id="wire" value="wire" name="PaymentMethod">
                                                    <label for="wire">Wire</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-lg-6">	
                                                <label></label>								
                                                <input type="" value="" id="" class="form-control" name="paymentAddress" placeholder="Payment Address">
                                            </div>	

                                        </div>
                                        <div class="form-group">
                                            <div class = "col-sm-8">
                                                <button class="btn btn-success btn-md">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body no-padding">

                                <div class="panel-body">
                                    <h3 class="text-success">PAYOUT SCHEDULE FOR 2016</h3>
                                    <ol type="i">
                                        <li>Step2Wealth pays out twice per month, on the 1st and 15th of each month.</li>
                                        <li>The payout is for the 15 day period made 30 days prior to the payout date. </li>
                                        <li>Sales Transactions times are based on UTC (London, UK Timezone).</li>
                                        <li>Please allow up to 2 business days within those dates to receive funds.</li>
                                        <li>All payouts will be sent through Payoneer.</li>
                                        <li>The Minimum Payout threshold is $100 (all total commissions lower than this amount will be rolled over to the 
                                            following payout period until the total reaches $100 or higher, then payment will be released).</li>
                                    </ol>
                                    <p>Here is the 2016 payout schedule:</p>
                                    <ol>
                                        <li>Jan 1   ->  Affiliates paid for Nov 15-30 sales</li>
                                        <li>Jan 15  ->  Affiliates paid for Dec 1-14 sales</li>
                                        <li>Feb 1 -> Affiliates paid for Dec 15-31 sales</li>
                                        <li>Feb 15 -> Affiliates paid for Jan 1-14 sales</li>
                                        <li>Mar 2 -> Affiliates paid for Jan 15-31 sales</li>
                                        <li>Mar 15 -> Affiliates paid for Feb 1-14 sale</li>
                                        <li>Apr 2 -> Affiliates paid for Feb 15-29 sales</li>
                                        <li>Apr 15 -> Affiliates paid for Mar 1-14 sales</li>
                                        <li>May 2 -> Affiliates paid for Mar 15-31 sales</li>
                                        <li>May 15 -> Affiliates paid for Apr 1-14 sales</li>
                                        <li>Jun 2 -> Affiliates paid for Apr 15-30 sales</li>
                                        <li>Jun 15 -> Affiliates paid for May 1-14 sales</li>
                                        <li>Jul 2 -> Affiliates paid for May 15-30 sales</li>
                                        <li>Jul 15 -> Affiliates paid for Jun 1-14 sales</li>
                                        <li>Aug 2 -> Affiliates paid for Jun 15-30 sales</li>
                                        <li>Aug 15 -> Affiliates paid for Jul 1-14 sales</li>
                                        <li>Sep 2 -> Affiliates paid for Jul 15-31 sales</li>
                                        <li>Sep 15 -> Affiliates paid for Aug 1-14 sales</li>
                                        <li>Oct 2 -> Affiliates paid for Aug 15-31 sales</li>
                                        <li>Oct 15 -> Affiliates paid for Sep 1-14 sales</li>
                                        <li>Nov 2 -> Affiliates paid for Sep 15-30 sales</li>
                                        <li>Nov 15 -> Affiliates paid for Oct 1-14 sales</li>
                                        <li>Dec 2 -> Affiliates paid for Oct 15-30 sales</li>
                                        <li>Dec 15 -> Affiliates paid for Nov 1-14 sales</li>
                                        <li>Jan 1 -> Affiliates paid for Nov 15-30 sales</li>
                                        <li>Jan 15 -> Affiliates paid for Dec 1-15 sales</li>
                                        <li>Feb 1 -> Affiliates paid for Dec 15-31 sales</li>

                                    </ol>
                                    
                                </div>


                            </div>
                        </div>

                        <div id="tab-4" class="tab-pane">
                            <div class="panel-body no-padding">

                                <div class="panel-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
