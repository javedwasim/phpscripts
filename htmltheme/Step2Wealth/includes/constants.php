<?php

if ($_SERVER['HTTP_HOST'] == "localhost") {
    defined('DB_SERVER') ? null : define("DB_SERVER", "zeeshanmahmood.com");
    defined('DB_USER') ? null : define("DB_USER", "steptowealthdb11");
    defined('DB_PASS') ? null : define("DB_PASS", "SW@step53739");
    defined('DB_NAME') ? null : define("DB_NAME", "steptowealth_db");
    defined('SITE_URL') ? null : define('SITE_URL', 'http://localhost/Step2Wealth');
} else {
    defined('DB_SERVER') ? null : define("DB_SERVER", "zeeshanmahmood.com");
    defined('DB_USER') ? null : define("DB_USER", "steptowealthdb11");
    defined('DB_PASS') ? null : define("DB_PASS", "SW@step53739");
    defined('DB_NAME') ? null : define("DB_NAME", "steptowealth_db");
    defined('SITE_URL') ? null : define('SITE_URL', 'http://ryan.infusionsoftdevelopers.com/step2wealth');
}
$CurrentDateTime = date('Y-m-d,H:i:s', time());
defined('CURRENT_DATE_TIME') ? null : define("CURRENT_DATE_TIME", $CurrentDateTime);

defined('SLIDES_PIC_DIR') ? null : define('SLIDES_PIC_DIR', 'slidsepic/');
defined('REFERRAL_LINK') ? null : define('REFERRAL_LINK', 'http://interestingstories.co/');
defined('AFF_ID') ? null : define('AFF_ID', '1004');
?>