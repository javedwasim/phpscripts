<?php
// ----------------------------------------------------------------------
// Copyright (C) 2008 by Khaled Al-Shamaa.
// http://www.ar-php.com
// ----------------------------------------------------------------------
// LICENSE

// This program is open source product; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------
// Class Name: Muslim Prayer Times
// Filename:   Salat.class.php
// Original    Author(s): Khaled Al-Sham'aa <khaled.alshamaa@gmail.com>
// Purpose:    The five Islamic prayers are named Fajr, Zuhr, Asr, Maghrib
//             and Isha. The timing of these five prayers varies from place
//             to place and from day to day. It is obligatory for Muslims
//             to perform these prayers at the correct time.
// ----------------------------------------------------------------------
// Source: http://qasweb.org/qasforum/index.php?showtopic=177&st=0
// By: Mohamad Magdy <mohamad_magdy_egy@hotmail.com>
// ----------------------------------------------------------------------

/**
* Muslim Prayer Times
*
* @desc Using this PHP Class you can calculate the time of Muslim prayer 
* according to the geographic location.
*
* @copyright Khaled Al-Shamaa 2008
* @link http://www.ar-php.com
* @author Khaled Al-Shamaa <khaled.alshamaa@gmail.com>
* @package Arabic
*/

class Salat {
    private $year = 1975; // السنة
    private $month = 8; // الشهر
    private $day = 2; // اليوم
    private $zone = 2; // فرق التوقيت العالمى
    private $long = 37.15861; // خط الطول الجغرافى للمكان
    private $lat = 36.20278; // خط العرض الجغرافى
    private $AB2 =  - 0.833333; // زاوية الشروق والغروب
    private $AG2 =  - 18; // زاوية العشاء
    private $AJ2 =  - 18; // زاوية الفجر
    private $school = 'Shafi'; // المذهب

    /**
     * @return TRUE if success, or FALSE if fail
     * @param Integer $d day of date you want to calculate Salat in
     * @param Integer $m month of date you want to calculate Salat in
     * @param Integer $y year (four digits) of date you want to calculate Salat in
     * @desc Setting date of day for Salat calculation
     * @author Khaled Al-Shamaa <khaled.alshamaa@gmail.com>
     */
    public function setDate($d = 2, $m = 8, $y = 1975) {
        $flag = true;

        if (is_numeric($y) && $y > 0 && $y < 3000) {
            $this->year = floor($y);
        } else {
            $flag = false;
        }

        if (is_numeric($m) && $m >= 1 && $m <= 12) {
            $this->month = floor($m);
        } else {
            $flag = false;
        }

        if (is_numeric($d) && $d >= 1 && $d <= 31) {
            $this->day = floor($d);
        } else {
            $flag = false;
        }

        return $flag;
    }

    /**
     * @return TRUE if success, or FALSE if fail
     * @param Decimal $l1 Longitude of location you want to calculate Salat time in
     * @param Decimal $l2 Latitude of location you want to calculate Salat time in
     * @param Integer $z Time Zone, offset from UTC (see also Greenwich Mean Time)
     * @desc Setting location information for Salat calculation
     * @author Khaled Al-Shamaa <khaled.alshamaa@gmail.com>
     */
    public function setLocation($l1 = 37.15861, $l2 = 36.20278, $z = 2) {
        $flag = true;

        if (is_numeric($l1) && $l1 >=  - 180 && $l1 <= 180) {
            $this->long = $l1;
        } else {
            $flag = false;
        }

        if (is_numeric($l2) && $l2 >=  - 180 && $l2 <= 180) {
            $this->lat = $l2;
        } else {
            $flag = false;
        }

        if (is_numeric($z) && $z >=  - 12 && $z <= 12) {
            $this->zone = floor($z);
        } else {
            $flag = false;
        }

        return $flag;
    }

