<?php

/**
 * Description of AdminSettings
 *
 * @author ASIF
 */
class AdminSettings {

    public $genericCommissionPerClick;

    public function getGenericCPC() {
        return $this->genericCommissionPerClick;
    }

    public function setGenericCPC($genericCommissionPerClick) {
        $this->genericCommissionPerClick = $genericCommissionPerClick;
    }

}

global $adminSettings_tbl;
$adminSettings_tbl = "adminsettings";
