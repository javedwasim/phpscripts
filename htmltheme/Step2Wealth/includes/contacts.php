<?php

//require_once("includes/initialize.php");
require_once("initialize.php");

class Contacts extends isdk {

    public $userID;
    public $contactId;
    public $contactEmail;
    public $contactFirstName;
    public $contactLastName;
    public $contactFullName;
    public $Password;
    public $Phone1;
    public $StreetAddress1;
    public $TagId;
    public $ProfileImage;
    public $Role;

    public function getContactFullName() {
        return $this->contactFullName;
    }

    public function setContactFullName($contactFullName) {
        $this->contactFullName = $contactFullName;
    }

    function getProfileImage() {
        return $this->ProfileImage;
    }

    function getRole() {
        return $this->Role;
    }

    function setProfileImage($ProfileImage) {
        $this->ProfileImage = $ProfileImage;
    }

    function setRole($Role) {
        $this->Role = $Role;
    }

    function getPassword() {
        return $this->Password;
    }

    function setPassword($Password) {
        $this->Password = $Password;
    }

    function getUserID() {
        return $this->userID;
    }

    function getContactId() {
        return $this->contactId;
    }

    function getContactEmail() {
        return $this->contactEmail;
    }

    function getContactFirstName() {
        return $this->contactFirstName;
    }

    function getContactLastName() {
        return $this->contactLastName;
    }

    function getPhone1() {
        return $this->Phone1;
    }

    function getStreetAddress1() {
        return $this->StreetAddress1;
    }

    function getTagId() {
        return $this->TagId;
    }

    function setUserID($userID) {
        $this->userID = $userID;
    }

    function setContactId($contactId) {
        $this->contactId = $contactId;
    }

    function setContactEmail($contactEmail) {
        $this->contactEmail = $contactEmail;
    }

    function setContactFirstName($contactFirstName) {
        $this->contactFirstName = $contactFirstName;
    }

    function setContactLastName($contactLastName) {
        $this->contactLastName = $contactLastName;
    }

    function setPhone1($Phone1) {
        $this->Phone1 = $Phone1;
    }

    function setStreetAddress1($StreetAddress1) {
        $this->StreetAddress1 = $StreetAddress1;
    }

    function setTagId($TagId) {
        $this->TagId = $TagId;
    }

    public function __construct() {
        if ($this->cfgCon("sv287")) {
            true;
        } else {
            false;
        }
    }

    public function isDsQuery($tbl, array $query, array $returnFields) {
        $result_set = array();
        $results = array();
        $page = 0;
        while (true) {
            $results = $this->dsQuery($tbl, 1000, $page, $query, $returnFields);
            $result_set = array_merge($result_set, $results);
            if (count($results) < 1000) {
                break;
            }
            $page++;
        }
        return $result_set;
    }

    public function isDsQueryOrderBy($tbl, array $query, array $returnFields, $orderBy, $ascending) {
        $result_set = array();
        $results = array();
        $page = 0;
        while (true) {
            $results = $this->dsQueryOrderBy($tbl, 1000, $page, $query, $returnFields, $orderBy, $ascending);
            $result_set = array_merge($result_set, $results);
            if (count($results) < 1000) {
                break;
            }
            $page++;
        }
        return $result_set;
    }

    public function getCurrentaffaliateInfo() {
        $returnFields = array('Id', 'FirstName', 'Email', 'LastName', 'StreetAddress1', 'DateCreated', 'Phone1', '_BrokerBusinessName',
            '_RealtorBusinessName', '_ProfileImage', 'Company', '_TeamLogo0', '_Sendemailsusingmainaccount');
        $contacts = $this->findByEmail($this->AffiliateEmail, $returnFields);
        return $contacts;
    }

    public function getSupperAdminId($email) {
        $qry = array('Email' => $email, "_ContactType0" => "Admin");
        $ret = array('Id');
        $contacts = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        $id = !empty($contacts[0]['Id']) ? $contacts[0]['Id'] : 0;
        return $id;
    }

