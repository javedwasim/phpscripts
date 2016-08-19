<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // $lat1= Your latitude, $lon1= Your Longitude, $lat2= Desired Latitude, $lon2= Desired Longitude
        // $unit can be blank too. If you need the results in Miles than leave it blank else.
        // Use K for kilometre and N for Nautical Miles
        error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);
        include_once './calculateDistance.php';
        $distanceClass=new calculateDistance();
        $distanceClass->calculate($lat1, $lon1, $lat2, $lon2, $unit);
        
        //For testing purpose uncomment the below line
        echo $distanceClass->calculate("26.896623", "75.745167", "26.894555", "75.742460", "K");
    
        ?>
    </body>
</html>
