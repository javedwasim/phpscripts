<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
  require_once "support/http.php";

  require_once "support/web_browser.php";

  require_once "support/simple_html_dom.php";

  $html = new simple_html_dom();

  $url = "http://step2wealth.hasoffers.com/admin/stats/index";
  
  
  $web = new WebBrowser();

  $result = $web->Process($url);

 

  if (!$result["success"])  echo "Error retrieving URL.  " . $result["error"] . "\n";

  else if ($result["response"]["code"] != 200)  echo "Error retrieving URL.  Server returned:  " . $result["response"]["code"] . " " . $result["response"]["meaning"] . "\n";

  else

  {

    echo "All the URLs:\n";

    $html->load($result["body"]);

    $rows = $html->find("<div>");

    foreach ($rows as $row)

    {

      echo "\t" . $row->href . "\n";

    }

  }
  
  


?>
