<?php
include_once('adminheader.php');
$contact_obj = new Contacts();
$allIsMembers = $contact_obj->getAllIsMembers();
//beutifyArray($allIsMembers);
?>
<div class="content animate-panel">
    <div class="row">
        <div class="hpanel">
            <div class="panel-body">
                <h3>Search</h3>
                <div class="form-group row clearfix">
                    <form name="search_member" id="search_member" method="post" action="">
                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="First Name" />
                        </div>
                         <div class="col-sm-3">
                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Last Name" />
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="email" id="email" placeholder="email" />
                        </div>
                        <div class="col-sm-3">
                            <input type="hidden" name="submit_searching" id="submit_searching" value="submit_searching" />
                            <button type="button" class="btn btn-success" onclick="SearchMember();"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>

    </div>
    <div class="row">
        <div  class="pos_relative">
            <div id="search_laoder" class="display-none">
                <img src="images/loading-bars.svg" width="80" height="80" /> 
            </div>
        </div>
        <div id="membersBox">
        <?php
        if (!empty($allIsMembers)) {
            $counter = 1;
            foreach ($allIsMembers as $member) {
                if ($counter % 2 == 0) {
                    $cls = "hviolet";
                } else {
                    $cls = "hblue";
                }
                $user_login = base64url_encode($member['Email']);
                $user_pass = base64url_encode($member['Password']);
                ?>
                <div class="col-lg-4">
                    <div class="hpanel <?= $cls ?> contact-panel">
                        <div class="panel-body cs_height">
            <!--                <span class="label label-success pull-right">NEW</span>-->
                            <img alt="logo" class="img-circle m-b" src='<?= isset($member["_ProfileImage"]) ? $member["_ProfileImage"] : "profileimg/no-profile.png" ?>'>
                            <h3><a href="javascript:;"> <?= isset($member["FirstName"]) ? $member["FirstName"] : "" ?> <?= isset($member["LastName"]) ? $member["LastName"] : "" ?> </a></h3>
                            <div class="text-muted font-bold m-b-xs"><?= isset($member["StreetAddress1"]) ? $member["StreetAddress1"] : "&nbsp" ?></div>
                            <ul class="h-list m-t">
                                <li class=""><a href="#"><i class="fa fa-cog text-info"></i> Settings</a></li>
                                <li class=""><a href="memberslideshow.php?member_id=<?=base64url_encode($member["Id"])?>"><i class="fa fa-desktop text-primary-2"></i>View Slides Show</a></li>
                                <form method="post" action="directlogin.php" target="_blank" name="directlogin_<?= $counter ?>"id="directlogin_<?= $counter ?>">
                                    <input type="hidden" name="permission" value="<?= $user_login ?>" />
                                    <input type="hidden" name="token" value="<?= $user_pass ?>" />
                                </form>
                                <li class="">
                                    <a href="javascript:;"  onclick='document.getElementById("directlogin_<?= $counter ?>").submit();'><i class="fa fa-key text-success"></i> Login</a></li>
                            </ul>
                        </div>
                        <div class="panel-footer contact-footer">
                            <div class="row">
                                <div class="col-md-4 border-right"> <div class="contact-stat"><span>COMMISSION: </span> <strong>$200</strong></div> </div>
                                <div class="col-md-4 border-right"> <div class="contact-stat"><span>SLIDES SHOW: </span> <strong>10</strong></div> </div>
                                <div class="col-md-4"> <div class="contact-stat"><span>CLICKS: </span> <strong>400</strong></div> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $counter++;
            }//End of loop
        }//end of if(!empty($allIsMembers)){ 
        ?>
        </div>
        

    </div>


</div>




<?php include_once('footer.php'); ?>
    