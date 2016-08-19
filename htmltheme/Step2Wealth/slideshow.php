<?php include_once('header.php'); ?>
<?php
$slideshow_obj = new SlideShows();
$slide_obj = new Slides();
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
                                <p>Step2Wealth will pay you to create viral content for slideshows! 
                                    The more viral your content becomes, the more money you will earn. Your current commission rate is $2 per 1000 slide views.</p>

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

                <div class="panel-body">
                    <div class="text-center m-b-md">

                        <form method="post" id="slideshowFrm" name="slideshowFrm" class="form-horizontal" action="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    Slide Show Title
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="slideshow_title" id="slideshow_title" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    Number of slides
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="numberofslides" id="numberofslides" 
                                           value="" onkeypress="return isNumber(event)" maxlength="4" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <input type="hidden" name="slideshowFrmSubmit" id="slideshowFrmSubmit" value="slideshowFrmSubmit" />
                                    <button id="save_slideshow_btn" class="btn btn-success btn-md" type="button" name="submit" onclick="CreateSlideShow();">Create Slide Show</button>
                                    <br /><?= spanner_loder(1); ?>
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <div class="col-sm-8 col-sm-offset-2">

                                    <?= msg_box(1) ?>
                                    <?= success_message(1) ?>
                                </div>    
                            </div>
                        </form>

                    </div>
                    <div class="panel-group display-none" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php // data come from slides.php using ajax request-------------------?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix" id="existing_slide">
        <?php
        $slideshow_obj->setContactId($userID);
        $getLatestSlideShows = $slideshow_obj->getLatestSlideShows();
        
        ?>
        <div class="col-lg-12 text-center m-t-md">
            <h2>Existing Slidesshow</h2>
            <p>&nbsp;</p>
        </div>
        <?php 
        if($database->num_rows($getLatestSlideShows) > 0){
        while ($row = $database->fetch_array($getLatestSlideShows)) { 
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
        <?php } //end of LOOP
        }else{
        ?>
        <div class="col-lg-12 m-t-md">
        <div id="msg_box" class="alert alert-info">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div>Currently no existing slidesshow!</div>
                </div>
        </div>    
        <?php } ?>
    </div>
    <div class="row clearfix">

        <div class="pull-right m-b-md">

            <a href="existingslideshow.php" class="btn btn-outline btn-info">View all my slideshows</a>
        </div>
    </div> 
</div>
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<?php include_once('footer.php'); ?>