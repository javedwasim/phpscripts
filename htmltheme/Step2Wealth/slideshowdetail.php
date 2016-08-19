<?php include_once('adminheader.php'); ?>

<!-- Main Wrapper -->

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">

                <div class="panel-body">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <form method="post" class="form-horizontal" action="">
                            <h3>TEST</h3>
                            <?php for ($i = 1; $i < 5; $i++) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?= $i ?>">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                                Slide <?= $i ?>										</a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?= $i ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $i ?>" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Slide Title
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="slidetitle1" id="slidetitle1" value="Slide <?= $i ?>">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Slide Content
                                                </label>
                                                <div class="col-sm-10">
                                                    <textarea name="slidecontent<?= $i ?>" id="slidecontent1" class="form-control">Description <?= $i ?></textarea>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Slide Picture</label>
                                                <div class="col-sm-10 lightBoxGallery">
                                                    <a href="" title="Image from Unsplash" data-gallery="" id="my_image_link1">
                                                        <img src="images/gallery/<?= $i; ?>.jpg" width="100%" height="350px"></a>
                                                </div>
                                            </div>	
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                            <div style="height:15px"></div>
                            <div class="form-group row clearfix">

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="url" id="url" value="" placeholder="http://localhost/?aff_id=123&offer_code=321">
                                </div>
                            </div>
                            <div class="form-group row clearfix">
                                <div class="col-sm-5">
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="">
                                        <label for="inlineRadio1"> Approve </label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                        <label for="inlineRadio2"> Declined </label>
                                    </div>
                                    <div class="radio radio-primary radio-inline">
                                        <input type="radio" id="inlineRadio3" value="option3" name="radioInline">
                                        <label for="inlineRadio2"> Inprocess</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <button class="btn btn-success btn-md" type="submit" name="submit">Update Slide Show</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>