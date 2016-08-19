<?php 
ini_set('max_execution_time', 600); //300 seconds = 5 minutes

$request_xml = '<?xml version="1.0" encoding="UTF-8"?>		
<Order>		
	<OrderInformation><!--order maintable info-->
		<OrderDate>2016-3-31</OrderDate><!--ordercreatetime ,default is servertime-->
		<Createman>TESTJJ</Createman><!--not null ,be same with user element in header-->
		<Password>123456</Password><!--can be null-->
		<ClothingID>1</ClothingID><!-- Clothing Category(2pcs suit, 3pcs suit, shirt......) (more values in dict)-->
		<SizeCategoryID>10052</SizeCategoryID><!--Size Category(Standard size, body measurement, finished measurement) (more  values in dict)-->
		<SizeAreaID>10202</SizeAreaID><!--(Asia size、Eu size、US size、Australia size)(more in dict)--><!--only be used for standard size, others no need-->
		<Fabrics>DBM590A</Fabrics><!--fabric code-->
		<SizeUnitID>10266</SizeUnitID><!--unit 10266 :cm 10265 ：inch-->
		<ClothingStyle>20100</ClothingStyle><!--jacket length style(normal，long，short) standard：20100(more values in dict)-->
		<CustormerBody>10087,10088,10090,10091,10092,</CustormerBody><!--body type(shoulder, back, stomach, arms, hip)--><!--if standard size, no need this--><!--if need pls fill in all five parts (more values in dict) -->
		<ClothingSize>10172:43,10129:40,10127:110,10128:50,10120:85,10122:65,10124:5,10123:72,10126:110,10125:7,10116:40,10117:75,10115:42,10114:65,10113:65,10111:43,10110:35,10108:100|100,10105:90,10102:100,10101:35</ClothingSize><!--important, size info; e.g. param1:param2,param1 means body measure part,param2 means measure values  --><!-- 2pcs or 3pcs suit, the seat size should be: jacket seat size|pant seat size -->
		<From>2</From><!--deafult value 2-->
		<Save></Save>><!--1 or null--><!--leave it blank means the transferred order will go into production directly，fill in "1" means the transferred orders will be in saving first for double check order information, then need Customer login in RC system submit-->
        <UserNo></UserNo><!-- Customer order, if you must need userno pls fill in it(it depends on your accountinfo)-->
	</OrderInformation>
    <CustomerInformation><!--customer information-->
		<CustomerName>KTest</CustomerName>
		<Height>165</Height>
		<HeightUnitID>10266</HeightUnitID> <!--height unit (more values in dict)-->
		<Weight>62</Weight>
		<WeightUnitID>10261</WeightUnitID> <!--weight unit (more values in dict)-->
		<Email>bolatusda@126.com</Email>
		<Address>Qingdao</Address>
		<Tel>13697656980</Tel>
		<GenderID>10040</GenderID> <!--genders (more values in dict)-->
	</CustomerInformation>	
	<OrderDetails>	<!--order detailtable info if the order is 2pcs suit 3pc suit or other suit you need multiple OrderDetail element -->
		<OrderDetail id = "1"><!--if two or more products or embroideries in one order, we need IDs to distinguish them-->		
			<OrderDetailInformation>		
				<SizeSpecChest>105E</SizeSpecChest><!--not necessary-->	
				<SizeSpecHeight>180/113A</SizeSpecHeight><!--santandard size options, others no need-->	
				<Categories>3</Categories><!--clothing category(jacket) (more values in dict)-->	
				<Quantity>1</Quantity>	
				<BodyStyle>10284</BodyStyle> <!--style for dressinfo normal loose or other style(more values in dict) -->
			</OrderDetailInformation>			
			<EmbroideryProcess>	<!--embroidery info if you need multiple embroidery you also need multiple Embroidery element-->	
				<Embroidery id = "1">	
				    <Location>427</Location> <!-- embroidery location (more values in dict)-->
					<Font>528</Font><!-- embroidery font (more values in dict)-->
					<Color>843</Color><!-- embroidery color (more values in dict)-->
					<Content>421:collar</Content><!-- embroidery content e.g. param1:param2 param1 means content(more values in dict),param2 means detail content-->
					<Size></Size><!--embroidery size (only for shirt more values in dict) -->
				</Embroidery>
			</EmbroideryProcess>	
			<OrdersProcess>1946,220,2050,1166,1972,213,31139,1963,1928,37,88,145,179,433,1145,1144,132,</OrdersProcess> <!--important, process info; (more values in dict) -->
			<OrdersProcessContent>1145:FLL2019-812,1144:C7201,1972:100%W,31139:1010060,1946:FLL624-044,1166:KNJ024,1928:FLL2019-812</OrdersProcessContent> <!--customer appoint process e.g. params1:param2 param1 means customer appoint process(more values in dict) prams2 means customer appoint content. param1 must be filled both in OrdersProcess element and OrdersProcessContent element -->
			<Style></Style><!-- fixedcode no necessary -->
		</OrderDetail>		
		<OrderDetail id = "2">		
			<OrderDetailInformation>	
				<SizeSpecChest>105E</SizeSpecChest>
				<SizeSpecHeight>180/116A</SizeSpecHeight>
				<Categories>2000</Categories>
				<Quantity>1</Quantity>
				<BodyStyle>10284</BodyStyle>
			</OrderDetailInformation>		
			<EmbroideryProcess>	
				<Embroidery id = "2">	
				    <Location>2212</Location>	
					<Font>2528</Font>
					<Color>2459</Color>
					<Content>2207:XXX</Content>
					<Size></Size>
				</Embroidery>	
			</EmbroideryProcess>		
			<OrdersProcess>2035,2171</OrdersProcess>		
			<OrdersProcessContent></OrdersProcessContent>	
			<Style></Style>
		</OrderDetail>			
	</OrderDetails>				
</Order>';


//Initialize handle and set options
$ch = curl_init(); 
$pwd = md5(123456);
$headers = array();
$headers[] = 'user: TESTJJ';
$headers[] = 'pwd: '.$pwd.'';
$headers[] = 'lan: en';
$headers[] = 'Content-Type: application/xml';

curl_setopt($ch, CURLOPT_URL, 'http://api.us.rcmtm.com/order-api/resources/orderService'); 
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_TIMEOUT, 40); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_xml); 

//Execute the request and also time the transaction ( optional )
$start = array_sum(explode(' ', microtime()));
$result = curl_exec($ch); 
$stop = array_sum(explode(' ', microtime()));
$totalTime = $stop - $start;
 
//Check for errors ( again optional )
if ( curl_errno($ch) ) {
    $result = 'ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
} else {
		$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		switch($returnCode){
        case 200:
            break;
        default:
            $result = 'HTTP ERROR -> ' . $returnCode;
            break;
    }
}
 
//Close the handle
curl_close($ch);
 
//Output the results and time
echo 'Total time for request: ' . $totalTime . "\n";
echo "<pre>";
echo $result; 