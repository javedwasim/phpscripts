<?php

require_once("includes/initialize.php");
$CreatedDate = date('Y-m-d', time());
extract(getHttpVars());
//Define Objects of classes
$contact_obj    =   new Contacts(); 
$db_obj         =   new steptowealthDb();
$slideshow_obj  =   new SlideShows();
$slide_obj      =   new Slides();
//------------------------------------------------------------------------------
if (isset($_REQUEST['submit_searching']) && $_REQUEST['submit_searching'] == 'submit_searching') {
    $firstname = trim($_REQUEST['firstname']);
    $lastname= trim($_REQUEST['lastname']);
    $email= trim($_REQUEST['email']);
    //$contact_obj->setContactFirstName($contactFirstName);
    //$contact_obj->setContactLastName($contactLastName);
    //$contact_obj->setContactEmail($email);
    $allIsMembers = $contact_obj->contactsFiler($firstname,$lastname,$email);
   ?>

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
                                <li class=""><a href="memberslideshow.php"><i class="fa fa-desktop text-primary-2"></i>View Slides Show</a></li>
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
        else{
              echo '<div class="alert alert-danger msg_box">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div class="msg_err">No result found ! </div>
              		</div>';
              die();
            if(!empty($firstname) && !empty($email)){
               echo '<div class="alert alert-danger msg_box">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div class="msg_err">There are no record with '.$firstname.' and '.$email.' .</div>
              		</div>';
            }else if(!empty($firstname)){
               echo '<div class="alert alert-danger msg_box">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div class="msg_err">No record found with the name '.$firstname.' .</div>
              		</div>';
            }else if(!empty($email)){
               echo '<div class="alert alert-danger msg_box">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div class="msg_err">No record found with the email '.$email.' .</div>
              		</div>';
            }
            
        }
        ?>
<?php
}//end of if (isset($_POST['submit_searching']) && $_POST['submit_searching'] == 'submit_searching') {



if (isset($_REQUEST['submit_slide_frm']) && $_REQUEST['submit_slide_frm'] == 'submit_slide_frm'){
   
    $slideshow_obj->setSlideShowTitle($slideShowTitle);
    $slideshow_obj->setContactId($session->User_ID);
    $slideshow_obj->setSlideShowStatus("Pending");
    $slideshow_obj->setCreatedTime(CURRENT_DATE_TIME);
    $slideshow_obj->setCommissionPerClick("0");
    $slideShowId = $db_obj->create($slideshow_obj,$slideShow_tbl);
    $slide_obj->setSlideShowId($slideShowId);
    for ($i = 1; $i <= $number_ofslides; $i++) {
        allowed_file_type($_FILES['slidePicture_'.$i]['type']); //Check valid file type
        $slidePicture = generateUniqueName($_FILES['slidePicture_'.$i]['name']);
        upload_pic($_FILES['slidePicture_'.$i]['tmp_name'],$slidePicture);
        $slide_obj->setSlideTitle($_REQUEST['slideTitle_'.$i]);
        $slide_obj->setSlideContent($_REQUEST['slideContent_'.$i]);
        $slide_obj->setSlidePicture($slidePicture);
        $slide_obj->setCreatedTime(CURRENT_DATE_TIME);
        $slide_obj->setSlideStatus(1);
        $db_obj->create($slide_obj, $slides_tbl);
    }
    if($slideShowId > 0){
        echo '<div class="alert alert-success">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div>Total '.$number_ofslides.' slide(s) saved successfully.</div>
              		</div>';
    }else{
        echo '<div class="alert alert-danger msg_box">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div>There is problem while saving slides.</div>
              </div>';
    }

}//end of if (isset($_REQUEST['submit_slide_frm']) && $_REQUEST['submit_slide_frm'] == 'submit_slide_frm'){
if(isset($_REQUEST['update_existing_slide_view']) && $_REQUEST['update_existing_slide_view']=='update_existing_slide_view'){
    ?>
       <?php
        $slideshow_obj->setContactId($session->User_ID);
        $getLatestSlideShows = $slideshow_obj->getLatestSlideShows();
        
        ?>
        <div class="col-lg-12 text-center m-t-md">
            <h2>Existing Slideshow</h2>
            <p>&nbsp;</p>
        </div>
        <?php while ($row = $database->fetch_array($getLatestSlideShows)) { 
            if($row['slideShowStatus']==="Pending"){
                 $status_cls = "text-gray";
            }else if($row['slideShowStatus']==="Approved"){
                $status_cls = "text-success";
            }else if($row['slideShowStatus']==="InProcess"){
                 $status_cls = "text-info";
            }else if($row['slideShowStatus']==="Declined"){ 
                 $status_cls = "text-danger";
            }else{
                $status_cls ="";
            }
            //Get first Slide Img
            $slide_obj->setSlideShowId($row['slideShowId']);
            $slideRow = $slide_obj->getFirstSlide();
           ?>
        <div class="col-md-3">
            <div class="hpanel">
                <div class="panel-body">
                    <div class="text-center">
                        <h2 class="m-b-xs">Slide title</h2>
                        <p class="font-bold text-success"><?=$row['slideShowTitle']?></p>
                        <div class="m">
                            <img class="m-b" alt="logo" src="<?=$slide_obj->slide_pic_url($slideRow['slidePicture']);?>"width="188" height="150">
                        </div>
                        <p class="font-bold">Status: <span class="<?=$status_cls?>"><?=$row['slideShowStatus']?></span></p>
                        <p class="font-bold">Total Commission Earned $ <?=isset($row['CommissionPerClick'])?$row['CommissionPerClick']:"0";?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php } //end of LOOP?>
<?php }
?>
