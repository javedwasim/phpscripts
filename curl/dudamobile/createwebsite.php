<?php 
include_once("ISDK/isdk.php");
global $app ;
$app = new iSDK;
include_once("function.php");
if(isset($_REQUEST['contactId']) && isset($_REQUEST['websiteUrl'])){
	$contactId = $_REQUEST['contactId'];
	$contacts = getContactById($contactId);
	if(!empty($contacts)){ // NOT empty
				
				$firstName = isset($contacts[0]['FirstName'])? $contacts[0]['FirstName']:"";
				$lastName = isset($contacts[0]['LastName'])? $contacts[0]['LastName']:"";
				$email =  isset($contacts[0]['Email'])? $contacts[0]['Email']:"";
				$StreetAddress1 = isset($contacts[0]['StreetAddress1'])? $contacts[0]['StreetAddress1']:"";
				$City = isset($contacts[0]['City'])? $contacts[0]['City']:"";
				$State = isset($contacts[0]['State'])? $contacts[0]['State']:"";
				$PostalCode = isset($contacts[0]['PostalCode'])? $contacts[0]['PostalCode']:"";
				$Country = isset($contacts[0]['Country'])? $contacts[0]['Country']:"";
				$Phone1 = isset($contacts[0]['Phone1'])? $contacts[0]['Phone1']:"";
				$siteURL = $_REQUEST['websiteUrl'];
				$MobileSiteName = isset($contacts[0]['_MobileSiteName'])? $contacts[0]['_MobileSiteName']:"";
				//----------------------Create account in Duda Mobile------------
					if(!empty($siteURL)){
						$MobileSiteName	=	createMobileSite($siteURL);
						$conDat = array('Website'=>$siteURL,'_MobileSiteName' => $MobileSiteName,);
						$update = $app->dsUpdate("Contact",$contactId,$conDat);
						
					}//end of $MobileSiteName
				$pageAutoLoginUrl = createAccount($email,$firstName,$lastName,$siteURL,$MobileSiteName);
				//---------------------Add _AutoLoginUrl and _ResetPasswordUrl ------------------------------
				$getResetPasswordUrl = getResetPasswordUrl($email);
				$ResetPasswordUrl0	=	$getResetPasswordUrl->reset_url;
				$conData = array("_ResetPasswordUrl0" =>$ResetPasswordUrl0,"_AutoLoginUrl"=>$pageAutoLoginUrl);
				$app->dsUpdate("Contact", $contactId, $conData);
				//-------------------------TagApply------------------------------
				$app->grpAssign($contactId,193);#Mobile Site Subscriber
				//-----------------------------Publish Website on Duda Moblie-----------------------
				if(!empty($MobileSiteName)){
					$publishSite = publishSite($MobileSiteName);
				}//if(!empty($MobileSiteName)){

$queryString="?firstName={$firstName}&lastName={$lastName}&addressLine1={$StreetAddress1}&city={$City}&state={$State}&zipCode={$PostalCode}&country={$Country}&phoneNumber={$Phone1}&emailAddress={$email}";	
				redirect_JS("http://1m.1mobil-e.com/mobile-re-direct-code".$queryString);	
	}//if($contacts[0]["Id"]==$contactId){
	else{redirect_JS("http://1m.1mobil-e.com/setup-account-mobile-editor");}
die();
}//end of if(isset($_REQUEST['inf_field_Email']) && isset($_REQUEST['orderId'])){
else{redirect_JS("http://1m.1mobil-e.com/setup-account-mobile-editor");}
die();
?>				
				
	
