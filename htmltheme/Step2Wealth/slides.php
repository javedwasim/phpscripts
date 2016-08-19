<?php
require_once("includes/initialize.php");
$CreatedDate = date('Y-m-d', time());
extract(getHttpVars());
$contact_obj = new Contacts(); // obj------------------------
if (isset($_REQUEST['slideshowFrmSubmit']) && $_REQUEST['slideshowFrmSubmit'] == 'slideshowFrmSubmit') {
    ?>
<form method="post" id="slides_frm" id="slides_frm" class="form-horizontal" action="ajax.php" enctype="multipart/form-data">
        <h3><?php echo $slideshow_title; ?>
            <input type="hidden" name="slideShowTitle" id="slideShowTitle" value="<?= trim($slideshow_title) ?>" />
        </h3>

        <?php
        $warning_msg = "";
        if($numberofslides > 10){ // ALOWED 10 Slide At A time
            $numberofslides = 10;
            $warning_msg = "At a time only 10 slides you can save";
        } else{
            $numberofslides = $numberofslides;
        }      
        for ($i = 1; $i <= $numberofslides; $i++) {
            ?>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" id="slide_ancher_<?php echo $i; ?>" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo "Slide " . $i ?>
                        </a>
                    </h4>
                </div>
                <div id="collapse<?php echo $i; ?>" class="panel-collapse <?php
                if ($i == 1) {
                    echo "collapse in";
                } else {
                    echo "collapse";
                }
                ?>" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>" >
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Slide Title
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="<?= "slideTitle_" . $i; ?>" id="<?php echo "slideTitle_" . $i; ?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Slide Content
                            </label>
                            <div class="col-sm-10">
                                <textarea name="<?php echo "slideContent_" . $i; ?>" id="<?php echo "slideContent_" . $i; ?>" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Upload Picture</label>
                            <div class="col-sm-10">
                                <input id="uploadFile<?php echo $i; ?>" placeholder="Choose File" disabled="disabled" class="form-control" />
                                <div class="fileUpload btn btn-primary">
                                    <span>Upload</span>
                                    <input type="file" name="slidePicture_<?php echo $i; ?>" id="slidePicture_<?php echo $i; ?>" class="upload" onclick="fileupload(<?php echo $i; ?>);" />
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="form-group display-none" id="img_err_box_<?php echo $i; ?>">
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-10">
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <div id="img_err_<?php echo $i; ?>"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="" id="slidepicdiv<?php echo $i; ?>">
                            <label class="col-sm-2 control-label">Slide Picture</label>
                            <div class="col-sm-10 lightBoxGallery">
                                <a href="" title="Image from Unsplash" data-gallery="" id="my_image_link<?php echo $i; ?>">
                                    <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22330%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20330%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15216c402fa%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15216c402fa%22%3E%3Crect%20width%3D%22800%22%20height%3D%22330%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22100.6484375%22%20y%3D%22182.7%22%3ESlide%20Picture%20Goes%20here%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-src="holder.js/800x330?text=Slide Picture Goes here" alt="Slide Picture Goes here [800x330]" data-holder-rendered="true" 
                                         style="width: 800px; height: 330px;" id='my_image<?php echo $i; ?>'>
                                </a>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>

        <?php } ?>
        <div style= "height:15px"></div>
        <?php if ($numberofslides > 0) { ?>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-5">
                    <input type="hidden" name="submit_slide_frm" id="submit_slide_frm" value="submit_slide_frm" />
                    <input type="hidden" name="number_ofslides" id="number_ofslides" value="<?=$numberofslides?>" />
                    <button id="save_slides_btn" class="btn btn-success btn-md" type="button" name="save" onclick="saveSlide('<?= $numberofslides ?>');">Save Slide Show</button>
                    <br /><?=spanner_loder(2); ?>
                </div>
            </div>
        <?php } ?>
        <div class="form-group text-left">
            <div class="col-sm-8 col-sm-offset-2">
                <?php if(!empty($warning_msg)){?>
                <div id="msg_box" class="alert alert-warning">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div><?=$warning_msg?></div>
                </div>
                <?php } ?>
                <?=msg_box(2) ?>
                <div id="ResponseBox"></div>
            </div>    
        </div>
    </form>
    <?php
} // end of if (isset($_REQUEST['slideshowFrmSubmit']) && $_REQUEST['slideshowFrmSubmit'] == 'slideshowFrmSubmit') {?>