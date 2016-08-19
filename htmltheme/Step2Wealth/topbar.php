<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            <img src="images/step2wealthlogo.jpg" alt="profile-picture" width="140" height="25">
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary"><img src="images/step2wealthlogo.jpg" alt="profile-picture" width="140" height="25"></span>
        </div>
        <form role="search" class="navbar-form-custom" method="post" action="#" _lpchecked="1">
            <div class="form-group">
                <h3 class="mt-15 text-success"><?php echo $contaFullName; ?></h3>

            </div>
        </form>
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li><a class="" href="<?php if ($contactGlobalObj->isIsAdmin($userID)) {?>adminprofile.php<?php } else {?>profile.php<?php }?>">Profile</a></li>
                    <li>
                        <?php if ($contactGlobalObj->isIsAdmin($userID)) { ?>
                            <a class="" href="adminlogout.php">Logout</a>
                        <?php } else { ?>
                            <a class="" href="logout.php">Logout</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
           
                    <div class="bigmenu animated flipInX bigmenu_dup">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="<?php if ($contactGlobalObj->isIsAdmin($userID)) {?>adminprofile.php<?php } else {?>profile.php<?php }?>">
                                            <i class="pe pe-7s-user text-info"></i>
                                            <h5>Account</h5>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php if ($contactGlobalObj->isIsAdmin($userID)) {?>adminlogout.php<?php } else {?>logout.php<?php } ?>">
                                            <i class="pe pe-7s-power text-danger"></i>
                                            <h5>Logout</h5>
                                        </a>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
              
        </div>

    </nav>
</div>