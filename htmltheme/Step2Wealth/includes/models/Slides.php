<?php
/**
 * Description of Slides
 *
 * @author ASIF
 */
class Slides {
    public $slideShowId;
    public $slideTitle;
    public $slideContent;
    public $slidePicture;
    public $slideStatus;
    public $createdTime;
    
    public function getSlideShowId() {
        return $this->slideShowId;
    }

    public function getSlideTitle() {
        return $this->slideTitle;
    }

    public function getSlideContent() {
        return $this->slideContent;
    }

    public function getSlidePicture() {
        return $this->slidePicture;
    }

    public function getSlideStatus() {
        return $this->slideStatus;
    }

    public function getCreatedTime() {
        return $this->createdTime;
    }

    public function setSlideShowId($slideShowId) {
        $this->slideShowId = $slideShowId;
    }

    public function setSlideTitle($slideTitle) {
        $this->slideTitle = $slideTitle;
    }

    public function setSlideContent($slideContent) {
        $this->slideContent = $slideContent;
    }

    public function setSlidePicture($slidePicture) {
        $this->slidePicture = $slidePicture;
    }

    public function setSlideStatus($slideStatus) {
        $this->slideStatus = $slideStatus;
    }

    public function setCreatedTime($createdTime) {
        $this->createdTime = $createdTime;
    }
    public function getFirstSlide(){
        global $database;
        $sql = "SELECT * FROM slides "
               . "WHERE slideShowId = '".$this->getSlideShowId()."' ORDER BY createdTime LIMIT 1";
        $result = $database->query($sql);
        return $database->fetch_array($result);
    }
    public function slide_pic_url($picname=NULL){
        return SLIDES_PIC_DIR.$picname;
    }
   //-------------------------------------------------------------------------
}//End of cloass
global $slides_tbl;
$slides_tbl = "slides";
