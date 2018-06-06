<?php 
namespace Webgk\Main;
use Bitrix\Main\Loader;   
use Bitrix\Highloadblock as HL; 

class HLBlockClass {
    function gettingHLBlockId ($hlblockCode) {
        $hlBlockData = HL\HighloadBlockTable::getList(array('filter' => array("NAME" => $hlblockCode)));
        if ($hldata = $hlBlockData -> fetch()) { 
            return $hldata["ID"];
        }
    }
}
?>