    public function checkPwdMatch($id, $pwd) {
        $qry = array('Id' => $id, '_HUBPassword' => $pwd);
        $ret = array('Email');
        $contacts = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        $Email = isset($contacts[0]['Email']) ? $contacts[0]['Email'] : 0;
        return $Email;
    }

    public function changePwd($id, $Newpwd) {
        $condata = array('_HUBPassword' => $Newpwd);
        $cid = $this->dsUpdate("Contact", $id, $condata);
        if (!empty($cid)) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateContactType($id, $type) {
        $condata = array('_ContactType0' => $type);
        $cid = $this->dsUpdate("Contact", $id, $condata);
        if (!empty($cid)) {
            return true;
        } else {
            return false;
        }
    }

    public function contactFullName() {
        $contacts = $this->getCurrentaffaliateInfo();
        $fullName = isset($contacts[0]['FirstName']) ? $contacts[0]['FirstName'] . " " : "";
        $fullName .= isset($contacts[0]['LastName']) ? $contacts[0]['LastName'] : "";
        return $fullName;
    }

    public function contactProfilePic() {
        $contacts = $this->getCurrentaffaliateInfo();
        $ProfileImage = isset($contacts[0]['_ProfileImage']) ? $contacts[0]['_ProfileImage'] . " " : "";
        return $ProfileImage;
    }

    public function getAffcodeById($id) {
        $qry = array('ContactId' => $id);
        $ret = array('AffCode');
        $aff = $this->dsQuery("Affiliate", 1, 0, $qry, $ret);
        $affcode = !empty($aff[0]['AffCode']) ? $aff[0]['AffCode'] : 0;
        return $affcode;
    }

    function getMainRealtorInfo($email) {
        $contactId = $this->getMainRealtorIdByEmail($email);
        $this->setContactId($contactId);
        return $this->getContactInfoById();
    }

    public function getISContactId($email) {
        $qry = array('Email' => $email);
        $ret = array('Id');
        $contacts = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        $id = !empty($contacts[0]['Id']) ? $contacts[0]['Id'] : 0;
        return $id;
    }

    public function authenticateContact() {
        $returnFields = array("Id", "Email", "FirstName", "LastName", "Password", "_Role", "_ProfileImage");
        $query = array("Email" => $this->getContactEmail(), "Password" => $this->getPassword());
        $Contact = $this->dsQuery('Contact', 1, 0, $query, $returnFields);
        return $Contact;
    }

    public function saveIScontact($currentContactId = NULL, $fromBroker = false) {
        $condata = array(
            "Email" => $this->getContactEmail(),
            "FirstName" => $this->getContactFirstName(),
            "LastName" => $this->getContactLastName(),
            "Phone1" => $this->getPhone1(),
            "_RealtorBusinessName" => $this->getBusinessName(),
            "_ContactType0" => $this->getContactType0(),
            "_Sendemailsusingmainaccount" => $this->getSendemailsusingmainaccount(),
        );
        if ($fromBroker == true) {
            $condata = array(
                "Email" => $this->getContactEmail(),
                "FirstName" => $this->getContactFirstName(),
                "LastName" => $this->getContactLastName(),
                "Phone1" => $this->getPhone1(),
                "_HUBPassword" => $this->getPassword(),
                "_RealtorBusinessName" => $this->getBusinessName(),
                "_AutoLoginToken" => $this->getAutoLoginToken(),
                "_ContactType0" => $this->getContactType0(),
                "_AffiliateEmail1" => $this->getAffiliateEmail(),
                "_AffiliateName" => $this->getAffiliateName(),
                "_AffiliateCode" => $this->getAffiliateCode(),
                "_DefaultMarketPackages" => '3',
            );
        }
        if ($currentContactId != NULL) { //If Update the current seller
            $cid = $this->dsUpdate("Contact", $currentContactId, $condata);
        } else {
            $cid = $this->addWithDupCheck($condata, "Email");
        }
        if (!empty($cid)) {
            return $cid;
        } else {
            return false;
        }
    }

    public function CheckConactAlreadyExist($email) {
        $returnFields = array('Id');
        $contacts = $this->findByEmail($email, $returnFields);
        if (!empty($contacts[0]['Id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function saveSubAdmin($currentContactId = NULL) {
        $condata = array(
            "Email" => $this->getContactEmail(),
            "FirstName" => $this->getContactFirstName(),
            "LastName" => $this->getContactLastName(),
            "Phone1" => $this->getPhone1(),
            "_TeamOwnerEmail0" => $this->getTeamOwnerEmail(),
            "_TeamId" => $this->getTeamId(),
            "_HUBPassword" => $this->getPassword(),
            "_AutoLoginToken" => $this->getAutoLoginToken(),
            "_ContactType0" => "SubAdmin",
        );
        if ($currentContactId != NULL) {
            $condata = array(
                "Email" => $this->getContactEmail(),
                "FirstName" => $this->getContactFirstName(),
                "LastName" => $this->getContactLastName(),
                "Phone1" => $this->getPhone1(),
            );
        }
        if ($currentContactId != NULL) { //If Update the current seller
            $cid = $this->dsUpdate("Contact", $currentContactId, $condata);
        } else {
            $cid = $this->addWithDupCheck($condata, "Email");
        }
        if (!empty($cid)) {
            return $cid;
        } else {
            return false;
        }
    }

    public function getAllIsContact() {
        $returnFields = array("Id", "FirstName");
        $query = array("Id" => "%");
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function getAllIsMembers() {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "DateCreated", "StreetAddress1", "Phone1", "Password", "_Role", "_ProfileImage");
        $query = array("_Role" => "Member");
        $result_set = array();
        $page = 0;
        $orderBy = 'DateCreated';
        $ascending = false;
        return $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
    }

    public function test_con($page_number, $item_per_page) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "DateCreated", "StreetAddress1", "Phone1", "Password", "_Role", "_ProfileImage");
        $query = array("_Role" => "Member");
        $contacts = $this->dsQuery("Contact", $item_per_page, $page_number, $query, $returnFields);
        return $contacts;
     }
    public function count_total_member(){
        $query = array("_Role" => "Member");
        return $this->dsCount("Contact", $query);
    }

    public function contactsFiler($fname = null, $lname = null, $email = null) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "DateCreated", "StreetAddress1", "Phone1", "Password", "_Role", "_ProfileImage");
        $query = array("_Role" => "Member");
        if ($fname != null) {
            $query1 = array("FirstName" => "%$fname%");
            $query = array_merge($query, $query1);
        }
        if ($email != null) {
            $query2 = array("Email" => "%$email%");
            $query = array_merge($query, $query2);
        }
        if ($lname != null) {
            $query3 = array("LastName" => "%$lname%");
            $query = array_merge($query, $query3);
        }
        $result_set = array();
        $page = 0;
        $orderBy = 'DateCreated';
        $ascending = false;
        return $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
    }

