<?php 
require_once("includes/initialize.php");
extract(getHttpVars());
if (isset($_REQUEST['permission']) && isset($_REQUEST['token'])) {
  $email    = base64url_decode(trim($_POST['permission']));
  $password = base64url_decode(trim($_POST['token']));
  
    $contactGlobalObj->setContactEmail($email);
    $contactGlobalObj->setPassword($password);
    $contactData = $contactGlobalObj->authenticateContact();
            if(!empty($contactData)){
                if($contactGlobalObj->isIsMember($contactData[0]['Id'])){
                    $session->login($contactData);
                    redirect_JS("index.php");
                }else{
                    $session->message("You have no permission to login.");
                    redirect_JS("login.php");
                     die();
                }
            } //END OF if(!empty($contactData)){
           else{
               $session->message("Please enter valid login detail.");
                redirect_JS("login.php");
                die();
           }
}else{
       $session->message("Please enter valid login detail.");
        redirect_JS("login.php");
        die();
   }
?>
