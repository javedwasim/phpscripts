<?php
    
require_once "array-search-class.php";

$array = array(
     'testing' => 'hi how are you',
     'software' => array(
            'vb.net' => array('asp.net', 'c#'),
            'php'   => array('object oriented','script'),
            ),
     'php frameworks' => array('wordpress','joomla','magento','zend framework','yii'),
     'wordpress'    => array('plugin','widget','template'),
     'joomla'       => array('plugin','widget','template'),
     'zend framework' => array('template','plugin'),
     'magento' => array('skin','template'),
     'extra1'    => array('one1','extra6'),
     'extra2'    => array('one2','two'=>array('three'=>array('extra6'))),
     'extra3'    => 'one3',
     'extra4'    => 'One4',
     'extra5'    => 'one5',
     'extra6'    => 'one6',
     'king'    => array('kingdom','queen','troop','states','soldier'),
     'extra7'   => array('one1'),
);

$array_search =  new array_search();

echo "<pre>";


echo '1. search array from array values only with a word ending with "framework"
';
$result = $array_search -> array_like($array, '%framework', 'value', false );
print_r($result);  


echo '2. search array from array values only with a word begining with "one"
';
$result = $array_search -> array_like($array, 'one%', 'value', false );
print_r($result);


echo '3. search array from array values only with a word "One" [case sensitive]
';
$result = $array_search -> array_like($array, '%One%', 'value', true );
print_r($result);


echo '4. search array from array keys only with a word begining with "php"
';
$result = $array_search -> array_like($array, 'php%', 'key', false );
print_r($result);


echo '5. search array from array keys and values with a word "one" which can be anywhere in a keys or values
';
$result = $array_search -> array_like($array, '%one%', 'both', false );
print_r($result);

?>