<?php 
include_once("ISDK/isdk.php");
global $app ;
$app = new iSDK;
include_once("function.php");
if(isset($_REQUEST['contactId']) && !empty($_REQUEST['contactId'])){

}//if(isset($_REQUEST['contactId']) && !empty($_REQUEST['contactId'])){
?>
<script>
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var contactId = getParameterByName('contactId');
alert(contactId)
</script>				
				
	
