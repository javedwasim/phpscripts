<?php
require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;

define('wstoken', '1416E478-A8F4-48AA-A14CCC150ACA01B3');
define('apitoken', '3CC99231-4EFC-46E9-8C5D03D17E86C48B');

$url = 'https://admin.axcelerate.com.au/api/contacts/?emailAddress=test09@test.com';


$curl = new Curl();
$curl->setHeader('wstoken', wstoken);
$curl->setHeader('apitoken', apitoken);

$contact = $curl->get($url);

echo "Axcelerate ContactId: ".$contact[0]->CONTACTID;
echo "<br/>Axcelerate Contact Given Name: ".$contact[0]->GIVENNAME;
echo "<br/>Axcelerate Contact Surname Name: ".$contact[0]->SURNAME;
echo "<br/>Axcelerate Contact Email Address: ".$contact[0]->EMAILADDRESS;

$curl->close();

// curl \
//     -X POST \
//     -d "id=1&content=Hello+world%21&date=2015-06-30+19%3A42%3A21" \
//     "https://httpbin.org/post"

$data = array(
				"givenName" => "test11",
				"surname" => "test11",
				"emailAddress" => "test11@test.com",
				
			);

$curl = new Curl();
$curl->setHeader('wstoken', wstoken);
$curl->setHeader('apitoken', apitoken);

$curl->post('https://admin.axcelerate.com.au/api/contact/', $data);
echo "<br/>";
var_dump($curl->response);