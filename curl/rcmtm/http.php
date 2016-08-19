<?php
echo "<pre>";
print_r($_POST);
$data = apache_request_headers();
print_r($data);
echo "</pre>";