<?php
//This makes troubleshooting MUCH easier.
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Load Infusionsoft
require 'Infusionsoft/infusionsoft.php';

/* $contact = new Infusionsoft_Contact();
$contact->FirstName= "novak";
$contact->LastName= "solutions";
$contact->Email= "novak@solutions.com";

$contact->save(); */

$results = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('FirstName' => '%'), 2);

//In the Infusionsoft API, Opportunities are called leads.
/* $opportunity = new Infusionsoft_Lead();
$opportunity->ContactID = 2806;
$opportunity->OpportunityTitle = 'A Sweet Chance to make Millions of Dollars!';
$opportunity->OpportunityNotes = 'I saw a sign next to the road that said "Real Estate Apprentice Wanted"';
$opportunity->save(); */
?>
<pre><?php print_r($results[0]); ?></pre>