<?php

namespace Webgk\Main;    

Class Tools {
    
    public static function arshow($array, $adminCheck = false){
        global $USER;
        $USER = new \Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    
}


