<?php
include_once('adminheader.php');
$slideshow_obj = new SlideShows();
$slide_obj = new Slides();
$db_obj = new steptowealthDb();
if (isset($_REQUEST['member_id']) && !empty($_REQUEST['member_id'])) {
    $memberSlidshows = $db_obj->getAllRecordsByCol($slideShow_tbl, "contactId", base64url_decode($_REQUEST['member_id']));
} else {
    $memberSlidshows = $db_obj->getAllRecord($slideShow_tbl);
}
?>
<div class="content animate-panel">
    <div class="row">
        <?php
        if ($database->num_rows($memberSlidshows) > 0) {
            while ($row = $database->fetch_array($memberSlidshows)) {
                if ($row['slideShowStatus'] === "Pending") {
                    $status_cls = "text-gray";
                } else if ($row['slideShowStatus'] === "Approved") {
                    $status_cls = "text-success";
                } else if ($row['slideShowStatus'] === "InProcess") {
                    $status_cls = "text-info";
                } else if ($row['slideShowStatus'] === "Declined") {
                    $status_cls = "text-danger";
                } else {
                    $status_cls = "";
                }
                //Get first Slide Img
                $slide_obj->setSlideShowId($row['slideShowId']);
                $slideRow = $slide_obj->getFirstSlide();
                ?>
                <div class="col-md-3">
                    <div class="hpanel">
                        <div class="panel-body">
                            <div class="text-center">
                                <div class="">
                                    <a href="<?= $slide_obj->slide_pic_url($slideRow['slidePicture']); ?>" title="Image from Unsplash" data-gallery="">
                                        <img class="m-b" alt="logo" src="<?= $slide_obj->slide_pic_url($slideRow['slidePicture']); ?>"
                                             width="188" height="150"></a>
                                </div>
                                <p class="font-bold text-success">Title: <?= $row['slideShowTitle'] ?></p>
                                <p><a href="slideshowdetail.php" class="btn btn-outline btn-info">View Detail</a></p>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-lg-12 m-t-md">
                <div id="msg_box" class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <div>No Record found!</div>
                </div>
            </div>   
        <?php } ?>



    </div>

</div>
<?php include_once('footer.php'); ?>   
<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>