<?php
/**
 * Description of MemberSettings
 *
 * @author ASIF
 */
class MemberSettings {
    //put your code here
    public $memberId;
    public $commissionPerClick;
    public $affiliateURL;
    public $affiliateId;
    
    public function getMemberId() {
        return $this->memberId;
    }

    public function getCommissionPerClick() {
        return $this->commissionPerClick;
    }

    public function getAffiliateURL() {
        return $this->affiliateURL;
    }

    public function getAffiliateId() {
        return $this->affiliateId;
    }

    public function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    public function setCommissionPerClick($commissionPerClick) {
        $this->commissionPerClick = $commissionPerClick;
    }

    public function setAffiliateURL($affiliateURL) {
        $this->affiliateURL = $affiliateURL;
    }

    public function setAffiliateId($affiliateId) {
        $this->affiliateId = $affiliateId;
    }


}
global $memberSettings_tbl;
$memberSettings_tbl = "membersettings";