    /**
     * @return TRUE if success, or FALSE if fail
     * @param String $sch [Shafi|Hanafi] to define Muslims Salat calculation method
     *               (affect Asr time)
     * @param Decimal $sunriseArc Sun rise arc (default value is -0.833333)
     * @param Decimal $ishaArc Isha arc (default value is -18)
     * @param Decimal $fajrArc Fajr arc (default value is -18)
     * @desc Setting rest of Salat calculation configuration
     * @author Khaled Al-Shamaa <khaled.alshamaa@gmail.com>
     */
    public function setConf($sch = 'Shafi', $sunriseArc =  - 0.833333, $ishaArc
        =  - 18, $fajrArc =  - 18) {
        $flag = true;

        $sch = ucfirst($sch);

        if (in_array($sch, array('Shafi', 'Hanafi'))) {
            $this->school = $sch;
        } else {
            $flag = false;
        }

        if (is_numeric($sunriseArc) && $sunriseArc >=  - 180 && $sunriseArc <=
            180) {
            $this->AB2 = $sunriseArc;
        } else {
            $flag = false;
        }

        if (is_numeric($ishaArc) && $ishaArc >=  - 180 && $ishaArc <= 180) {
            $this->AG2 = $ishaArc;
        } else {
            $flag = false;
        }

        if (is_numeric($fajrArc) && $fajrArc >=  - 180 && $fajrArc <= 180) {
            $this->AJ2 = $fajrArc;
        } else {
            $flag = false;
        }

        return $flag;
    }

