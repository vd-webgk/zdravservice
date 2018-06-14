<?php
namespace Webgk\Main;
use Bitrix\Main\Loader;
use Bitrix\Main as MainModule;
use Bitrix\Iblock;    
use Bitrix\Main\Entity;
use Bitrix\Main\Option; 
use Webgk\Main\Hlblock\Prototype;
use Webgk\Main\CSV\CSVToArray;

class gettingNormItems {
    function NormItemsCSVParse($csvFileUrl) {
        $csvFileArr = CSVToArray::CSVParse($csvFileUrl, array("Item name", "Item quantity"));
        foreach ($csvFileArr as $importedItemInfo) {
            gettingNormItems::updatingElementsForHLQuantityBlock($importedItemInfo);
        }
    }
    
    function updatingElementsForHLQuantityBlock($importedItemInfo) {
        if (!empty($importedItemInfo["Item name"])) {
            $hlblock = Prototype::getInstance("GoodsQuantity");
            $resultData = $hlblock->getElements(array(
                "select" => array("*"),
                "filter" => array("UF_ITEM_ID" => $importedItemInfo["Item name"])
            ));
            if (!empty($resultData)) {
                foreach ($resultData as $curResult) {

                    $result = $hlblock->updateData($curResult["ID"], array(
                        'UF_ITEM_ID' => $importedItemInfo["Item name"],
                        'UF_ITEM_QUANTITY' => $importedItemInfo["Item quantity"],
                    ));
                }
            } else {

                $result = $hlblock->addData(array(
                    'UF_ITEM_ID' => $importedItemInfo["Item name"],
                    'UF_ITEM_QUANTITY' => $importedItemInfo["Item quantity"],
                ));
            }
            $resultId = $result->getId();
            if ($resultId) {
                return $resultId;
            } else {
                return false;
            }
        }    
    }
}?>