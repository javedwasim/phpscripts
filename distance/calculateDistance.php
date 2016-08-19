<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calculateDistance
 *
 * @author Vivek
 */
class calculateDistance {
    
    
    public function calculate($lat1, $lon1, $lat2, $lon2, $unit){
    $radlat1 = pi() * $lat1/180;
        $radlat2 = pi() * $lat2/180;
        $theta = $lon1-$lon2;
        $radtheta = pi() * $theta/180;
        $distsin = sin($radlat1) * sin($radlat2) + cos($radlat1) * cos($radlat2) * cos($radtheta);
        $distacos = acos($distsin);
        $distpi = $distacos * 180/  pi();
        $dist = $distpi * 60 * 1.1515;
        if ($unit=="K") { $dist = $dist * 1.609344; }
        if ($unit=="N") { $dist = $dist * 0.8684; }
        return  $dist;
    }
}