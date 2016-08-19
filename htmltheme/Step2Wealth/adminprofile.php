
<?php include_once('adminheader.php'); ?>

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
                    <img alt="logo" class="img-circle m-b m-t-md" src="<?=$contactProfilePic?>">
                    <h3><a href=""><?=$contaFullName;?></a></h3>
                    <div class="text-muted font-bold m-b-xs">California, LA</div>

                </div>
                <div class="border-right border-left">

                </div>

<!--                <div class="panel-footer contact-footer">
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
                </div>-->

            </div>
        </div>
        <div class="col-lg-8">
            <div class="hpanel">
                <div class="hpanel">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1">Account Info</a></li>
                        		
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
                                                    <input type="text" value="<?=$contaFullName;?>" id="" class="form-control" name="" placeholder="Full Name" name="fullName">
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Email Address</label>
                                                    <input type="email" value="<?=$currentUserEmail;?>" id="" class="form-control" name="" placeholder="user@email.com" name="email">
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
                                                    <input type="email" value="<?=$currentUserEmail;?>" id="" class="form-control" name="username" placeholder="User Name">
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
                      
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