    public function moveFieldsValue($id, $val, $type) {
        if ($type == 'AffiliateEmail') {
            $condata = array("_AffiliateEmail1" => $val);
        } elseif ($type == 'BrokerEmail') {
            $condata = array("_BrokerEmail0" => $val);
        } elseif ($type == 'RealtorEmail') {
            $condata = array("_RealtorEmail0" => $val);
        }
        $cid = $this->dsUpdate("Contact", $id, $condata);
        return $cid;
    }

    public function SaveProfileImage($currentContactId) {
        $condata = array("_ProfileImage" => $this->getProfileImage());
        $cid = $this->dsUpdate("Contact", $currentContactId, $condata);
        return $cid;
    }

    public function SaveTeamImage($currentContactId) {
        $condata = array("_TeamLogo0" => $this->getTeamLogo());
        $cid = $this->dsUpdate("Contact", $currentContactId, $condata);
        return $cid;
    }

    public function Get_Profile_Image($currentContactId) {
        $returnFields = array("_ProfileImage");
        $query = array("Id" => $currentContactId);
        $img = $this->dsQuery('Contact', 1, 0, $query, $returnFields);
        return isset($img[0]['_ProfileImage']) ? $img[0]['_ProfileImage'] : "profileimg/no-profile.png";
    }

