<?php

require_once("ISDK/isdk.php");
global $app ;

if(!$_REQUEST) exit;



function get_invoiceLatest($cid){
 global $app;
 $returnGroupFields = array('Id','InvoiceTotal','ProductSold');
 $query = array('ContactId' => $cid);
 $orderBy = 'DateCreated';
 $ascending = false; 
 $Invoice = $app->dsQueryOrderBy('Invoice', 1,0, $query, $returnGroupFields,$orderBy,$ascending);
 return $Invoice; 
}

function get_invoice($cid){
 global $app;
 $returnGroupFields = array('Id','InvoiceTotal','ProductSold');
 $query = array('ContactId' => $cid);
 $ascending = false; 
 $Invoice = $app->dsQuery('Invoice', 1000,0, $query, $returnGroupFields);
 return $Invoice; 
}

function get_product_detail($productId){
 global $app;
 $returnGroupFields = array('Id','ProductName','Sku','ProductPrice','Description');
 $query = array('Id' => $productId);
 $Product = $app->dsQuery('Product', 1,0, $query, $returnGroupFields);
 return $Product;
}

$contactId = $_REQUEST['contactId'];

if (!empty ($contactId)){
		
        

		$app = new iSDK;
		
          if ($app->cfgCon("sv287")) {
		
				
				 $latestPurchasedProduct = get_invoiceLatest($contactId);
				 
		         $latestProductPrice = $latestPurchasedProduct[0]['InvoiceTotal'];
				 
				 // exit if customer has purchased License product
				 
				 if( $latestPurchasedProduct[0]['ProductSold'] ==7 || 
				 $latestPurchasedProduct[0]['ProductSold'] ==23 || 
				 $latestPurchasedProduct[0]['ProductSold'] ==25 ) {
				 echo "No missed commissopm notification on ".$latestPurchasedProduct[0]['ProductSold'];
				 exit;
				 }
				
				// Get first parent affiliate
				
				$qry = array('ContactId' => $contactId);     
				$ret = array('ParentId');
                $firstParentaffiliate = $app->dsQuery("Affiliate", 1, 0, $qry, $ret);
				
                
				$qry = array('Id' => $contactId);     
				$ret = array('FirstName','LastName');
                $affContact = $app->dsQuery("Contact", 1, 0, $qry, $ret);
				
				$affName = $affContact[0]['FirstName'].' '.$affContact[0]['LastName'];  
				$affProductDetails = get_product_detail($latestPurchasedProduct[0]['ProductSold']);
				$affProductName = $affProductDetails[0]['ProductName'];
				
				echo $affName. ' '. $affProductName.'<br/>'; 
				
				
				if(!empty($firstParentaffiliate)){ 
					
					if ($firstParentaffiliate[0]['ParentId'] !=0){
						
						
						// Get first parent Contact Id and then check his products to verify 
						
						
						$qry = array('Id' => $firstParentaffiliate[0]['ParentId']);     
				        $ret = array('ContactId');
                        $firstParentCont = $app->dsQuery("Affiliate", 1, 0, $qry, $ret);
						
					    $invoices = get_invoice($firstParentCont[0]['ContactId']);
						
						 $hasPurchasedLicense = False;
						 $hasPurchasedProduct = False;
						
						foreach ($invoices as $invoice ) {
							
                         echo $invoice['ProductSold'].'<br/>';
						 
							 if( $invoice['ProductSold'] ==7 || $invoice['ProductSold'] ==23 || $invoice['ProductSold'] ==25 ) 
							 {
							   
							    $hasPurchasedLicense = True;
							  
							 }
							 
							  if ($latestPurchasedProduct[0]['ProductSold'] == $invoice['ProductSold'])
						      {
							    $hasPurchasedProduct = True;
						      }
                        }
				
				         // Get existing missed commission and added newly missed commission
						 
				         if (!$hasPurchasedLicense || !$hasPurchasedProduct){
							 
							 $qry = array('Id' => $firstParentCont[0]['ContactId']);     
				             $ret = array('_TotalMissedCommission');
                             $Contact = $app->dsQuery("Contact", 1, 0, $qry, $ret);
				             $TotalMissedCommission = $Contact[0]['_TotalMissedCommission'] + $latestProductPrice;
						 }
							 
						 if (!$hasPurchasedLicense)
						      {
							   echo "Has not purchased License".'<br/>';
							   
							    $Integration = 'sv287';
						        $callName = 'product23missedLevel2';
						        $app->achieveGoal($Integration, $callName, $firstParentCont[0]['ContactId']);
							  }
							  else
							  {
							   echo "Has purchased License".'<br/>';
							  }
							
                          if (!$hasPurchasedProduct)
						      {
							   echo "Has not purchased the Product ".$latestPurchasedProduct[0]['ProductSold'].'<br/>';
							   echo "Has missed Commission".$latestProductPrice."</br>";
							   
							    $grp = array('_MissedCommisionProduct'  => $affProductName,
								'_MissedCommisionAffiliate'  => $affName,
								'_MissedCommisionProductId'  => $latestPurchasedProduct[0]['ProductSold'],
								'_TotalMissedCommission' => $TotalMissedCommission);
								
								$conId = $firstParentCont[0]['ContactId'];
								$grpID = $app->dsUpdate("Contact", $conId, $grp);
								
								$Integration = 'sv287';
						        $callName = 'anyproductmissedLevel2';
						        $app->achieveGoal($Integration, $callName, $secondParentCont[0]['ContactId']);
						
							  }
							  else
							  {
								  
							   echo "Has purchased Product ".$latestPurchasedProduct[0]['ProductSold'].'<br/>';
							  }
							
						//////////////////////////////////////////////////////////////////////////////////////////////
				
				        // Get second parent affiliate Parent Id and Contact Id and then check his products to verify
						
						/////////////////////////////////////////////////////////////////////////////////////////////
						
						echo ' =============== Second Parent Affiliate ================= </br> ';
						
						$qry = array('Id' => $firstParentaffiliate[0]['ParentId']);     
				        $ret = array('ParentId');
                        $secondParentaffiliate = $app->dsQuery("Affiliate", 1, 0, $qry, $ret);
						
						$qry = array('Id' => $secondParentaffiliate[0]['ParentId']);     
				        $ret = array('ContactId');
                        $secondParentCont = $app->dsQuery("Affiliate", 1, 0, $qry, $ret);
				
						$invoices = get_invoice($secondParentCont[0]['ContactId']);
				 
				         $hasPurchasedLicense = False;
						 $hasPurchasedProduct = False;
						 
						 foreach ($invoices as $invoice ) {
							
                         echo $invoice['ProductSold'].'<br/>';
						 
							 if( $invoice['ProductSold'] ==7 || $invoice['ProductSold'] ==23 || $invoice['ProductSold'] ==25 ) 
							 {
							   
							    $hasPurchasedLicense = True;
							  
							 }
	
							  if ($latestPurchasedProduct[0]['ProductSold'] == $invoice['ProductSold'])
						      {
							    $hasPurchasedProduct = True;
						      }
                        }
						  
						   // Get existing missed commission and added newly missed commission
						 
				         if (!$hasPurchasedLicense || !$hasPurchasedProduct){
							 
							 $qry = array('Id' => $firstParentCont[0]['ContactId']);     
				             $ret = array('_TotalMissedCommission');
                             $Contact = $app->dsQuery("Contact", 1, 0, $qry, $ret);
				             $TotalMissedCommission = $Contact[0]['_TotalMissedCommission'] + $latestProductPrice;
						 }
						  
						  
						  if (!$hasPurchasedLicense)
						      {
							   echo "Has not purchased License".'<br/>';
							   
							    $Integration = 'sv287';
						        $callName = 'product23missedLevel2';
						        $app->achieveGoal($Integration, $callName, $secondParentCont[0]['ContactId']);
						
						      
							  }
							  else
							  {
								  
							   echo "Has purchased License".'<br/>';
							  }
							
                          if (!$hasPurchasedProduct)
						      {
							    echo "Has not purchased the Product ".$latestPurchasedProduct[0]['ProductSold'].'<br/>';
								echo "Has missed Commission".$latestProductPrice."</br>";
							   
							    $grp = array('_MissedCommisionProduct'  => $affProductName,
								'_MissedCommisionAffiliate'  => $affName,
								'_MissedCommisionProductId'  => $latestPurchasedProduct[0]['ProductSold'],
								'_TotalMissedCommission' => $TotalMissedCommission);
								
								$conId = $secondParentCont[0]['ContactId'];
								$grpID = $app->dsUpdate("Contact", $conId, $grp);
								
								$Integration = 'sv287';
						        $callName = 'anyproductmissedLevel2';
						        $app->achieveGoal($Integration, $callName, $secondParentCont[0]['ContactId']);
						
							  }
							  else
							  {
								  
							   echo "Has purchased Product".'<br/>';
							  }
														
							  
						
					}
				}
				
				 
		  }
				
}
?>


