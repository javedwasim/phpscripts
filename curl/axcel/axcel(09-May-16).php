<?php
require_once("ISDK/isdk.php");
ini_set('max_execution_time', 1800); 

$contactId = $_REQUEST['contactId'];
if(empty($contactId)){
	echo "Please enter valid contactId";
	die();
}
echo "Connecting to infusionsoft.......... <br/>";

$app = new iSDK;
// Test Connnection
if ($app->cfgCon("kq272")){

	$qry = array('Id' =>$contactId );
	$ret = array('Id','Email','FirstName','LastName','_TFN','_BirthCountry','_Cityofbirth',
				'_AustralianCitizen','_AborigOrigin','_EmploymentStatus','_Homelanguage','_EnglishComp',
				'_Schoollevel','_Schoolyearcompleted','_Disability','_Qualifications','_USI','_CourseInstance','JobTitle'
				,'Phone1','StreetAddress1','StreetAddress2','City','State','PostalCode','Company','MiddleName',
				'Title','Birthday','_SourceCode','Phone2');
	$contacts = $app->dsQuery("Contact", 1, 0, $qry, $ret);
	
	$id = !empty($contacts[0]['Id']) ? $contacts[0]['Id'] : 0;
	$FirstName = !empty($contacts[0]['FirstName']) ? $contacts[0]['FirstName'] : 0;
	$LastName = !empty($contacts[0]['LastName']) ? $contacts[0]['LastName'] : 0;
	$Email = !empty($contacts[0]['Email']) ? $contacts[0]['Email'] : 0;
	
	$BirthCountry = !empty($contacts[0]['_BirthCountry']) ? $contacts[0]['_BirthCountry'] : 0;
	$TFN = !empty($contacts[0]['_TFN']) ? $contacts[0]['_TFN'] : 0;
	$Cityofbirth = !empty($contacts[0]['_Cityofbirth']) ? $contacts[0]['_Cityofbirth'] : 0;
	$AustralianCitizen = !empty($contacts[0]['_AustralianCitizen']) ? $contacts[0]['_AustralianCitizen'] : 0;
	$AborigOrigin = !empty($contacts[0]['_AborigOrigin']) ? $contacts[0]['_AborigOrigin'] : 0;
	$EmploymentStatus = !empty($contacts[0]['_EmploymentStatus']) ? $contacts[0]['_EmploymentStatus'] : 0;
	$Homelanguage = !empty($contacts[0]['_Homelanguage']) ? $contacts[0]['_Homelanguage'] : 0;
	$EnglishComp = !empty($contacts[0]['_EnglishComp']) ? $contacts[0]['_EnglishComp'] : 0;
	$Schoollevel = !empty($contacts[0]['_Schoollevel']) ? $contacts[0]['_Schoollevel'] : 0;
	$Schoolyearcompleted = !empty($contacts[0]['_Schoolyearcompleted']) ? $contacts[0]['_Schoolyearcompleted'] : 0;
	$Qualifications = !empty($contacts[0]['_Qualifications']) ? $contacts[0]['_Qualifications'] : 0;
	$USI = !empty($contacts[0]['_USI']) ? $contacts[0]['_USI'] : 0;
	$CourseInstance = !empty($contacts[0]['_CourseInstance']) ? $contacts[0]['_CourseInstance'] : 0; 
	$JobTitle = !empty($contacts[0]['JobTitle']) ? $contacts[0]['JobTitle'] : '';
	$MiddleName = !empty($contacts[0]['MiddleName']) ? $contacts[0]['MiddleName'] : '';
	$Title = !empty($contacts[0]['Title']) ? $contacts[0]['Title'] : '';
	$Phone2 = !empty($contacts[0]['Phone2']) ? $contacts[0]['Phone2'] : '';
	$Disability = !empty($contacts[0]['_Disability']) ? $contacts[0]['_Disability'] : ''; 
	
	$Phone1 = !empty($contacts[0]['Phone1']) ? $contacts[0]['Phone1'] : '';
	$StreetAddress1 = !empty($contacts[0]['StreetAddress1']) ? $contacts[0]['StreetAddress1'] : '';
	$StreetAddress2 = !empty($contacts[0]['StreetAddress2']) ? $contacts[0]['StreetAddress2'] : '';
	$City = !empty($contacts[0]['City']) ? $contacts[0]['City'] : '';
	$State = !empty($contacts[0]['State']) ? $contacts[0]['State'] : '';
	$PostalCode = !empty($contacts[0]['PostalCode']) ? $contacts[0]['PostalCode'] : '';
	$Company = !empty($contacts[0]['Company']) ? $contacts[0]['Company'] : '';
	$Birthday = !empty($contacts[0]['Birthday']) ? $contacts[0]['Birthday'] : '';
	$SourceCode = !empty($contacts[0]['_SourceCode']) ? $contacts[0]['_SourceCode'] : '';
	$Birthday = date("Y-m-d", strtotime($Birthday));
	
	$CourseInstance_type = explode(",",$CourseInstance);
	
	$CourseInstance = str_replace(' ', '', $CourseInstance_type[0]);
	$Type = str_replace(' ', '', $CourseInstance_type[1]);
	$CourseInstance_count = count($CourseInstance_type);
	


	echo "<br/>Contact FirstName:".$FirstName;
	echo "<br/>Contact LastName:".$LastName;
	echo "<br/>Contact Email:".$Email;
	
	echo "<br/>Birth Country:".$BirthCountry;
	echo "<br/>TFN:".$TFN;
	echo "<br/>City of birth:".$Cityofbirth;
	echo "<br/>Australian Citizen:".$AustralianCitizen;
	echo "<br/>Aborig Origin:".$AborigOrigin;
	echo "<br/>Employment Status:".$EmploymentStatus;
	echo "<br/>Home language:".$Homelanguage;
	echo "<br/>English Comp:".$EnglishComp;
	echo "<br/>School level:".$Schoollevel;
	echo "<br/>School year completed:".$Schoolyearcompleted;
	echo "<br/>Qualifications:".$Qualifications;
	echo "<br/>USI:".$USI;
	echo "<br/>CourseInstance:".$CourseInstance;
	
	echo "<br/>Phone1:".$Phone1;
	echo "<br/>StreetAddress1:".$StreetAddress1;
	echo "<br/>StreetAddress2:".$StreetAddress2;
	echo "<br/>City:".$City;
	echo "<br/>State:".$State;
	echo "<br/>PostalCode:".$PostalCode;
	echo "<br/>Company:".$Company;
	echo "<br/>Middle Name:".$MiddleName;
	echo "<br/>Title:".$Title;
	echo "<br/>Date Of Birth:".$Birthday;
	echo "<br/>Source Code:".$SourceCode;
	echo "<br/>Alternate Phone:".$Phone2;
	
	if((!empty($Disability)) && ($Disability>0)){
			$data = array(
						"givenName" => $FirstName,
						"surname" => $LastName,
						"emailAddress" => $Email,
						"dob"=>$Birthday,
						"CityofBirth"=>$Cityofbirth,
						"position"=>$JobTitle,
						"TFN"=>$TFN,
						"CountryofBirthID"=>$BirthCountry, //CountryofBirthID is not a recognized 4-digit SACC country code
						//"CitizenStatusID"=>$AustralianCitizen,
						"IndigenousStatusID"=>$AborigOrigin, //IndigenousStatusID is not a recognized AVETMISS Indigenous status identifier value
						"LabourForceID"=>$EmploymentStatus, //LabourForceID is not a recognized AVETMISS Labour Force Status code
						"MainLanguageID"=>$Homelanguage, //MainLanguageID is not a recognized 4-digit SACC Language code
						"EnglishProficiencyID"=>$EnglishComp, //EnglishProficiencyID is not a recognized AVETMISS Proficiency in spoken English value
						"HighestSchoolLevelID"=>$Schoollevel, //HighestSchoolLevelID is not a recognized AVETMISS Highest school level completed value
						"DisabilityTypeIDs"=>$Disability, //An invalid Disability type identifier was nfound 
						"PriorEducationStatus"=>$Qualifications, //PriorEducationStatus must be a T\/F value
						"USI"=>$USI, //The USI passed is not a valid USI. It must be a 10-digits: A-Z (excluding O & I) or numbers 2-9
						"postcode"=>$PostalCode,
						"city"=>$City,
						"state"=>$State,
						"streetName"=>$StreetAddress1,
						"streetNo"=>$StreetAddress2,
						"mobilephone"=>$Phone1,
						"organisation"=>$Company,
						"middleName"=>$MiddleName,
						"title"=>$Title,
						"dob"=>$Birthday,
						"workphone"=>$Phone2,
						"SourceCodeID"=>$SourceCode,
						"DisabilityFlag"=>true
					);
		}else{
			
			$data = array(
						"givenName" => $FirstName,
						"surname" => $LastName,
						"emailAddress" => $Email,
						"dob"=>$Birthday,
						"CityofBirth"=>$Cityofbirth,
						"position"=>$JobTitle,
						"TFN"=>$TFN,
						"CountryofBirthID"=>$BirthCountry, //CountryofBirthID is not a recognized 4-digit SACC country code
						//"CitizenStatusID"=>$AustralianCitizen,
						"IndigenousStatusID"=>$AborigOrigin, //IndigenousStatusID is not a recognized AVETMISS Indigenous status identifier value
						"LabourForceID"=>$EmploymentStatus, //LabourForceID is not a recognized AVETMISS Labour Force Status code
						"MainLanguageID"=>$Homelanguage, //MainLanguageID is not a recognized 4-digit SACC Language code
						"EnglishProficiencyID"=>$EnglishComp, //EnglishProficiencyID is not a recognized AVETMISS Proficiency in spoken English value
						"HighestSchoolLevelID"=>$Schoollevel, //HighestSchoolLevelID is not a recognized AVETMISS Highest school level completed value
						//"DisabilityTypeIDs"=>$Disability, //An invalid Disability type identifier was nfound 
						"PriorEducationStatus"=>$Qualifications, //PriorEducationStatus must be a T\/F value
						"USI"=>$USI, //The USI passed is not a valid USI. It must be a 10-digits: A-Z (excluding O & I) or numbers 2-9
						"postcode"=>$PostalCode,
						"city"=>$City,
						"state"=>$State,
						"streetName"=>$StreetAddress1,
						"streetNo"=>$StreetAddress2,
						"mobilephone"=>$Phone1,
						"organisation"=>$Company,
						"middleName"=>$MiddleName,
						"title"=>$Title,
						"dob"=>$Birthday,
						"workphone"=>$Phone2,
						"SourceCodeID"=>$SourceCode,
						"DisabilityFlag"=>false
					);
			
		}
	}
	// Token data hidden on your server   (jwanjum)  301423 AxAPIResponse
	$_WSTOKEN = '1416E478-A8F4-48AA-A14CCC150ACA01B3';
	$_APITOKEN = '3CC99231-4EFC-46E9-8C5D03D17E86C48B';

	// Set dynamic data here, could be from settings or a form etc.
	echo "<br/>".$Email;
	$service_url = 'https://admin.axcelerate.com.au/api/contacts/?emailAddress='.$Email;
	$ch = curl_init($service_url);

	$headers = array();
	$headers[] = 'wstoken: '.$_WSTOKEN;
	$headers[] = 'apitoken: '.$_APITOKEN;

	//print_r($headers);
	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER=>true,
		CURLOPT_HTTPHEADER  => $headers,
		CURLOPT_POST=>false,
	));

	$out = curl_exec($ch);
	curl_close($ch);
	// echo response output
	$axcelContacts = json_decode($out, true);

	echo "<pre>";
	//print_r($axcelContacts);
	
	//===============Create or update Contact in Axcel===========================//
	$contact_exist = $axcelContacts[0]['EMAILADDRESS'];
	$searchContacts = array();
	
	$index = 0;
	if(!empty($contact_exist)){
		
		foreach($axcelContacts as $axcelContact){
			//print_r($axcelContact);
			$searchContacts[$index]['FirstName'] = $axcelContact['GIVENNAME'];
			$searchContacts[$index]['LastName'] = $axcelContact['SURNAME'];
			$searchContacts[$index]['ContactId'] = $axcelContact['CONTACTID'];
			$index++;
		}
		
		//print_r($searchContacts);
		$flag = false;
		
		$contactId = searchContacts($searchContacts, $FirstName, $LastName);
		
		
		
		if(!empty($contactId)){
			//Email, FirstName and LastName are same on IS and axcel i.e contact exist in both systems.
			$flag = true;
			$axcelContactId = $contactId;
			$axcelContactEmail = $Email;
			
			if($CourseInstance_count == 1){
				$course_data = array(
					"contactID" => $axcelContactId,
					"instanceID" => $CourseInstance,
					"type" =>'w',
				);
			}else{
					$course_data = array(
						"contactID" => $axcelContactId,
						"instanceID" => $CourseInstance,
						"type" =>$Type,
					);
			}	
			
			echo "<h3>Contact Exist with Id ".$axcelContactId." and email ".$axcelContactEmail."</h3>" ;
			contactEnrol($_REQUEST['contactId'],$CourseInstance,$headers,$app,$contactId,$course_data);
			$app->achieveGoal('kq272', 'ErrorNotifications' , $contactId);
			die();
		}else{
				/* FirstName and LastName are different*/
	
				$flag = true;
				/* FirstName or LastName are not equal in IS and on axcelerate.*/
				//==============Create New Contact in axcelerate========================//
				//echo "not same"; die();
				$service_url = 'https://admin.axcelerate.com.au/api/contact/';
				$ch = curl_init($service_url);
				
				//print_r($headers);
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER  => $headers,
					CURLOPT_POST=>true,
					CURLOPT_RETURNTRANSFER  =>true,
					CURLOPT_POSTFIELDS => $data
				));

				$out = curl_exec($ch);
				curl_close($ch);
				$result = json_decode($out, true);
				// echo response output
				echo "<pre>";
				print_r($result);
				echo "</pre>";	
				
				$contactId = $result['CONTACTID'];

				if(!empty($contactId )){
					echo "Contact Created Successfully";
					
					if($CourseInstance_count == 1){
						$course_data = array(
							"contactID" => $contactId,
							"instanceID" => $CourseInstance,
							"type" =>'w',
						);
					}else{
							$course_data = array(
								"contactID" => $contactId,
								"instanceID" => $CourseInstance,
								"type" =>$Type,
							);
					}
					
					contactEnrol($_REQUEST['contactId'],$CourseInstance,$headers,$app,$contactId,$course_data);	
				}else{
					//Update Error Notification and trigger goal.
					$condata = array(
						"_AxAPIResponse" =>$result['DETAILS']
						
					);
					$app->dsUpdate("Contact", $_REQUEST['contactId'], $condata);
					$app->achieveGoal('kq272', 'ErrorNotifications' , $contactId);
					
				}
				
				die();
			}
		
		}else{
			
			/* if no record found in axcelerate against given email.*/
			// echo "empty".$CourseInstance; die();	
			//==============Create New Contact in axcelerate========================//
		
			$service_url = 'https://admin.axcelerate.com.au/api/contact/';
			$ch = curl_init($service_url);
					
			//print_r($headers);
			curl_setopt_array($ch, array(
				CURLOPT_HTTPHEADER  => $headers,
				CURLOPT_POST=>true,
				CURLOPT_RETURNTRANSFER  =>true,
				CURLOPT_POSTFIELDS => $data
			));

			$out = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($out, true);
			// echo response output
			echo "<pre>";
			
			print_r($result);
			echo "</pre>";	
			
			$contactId = $result['CONTACTID'];

			if(!empty($contactId )){
				echo "Contact Created Successfully";
				
				if($CourseInstance_count == 1){
						$course_data = array(
							"contactID" => $contactId,
							"instanceID" => $CourseInstance,
							"type" =>'w',
						);
				}else{
						$course_data = array(
							"contactID" => $contactId,
							"instanceID" => $CourseInstance,
							"type" =>$Type,
						);
				}
				
				contactEnrol($_REQUEST['contactId'],$CourseInstance,$headers,$app,$contactId,$course_data);		
			}else{
				
				//Update Error Notification and trigger goal.
				
				$condata = array(
					"_AxAPIResponse" =>$result['DETAILS']
					
				);
				$app->dsUpdate("Contact", $_REQUEST['contactId'], $condata);
				$app->achieveGoal('kq272', 'ErrorNotifications' , $contactId);
				
			}
		
	}
	
	function searchContacts($searchContacts, $FirstName, $LastName){
	   
	   foreach($searchContacts as $key => $value){
			
		   if(($value['FirstName'] === $FirstName)&&($value['LastName'] === $LastName)){
			
				return $value['ContactId'];
		   }
	   
	   }
	   return false;
	}

	//==============Course Enrol========================//
	function contactEnrol($IScontact_id,$CourseInstance,$headers,$app,$contactId,$data){
		$service_url = 'https://admin.axcelerate.com.au/api/course/enrol';
		$ch = curl_init($service_url);
	
		curl_setopt_array($ch, array(
		CURLOPT_HTTPHEADER  => $headers,
		CURLOPT_POST=>true,
		CURLOPT_RETURNTRANSFER  =>true,
		CURLOPT_POSTFIELDS => $data
		
		));		
				
		$out = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($out, true);
		// echo response output
		if(!empty($result['LEARNERID'])){
			echo "<pre>";
			echo "Contact Enrolled Successfully";
			print_r($result);
			echo "</pre>";	
		}else{
			echo "<h3>There is an error while enroling  course. Please check your mail for futher detail.</h3>";
			//Update Error Notification and trigger goal.
			$condata = array(
				"_AxAPIResponse" =>$result['MESSAGES']
				
			);
			$app->dsUpdate("Contact", $IScontact_id, $condata);
			$app->achieveGoal('kq272', 'ErrorNotifications' , $contactId);
			
		}	
		
		
	}

?>