    /**
     * @return Array of Salat times + sun rise in the following format
     *               hh:mm where hh is the hour in local format and 24 mode
     *                     mm is minutes with leading zero to be 2 digits always
     *               Array items is [Fajr, Sunrise, Zuhr, Asr, Maghrib, Isha]
     * @desc Calculate Salat times for the date set in setSalatDate
     *                   methode, and location set in setSalatLocation.
     * @author Khaled Al-Shamaa <khaled.alshamaa@gmail.com>
     * @author Mohamad Magdy <mohamad_magdy_egy@hotmail.com>
     * @source http://qasweb.org/qasforum/index.php?showtopic=177&st=0
     */
    public function getPrayTime() {
        $prayTime = array();

        // نحسب اليوم الجوليانى
        $d = ((367 * $this->year) - (floor((7 / 4) * ($this->year + floor(
            ($this->month + 9) / 12)))) + floor(275 * ($this->month / 9)) +
            $this->day - 730531.5);

        // نحسب طول الشمس الوسطى
        $L = ((280.461 + 0.9856474 * $d) % 360) + ((280.461 + 0.9856474 * $d) -
            (int)(280.461 + 0.9856474 * $d));

        // ثم نحسب حصة الشمس الوسطى
        $M = ((357.528 + 0.9856003 * $d) % 360) + ((357.528 + 0.9856003 * $d) -
            (int)(357.528 + 0.9856003 * $d));

        // ثم نحسب طول الشمس البروجى
        $lambda = $L + 1.915 * sin($M * pi() / 180) + 0.02 * sin(2 * $M * pi()
            / 180);

        // ثم نحسب ميل دائرة البروج
        $obl = 23.439 - 0.0000004 * $d;

        // ثم نحسب المطلع المستقيم
        $alpha = atan(cos($obl * pi() / 180) * tan($lambda * pi() / 180)) * 180
            / pi();
        $alpha = $alpha - (360 * floor($alpha / 360));

        // ثم نعدل المطلع المستقيم
        $alpha = $alpha + 90 * ((int)($lambda / 90) - (int)($alpha / 90));

        // نحسب الزمن النجمى بالدرجات الزاوية
        $ST = ((100.46 + 0.985647352 * $d) % 360) + ((100.46 + 0.985647352 * $d)
            - (int)(100.46 + 0.985647352 * $d));

        // ثم نحسب ميل الشمس الزاوى
        $Dec = asin(sin($obl * pi() / 180) * sin($lambda * pi() / 180)) * 180 /
            pi();

        // نحسب زوال الشمس الوسطى
        if ($alpha > $ST) {
            $noon = (($alpha - $ST) % 360) + (($alpha - $ST) - (int)($alpha -
                $ST));
        } else {
            $noon = (($ST - $alpha) % 360) - (($ST - $alpha) - (int)($ST -
                $alpha));
        }

        // ثم الزوالى العالمى
        $un_noon = $noon - $this->long;

        // ثم الزوال المحلى
        $local_noon = $un_noon / 15+$this->zone;

        // وقت صلاة الظهر
        $Dhuhr = $local_noon / 24;
        $Dhuhr_h = (int)($Dhuhr * 24 * 60 / 60);
        $Dhuhr_m = sprintf("%02d", ($Dhuhr * 24 * 60) % 60);
        $prayTime[2] = "$Dhuhr_h:$Dhuhr_m";

        if ($this->school == 'Shafi') {
            // نحسب إرتفاع الشمس لوقت صلاة العصر حسب المذهب الشافعي
            $T = atan(1+tan(($this->lat - $Dec) * pi() / 180)) * 180 / pi();

            // ثم نحسب قوس الدائر أى الوقت المتبقى من وقت الظهر حتى صلاة العصر حسب المذهب الشافعي
            $V = acos((sin((90-$T) * pi() / 180) - sin($Dec * pi() / 180) * sin
                ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos
                ($this->lat * pi() / 180))) * 180 / pi() / 15;

            // وقت صلاة العصر حسب المذهب الشافعي
            $X = $local_noon + $V;
            $SAsr = $Dhuhr + $V / 24;
            $SAsr_h = (int)($SAsr * 24 * 60 / 60);
            $SAsr_m = sprintf("%02d", ($SAsr * 24 * 60) % 60);
            $prayTime[3] = "$SAsr_h:$SAsr_m";
        } else {
            // نحسب إرتفاع الشمس لوقت صلاة العصر حسب المذهب الحنفي
            $U = atan(2+tan(($this->lat - $Dec) * pi() / 180)) * 180 / pi();

            // ثم نحسب قوس الدائر أى الوقت المتبقى من وقت الظهر حتى صلاة العصر حسب المذهب الحنفي
            $W = acos((sin((90-$U) * pi() / 180) - sin($Dec * pi() / 180) * sin
                ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos
                ($this->lat * pi() / 180))) * 180 / pi() / 15;

            // وقت صلاة العصر حسب المذهب الحنفي
            $Z = $local_noon + $W;
            $HAsr = $Z / 24;
            $HAsr_h = (int)($HAsr * 24 * 60 / 60);
            $HAsr_m = sprintf("%02d", ($HAsr * 24 * 60) % 60);
            $prayTime[3] = "$HAsr_h:$HAsr_m";
        }

        // نحسب نصف قوس النهار
        $AB = acos((SIN($this->AB2 * pi() / 180) - sin($Dec * pi() / 180) * sin
            ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos($this
            ->lat * pi() / 180))) * 180 / pi();

        // وقت الشروق
        $AC = $local_noon - $AB / 15;
        $Sunrise = $AC / 24;
        $Sunrise_h = (int)($Sunrise * 24 * 60 / 60);
        $Sunrise_m = sprintf("%02d", ($Sunrise * 24 * 60) % 60);
        $prayTime[1] = "$Sunrise_h:$Sunrise_m";

        // وقت الغروب
        $AE = $local_noon + $AB / 15;
        $Sunset = $AE / 24;
        $Sunset_h = (int)($Sunset * 24 * 60 / 60);
        $Sunset_m = sprintf("%02d", ($Sunset * 24 * 60) % 60);
        $prayTime[4] = "$Sunset_h:$Sunset_m";

        // نحسب فضل الدائر وهو الوقت المتبقى من وقت صلاة الظهر إلى وقت العشاء
        $AG = acos((sin($this->AG2 * pi() / 180) - sin($Dec * pi() / 180) * sin
            ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos($this
            ->lat * pi() / 180))) * 180 / pi();

        // وقت صلاة العشاء
        $AH = $local_noon + ($AG / 15);
        $Isha = $AH / 24;
        $Isha_h = (int)($Isha * 24 * 60 / 60);
        $Isha_m = sprintf("%02d", ($Isha * 24 * 60) % 60);
        $prayTime[5] = "$Isha_h:$Isha_m";

        // نحسب فضل دائر الفجر وهو الوقت المتبقى من وقت صلاة الفجر حتى وقت صلاة الظهر
        $AJ = acos((sin($this->AJ2 * pi() / 180) - sin($Dec * pi() / 180) * sin
            ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos($this
            ->lat * pi() / 180))) * 180 / pi();

        // وقت صلاة الفجر
        $AK = $local_noon - $AJ / 15;
        $Fajr = $AK / 24;
        $Fajr_h = (int)($Fajr * 24 * 60 / 60);
        $Fajr_m = sprintf("%02d", ($Fajr * 24 * 60) % 60);
        $prayTime[0] = "$Fajr_h:$Fajr_m";

        return $prayTime;
    }
}

?>