    public function getContactListing($affcode, $ContactType, $limit = Null) {

        $returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "_EnterListingsWebsite", "DateCreated", "_AffiliateName");
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => $ContactType);
        $result_set = array();
        $page = 0;
        $orderBy = 'DateCreated';
        $ascending = false;
        if ($limit != Null) {
            //$result_set = $this->dsQueryOrderBy("Contact",$limit, 0, $query, $returnFields,$orderBy,$ascending);
            $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
        } else {
            $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
        }
        return $result_set;
    }

    public function getBuyerList($affcode = false, $BuyerStatus) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "Phone1", "DateCreated", "_AffiliateName", "_CreatedBy0");
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Buyer', '_BuyerStatus' => $BuyerStatus);
        if ($affcode == false) {
            $query = array("_ContactType0" => 'Buyer', '_BuyerStatus' => $BuyerStatus);
        } else {
            $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Buyer', '_BuyerStatus' => $BuyerStatus);
        }
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function getSellerAdList($affcode = false, $AdStatus) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "Phone1", "DateCreated",
            "_CreatedBy0", "_AffiliateName", "_EnterListingsWebsite", "_AdStatus", "_FacebookAdId", "_AffiliateEmail1");
        $orderBy = 'DateCreated';
        $ascending = false;
        if ($affcode == false) {
            $query = array("_ContactType0" => 'Seller', "_AdStatus" => $AdStatus);
        } else {
            $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Seller', "_AdStatus" => $AdStatus);
        }
        $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
        return $result_set;
    }

    public function getAllSellerAdsList($affcode) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "Phone1", "DateCreated",
            "_CreatedBy0", "_AffiliateName", "_EnterListingsWebsite", "_AdStatus", "_AffiliateEmail1");
        $orderBy = 'DateCreated';
        $ascending = false;
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Seller');
        $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
        return $result_set;
    }

    public function getAllBuyersList($affcode) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "Phone1", "DateCreated", "_AffiliateName", "_CreatedBy0",
            "_BuyerStatus");
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Buyer');
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function getSubRealtor($teamId) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "Phone1", "DateCreated", "_ContactType0", "_HUBPassword", "_ProfileImage", "_LastLogin");
        $query = array("_TeamId" => $teamId, "_ContactType0" => 'SubRealtor');
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function haveATeam($teamId) {
        //$returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "Phone1", "DateCreated");
        $query = array("_TeamId" => $teamId, "_ContactType0" => 'SubRealtor');
        $result_set = $this->dsCount("Contact", $query);
        if ($result_set > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getSubAdmin($teamId) {
        $returnFields = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "Phone1", "DateCreated");
        $query = array("_TeamId" => $teamId, "_ContactType0" => 'SubAdmin');
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function getAdslisting($affcode) {
        $ActiveAdListing = $this->MarketingPackagesUsed($affcode); #$this->getActiveAdListing();
        #$EndedAdListing = $this->getEndedAdListing();
        $result_set = $ActiveAdListing; # + $EndedAdListing;
        return $result_set;
    }

    public function MarketingPackagesUsed($affcode) {
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => "Seller"); #,"_AdStatus" => "Active");
        $result_set = $this->dsCount("Contact", $query);
        return $result_set;
    }

    public function getActiveAdListing() {
        $returnFields = array("Id");
        $query = array("_AffiliateCode" => $this->AffiliateCode, "_ContactType0" => "Seller"); #,"_AdStatus" => "Active");
        $result_set = array();
        $page = 0;
        $orderBy = 'DateCreated';
        $ascending = false;
        $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
        $result_set = count($result_set);
        return $result_set;
    }

    public function getEndedAdListing() {
        $returnFields = array("Id");
        $query = array("_AffiliateCode" => $this->AffiliateCode, "_ContactType0" => "Seller", "_AdStatus" => "Ended");
        $result_set = array();
        $page = 0;
        $orderBy = 'DateCreated';
        $ascending = false;
        $result_set = $this->isDsQueryOrderBy("Contact", $query, $returnFields, $orderBy, $ascending);
        $result_set = count($result_set);
        return $result_set;
    }

    public function applyTag() {
        return $this->grpAssign($this->getContactId(), $this->getTagId());
    }

//end of applyTag(){

    public function getContactInfoById() {
        $qry = array('Id' => $this->contactId);
        $ret = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "_EnterListingsWebsite", "DateCreated", "Phone1", "_RealtorBusinessName", "_BrokerBusinessName", "_ProfileImage",
            "_DefaultMarketPackages", "_facebookCampaignId", '_HUBPassword', '_TeamLogo0', '_SpouseFirstName', '_Comments', '_ContactType0',
            '_Sendemailsusingmainaccount', '_SpouseLastName', '_SpouseEmail', '_LastLogin', '_SpousePhone');
        $contact = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        return $contact;
    }

    public function getContactEmailById() {
        $qry = array('Id' => $this->contactId);
        $ret = array("Email");
        $contact = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        return $email = isset($contact[0]['Email']) ? $contact[0]['Email'] : NULL;
    }

    public function tagExist($id, $tagId) {
        $returnGroupFields = array('GroupId', 'ContactId');
        $query = array('ContactId' => $id, 'GroupId' => $tagId);
        $tagExist = $this->dsQuery('ContactGroupAssign', 1, 0, $query, $returnGroupFields);
        if (!empty($tagExist)) {
            return true;
        } else {
            return false;
        }
    }

    public function GettagAssignDate($id, $tagId) {
        $returnGroupFields = array('GroupId', 'ContactId', 'DateCreated');
        $query = array('ContactId' => $id, 'GroupId' => $tagId);
        $tagExist = $this->dsQuery('ContactGroupAssign', 1, 0, $query, $returnGroupFields);
        if (!empty($tagExist)) {
            return $tagExist[0]['DateCreated'];
        } else {
            return false;
        }
    }

    public function getAllLead() {
        $returnGroupFields = array('ContactId');
        $query = array('GroupId' => 335);
        $getAllLead = $this->isDsQuery("ContactGroupAssign", $query, $returnGroupFields);
        return $getAllLead;
    }

    public function getAllbuyersId($affcode) {

        $returnFields = array("Id");
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Buyer');
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function All_buyers($affcode, $BuyerStatus) {
        $returnFields = array("Id", "DateCreated");
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Buyer', '_BuyerStatus' => $BuyerStatus);
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function converted_client($affcode) {
        $returnFields = array("Id", "DateCreated");
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => 'Buyer', '_BuyerStatus' => 'Client', "_BuyerConverted0" => "Converted");
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function broker_all_buyers($affcode, $BuyerStatus) {
        $returnFields = array("Id", "DateCreated");
        $query = array("_HUBBrokerCode1" => $affcode, "_ContactType0" => 'Buyer', '_BuyerStatus' => $BuyerStatus);
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function broker_converted_client($affcode) {
        $returnFields = array("Id", "DateCreated");
        $query = array("_HUBBrokerCode1" => $affcode, "_ContactType0" => 'Buyer', '_BuyerStatus' => 'Client', "_BuyerConverted0" => "Converted");
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function broker_all_sellers($affcode, $Status = false) {
        $returnFields = array("Id", "DateCreated");
        $query = array("_HUBBrokerCode1" => $affcode, "_ContactType0" => 'Seller',);
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function BuyerConversionByMonth($affcode) {
        $returnFields = array("Id", "_ConvertedDate");
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => "Buyer", "_BuyerConverted0" => "Converted",);
        $result_set = $this->isDsQuery("Contact", $query, $returnFields);
        return $result_set;
    }

    public function MarketingPackagesAvailable($affcode) {
        $totalBuyers = $this->CountContacts($affcode, "Buyer");
        $totalBuyers = $totalBuyers + $this->get_markeeting_pkgs();
        $totalAdListing = $this->getAdslisting($affcode);
        $result = $totalBuyers - $totalAdListing;
        return $result;
    }

    public function CountContacts($affcode = false, $contactType = false) {
        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => $contactType);
        $Contact = $this->dsCount("Contact", $query);
        return $Contact;
    }

    public function BuyerConversion($affcode) {

        $query = array("_AffiliateCode" => $affcode, "_ContactType0" => "Buyer", "_BuyerConverted0" => "Converted");
        $Contact = $this->dsCount("Contact", $query);
//        $totalBuyer = $this->CountContacts($affcode, "Buyer");
//        if($totalBuyer > 0){
//            $ContactConverted = ($Contact/$totalBuyer)*100;
//             return round($ContactConverted,2)."%";
//        }else{
//            return "0";
//        } 

        return $Contact;
    }

    public function ListingsMarketed() {

        $Sellers = $this->getContactListing($this->getAffiliateCode(), "Seller");
        $countListActive = 0;
        $countListEnd = 0;
        if (!empty($Sellers)) {
            foreach ($Sellers as $Seller) {
                if ($this->tagExist($Seller['Id'], 337)) {
                    $countListActive = $countListActive + 1;
                }
                if ($this->tagExist($Seller['Id'], 339)) {
                    $countListEnd = $countListEnd + 1;
                }
            }//end of for each
        }
        $ListingsMarketed = $countListActive + $countListEnd;
        return $ListingsMarketed;
    }

    public function AdSpendUsed($affcode) {
        $totalAdListing = $this->MarketingPackagesUsed($affcode);
        if (!empty($totalAdListing)) {
            $AdSpendUsed = 50 * $totalAdListing;
        } else {
            $AdSpendUsed = 0;
        }
        return $AdSpendUsed;
    }

    public function getContactInfoByTag($tag) {
        $returnFields = array('ContactId', 'Contact.FirstName', 'Contact.LastName',
            'Contact.Email', 'Contact.DateCreated', 'Contact.StreetAddress1', 'Contact.Phone1');
        $query = array('GroupId' => $tag);
        $result = $this->isDsQuery('ContactGroupAssign', $query, $returnFields);
        //$result = $this->dsQuery("ContactGroupAssign", 5, 0, $query, $returnFields);

        return $result;
    }

//end of function ggetAllSeller(){

    public function getRefferal($affcode) {
        $qry = array('AffCode' => $affcode);
        $ret = array('ContactId', 'ParentId');
        $refferal = $this->dsQuery("Affiliate", 1, 0, $qry, $ret);
        return $parentId = isset($refferal[0]['ParentId']) ? $refferal[0]['ParentId'] : '';
    }

    public function getHubBroker($id) {
        $qry = array('Id' => $id);
        $ret = array('ContactId', 'AffCode');
        return $refferalPerent = $this->dsQuery("Affiliate", 1, 0, $qry, $ret);
    }

    function getaffParentId($id) {
        $qry = array('ContactId' => $id);
        $ret = array('Id');
        $aff = $this->dsQuery("Affiliate", 1, 0, $qry, $ret);
        $affParentID = !empty($aff[0]['Id']) ? $aff[0]['Id'] : 0;
        return $affParentID;
    }

//end of function getaffParentId($id){

    public function getChildAffaliate($affParentID) {
        $returnFields = array("ContactId", "AffCode");
        $query = array("ParentId" => $affParentID, "AffCode" => "r%");
        $result = $this->isDsQuery('Affiliate', $query, $returnFields);
        return $result;
    }

    public function CountRealtors($affParentID) {
        $query = array("ParentId" => $affParentID, "AffCode" => "r%");
        $result = $this->dsCount('Affiliate', $query);
        return $result;
    }

//end of function getChildAffaliate($affParentID){

    public function getMainRealtor($id) {
        $qry = array('Id' => $id);
        $ret = array('_TeamId');

        $MainRealtor = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        return $TeamId = isset($MainRealtor[0]['_TeamId']) ? $MainRealtor[0]['_TeamId'] : NULL;
    }

    public function IScampaignCall($Integration, $callName, $cid) {
        return $this->achieveGoal($Integration, $callName, $cid);
    }

    public function getSellerInfoByFbAdId() {
        $qry = array("_FacebookAdId" => $this->getFacebookAdId(),);
        $ret = array("Id", "FirstName", "LastName", "Email", "StreetAddress1", "_EnterListingsWebsite", "DateCreated", "Phone1");
        $Contact = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        return $Contact;
    }

    public function ActivateAndAssignFbAd() {
        $condata = array(
            "_FacebookAdId" => $this->getFacebookAdId(),
            "_AdStatus" => $this->getAdStatus(),
            "_AdsetEndDate" => $this->getAdsetEndDate(),
            "_AdEndPreNotificationDate" => $this->getAdEndPreNotificationDate(),
        );
        $cid = $this->dsUpdate("Contact", $this->getContactId(), $condata);

        if (!empty($cid)) {
            //$this->setContactId($cid);
            //$this->setTagId(337);
            //$this->applyTag();
            return $cid;
        } else {
            return false;
        }
    }

    public function UpdateHUBPasswordresetURL($currentContactId, $HUBPasswordresetURL) {
        $condata = array("_HUBPasswordresetURL" => $HUBPasswordresetURL);
        $cid = $this->dsUpdate("Contact", $currentContactId, $condata);
        return $cid;
    }

    public function UpdateLastLogin($currentContactId) {

        $condata = array("_LastLogin" => $this->getLastLogin());
        $cid = $this->dsUpdate("Contact", $currentContactId, $condata);
        return $cid;
    }

    public function GetIsUserPwd($id) {
        $qry = array('Id' => $id);
        $ret = array('_HUBPassword');
        $Contact = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        $HUBPassword = !empty($Contact[0]['_HUBPassword']) ? $Contact[0]['_HUBPassword'] : 0;
        return $HUBPassword;
    }

    public function getAllExistingRealtorCount() {
        $returnFields = array("ContactId");
        $query = array("AffCode" => "r%");
        $result = $this->isDsQuery('Affiliate', $query, $returnFields);
        $result = count($result);
        return $result;
    }

    public function opt_In($email) {
        return $this->optIn($email, "Subscriber");
    }

    public function isIsAdmin($id) {
        if ($this->isSupperAdmin($id) || $this->isSubAdmin($id)) {
            return true;
        } else {
            return false;
        }
    }

    public function isSupperAdmin($id) {
        return $this->tagExist($id, 107); //Admin
    }

    public function isSubAdmin($id) {
        //return $this->tagExist($id,429);//Admin Team Member
    }

    public function isIsMember($id) {
        if ($this->tagExist($id, 109)) { //Member
            return true;
        } else {
            return false;
        }
    }

    public function setTokenExpire($id) {
        $condata = array("_AutoLoginTokenExpire" => 1);
        $cid = $this->dsUpdate("Contact", $id, $condata);
        return $cid;
    }

    public function isTokenExpire($id) {
        $qry = array('Id' => $id);
        $ret = array('_AutoLoginTokenExpire');
        $Contact = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        $AutoLoginTokenExpire = !empty($Contact[0]['_AutoLoginTokenExpire']) ? $Contact[0]['_AutoLoginTokenExpire'] : 0;
        if ($AutoLoginTokenExpire == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getAdminInfo() {
        $qry = array('_ContactType0' => "Admin");
        $ret = array('Email', 'FirstName', 'LastName');
        $Contact = $this->dsQuery("Contact", 1, 0, $qry, $ret);
        return $Contact;
    }

//    public function TestFun(){
//        $returnFields = array("Id","Email","_ContactType0");
//        $query        = array("Email" => "%");
//        $result       = $this->isDsQuery('Contact', $query, $returnFields);
//        return $result;
//    }
}

//end of class infusionsoftAPI.............................
global $contactGlobalObj;
$contactGlobalObj = new Contacts();

