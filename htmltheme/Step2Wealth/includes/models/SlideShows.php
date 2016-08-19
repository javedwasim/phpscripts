<?php
/**
 * Description of slideshows
 *
 * @author ASIF
 */
class SlideShows {
    public $MemberId;
    public $slideShowTitle;
    public $slideShowStatus;
    public $trackingURL;
    public $offerId;
    public $createdTime;
    
    public function getMemberId() {
        return $this->MemberId;
    }

    public function setMemberId($MemberId) {
        $this->MemberId = $MemberId;
    }

    
    public function getSlideShowTitle() {
        return $this->slideShowTitle;
    }

    public function getSlideShowStatus() {
        return $this->slideShowStatus;
    }

    public function getTrackingURL() {
        return $this->trackingURL;
    }

    public function getofferId() {
        return $this->offerId;
    }

    public function getCreatedTime() {
        return $this->createdTime;
    }

   

    public function setSlideShowTitle($slideShowTitle) {
        $this->slideShowTitle = $slideShowTitle;
    }

    public function setSlideShowStatus($slideShowStatus) {
        $this->slideShowStatus = $slideShowStatus;
    }

    public function setTrackingURL($trackingURL) {
        $this->trackingURL = $trackingURL;
    }

    public function setofferId($offerId) {
        $this->offerId = $offerId;
    }

    public function setCreatedTime($createdTime) {
        $this->createdTime = $createdTime;
    }

    public function getLatestSlideShows(){
        global $database;
        $sql = "SELECT * FROM memberslidesshow "
               . "WHERE MemberId= '".$this->getMemberId()."' ORDER BY createdTime DESC LIMIT 8";
        $result = $database->query($sql);
        return $result;
    }
    public function getapprovedSlideShows($orderCol=NULL,$order=NULL,$page_position=NULL,$item_per_page=NULL,$searchCol=NULL,$searcVal=NULL) {
        global $database;
        $sql = "SELECT * FROM memberslidesshow WHERE slideShowStatus='Approved'";
        if($searchCol != NULL && $searcVal != NULL){
            $sql .= " AND {$searchCol} LIKE '%$searcVal%'";
        }
        if($orderCol !=NULL){
        $sql .= " ORDER BY {$orderCol} {$order}";
        }
        if($item_per_page != NULL){
           $sql .= " LIMIT {$page_position}, {$item_per_page}"; 
        }
        $result = $database->query($sql);
        return $result;
    }
    public function countApprovedSlideShows($searchCol=NULL,$searcVal=NULL){
        global $database;
        $sql    =  "SELECT COUNT(*) FROM memberslidesshow WHERE slideShowStatus='Approved'";
        if($searchCol != NULL && $searcVal != NULL){
            $sql .= " AND {$searchCol} LIKE '%$searcVal%'";
        }
        $result = $database->query($sql);
        return $database->fetch_row($result);
    }
//------------------------------------------------------------------------------------------------------

}//end of class
global $slideShow_tbl,$featch_col;
$slideShow_tbl = "memberslidesshow";
