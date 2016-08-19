<?php
	require_once "support/http.php";
	require_once "support/web_browser.php";
	require_once "support/simple_html_dom.php";
	include_once "domparser/Domparser.class.php";
	require_once "support/functions.php";
	
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

	$form2 = GetForm($response2);
	$form2->SetFormValue("data[User][type]", "employee");
	
	$result3 = $form2->GenerateFormRequest("affiliates-login-button");
	$response3 = $web->Process($result3["url"], "auto", $result3["options"]);
	
	
	$response4 = $web->Process("http://step2wealth.hasoffers.com/admin/stats/index","auto", $result3["options"]);
	
	//var_dump($response4);
	
	$form3 = $response4["forms"][1];
	$form3->SetFormValueById("data[Report][grouping][]", "Stat.affiliate_id","group_by_Stat.affiliate_id","checked");
	$form3->SetFormValueById("data[Report][grouping][]", "Stat.date","group_by_Stat.date","checked");
	$form3->SetFormValueById("data[Report][grouping][]", "Stat.offer_id","group_by_Stat.offer_id","checked");
	$form3->SetFormValueById("data[Report][grouping][]", "Stat.offer_id","group_by_Stat.offer_id","checked");
	$form3->SetFormValue("data[DateRange][preset_date_range]", "this_month");
	
	$result4 = $form3->GenerateFormRequest("generate-report");
	$response5 = $web->Process($result4["url"], "auto", $result4["options"]);
	
	echo "===================CREATE AFFILIATE PAGE RESPONSE======================</br>";
		//var_dump($response5);
			
		echo "<pre>";
		//print_r($response5['body']);
		echo "</pre>";
		
		//Put current response in file to parse html table.
		currentresponse_file($response5['body']);
		
		$file = 'http://localhost/phpscripts/htmltheme/scraper/testfile.php';
				
		$obj=new Domparser($file);	
		$data = ($obj->getElementbyid("all"));
		
		print "</pre>";
		parsehtmltable_intomysql($data);
		print "</pre>";
				
	echo "===================CREATE AFFILIATE RESPONSE END======================</br></br>";
?>