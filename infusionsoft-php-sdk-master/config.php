<?php

$infusionsoft_host = 'uk255.infusionsoft.com';
$infusionsoft_api_key = '56e4ff504097865cf12bb6a30f8b4a46';

//To Add Custom Fields, use the addCustomField method like below.
//Infusionsoft_Contact::addCustomField('_LeadScore');

//Below is just some magic...  Unless you are going to be communicating with more than one APP at the SAME TIME.  You can ignore it.
Infusionsoft_AppPool::addApp(new Infusionsoft_App($infusionsoft_host, $infusionsoft_api_key, 443));