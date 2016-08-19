<?php
	require_once "support/http.php";
	require_once "support/web_browser.php";
	require_once "support/simple_html_dom.php";
	
	
	function GetForm($result){
			
		if (!$result["success"])  
			echo "Error retrieving URL.  " . $result["error"] . "\n";
		else if ($result["response"]["code"] != 200)  
			echo "Error retrieving URL.  Server returned:  " . $result["response"]["code"] . " " . $result["response"]["meaning"] . "\n";
		else if (count($result["forms"]) != 1)  {
			echo "Was expecting one form.  Received:  " . count($result["forms"]) . "\n";
			return "";
		}
		else
		{
			$form = $result["forms"][0];
			
			
			return $form;		
		}				
}
	
	$url = "https://step2wealth.hasoffers.com/";
	$web = new WebBrowser(array("extractforms" => true));
	$response1 = $web->Process($url);
	
	
	$form1 = GetForm($response1);
	$form1->SetFormValue("data[User][email]", "ryan@ryanbuke.com");
    $form1->SetFormValue("data[User][password]", '$hip50Mil');
	
	$result2 = $form1->GenerateFormRequest("loginButton");
	
	$response2 = $web->Process($result2["url"], "auto", $result2["options"]);

  //  echo "===================LOGIN PAGE RESPONSE======================</br>";
 //			var_dump($response2);
//	echo "===================LOGIN PAGE RESPONSE END======================</br></br>";

	$form2 = GetForm($response2);
	$form2->SetFormValue("data[User][type]", "employee");
	
	$result3 = $form2->GenerateFormRequest("affiliates-login-button");
	$response3 = $web->Process($result3["url"], "auto", $result3["options"]);
	
	
	//echo "===================USER TYPE PAGE RESPONSE======================</br>";
  //			var_dump($response3);
 //	echo "===================USER TYPE RESPONSE END======================</br></br>";
	
	$response4 = $web->Process("https://step2wealth.hasoffers.com/admin/affiliates/create","auto", $result3["options"]);
	
	
	$form3 = $response4["forms"][1];
	
	//var_dump($form3);
	
	
	$form3->SetFormValue("data[Affiliate][company]", "Test017");
	$form3->SetFormValue("data[AffiliateUser][first_name]", "Test017");
	$form3->SetFormValue("data[AffiliateUser][email]", "Test017@hotmail.com");
	$form3->SetFormValue("data[AffiliateUser][password]", "Test009@12322");
	$form3->SetFormValue("data[AffiliateUser][password_confirmation]", "Test009@12322");
	
	$result4 = $form3->GenerateFormRequest("affiliates-create-button");
	$response5 = $web->Process($result4["url"], "auto", $result4["options"]);
	
	echo "===================CREATE AFFILIATE PAGE RESPONSE======================</br>";
	echo "<pre>";
		//print_r($response5);
	echo "</pre>";
	echo "===================CREATE AFFILIATE RESPONSE END======================</br></br>";
	echo "<pre>";
		echo ($response5['url']);
	echo "</pre>";
	
	
?>