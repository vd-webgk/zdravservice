<?php 

namespace Webgk\Main;
use Bitrix\Main\Loader;
use Bitrix\Main as MainModule;
use Bitrix\Iblock;    
use Bitrix\Main\Entity;
use Bitrix\Main\Option;
use Webgk\Main\Hlblock\Prototype;
use Webgk\Main\CSV\CSVToArray;

class itemsInfo {
    function ItemsDeliveryCSVParse($csvFileUrl) {
        $csvFileArr = CSVToArray::CSVParse($csvFileUrl, array("item_name", "delivery_date"));
        foreach ($csvFileArr as $importedItemInfo) {
            itemsInfo::updatingElementsForHLDeliveryDateBlock($importedItemInfo);
        }
    }
    
    function updatingElementsForHLDeliveryDateBlock($importedItemInfo) {
        if (!empty($importedItemInfo["item_name"])) {
            $hlblock = Prototype::getInstance("GoodsDeliveryDates");
            $resultData = $hlblock->getElements(array(
                "select" => array("*"),
                "filter" => array("UF_ITEM_ID" => $importedItemInfo["item_name"])
            ));
            $formattedDate = date("d.m.Y H:i:s", strtotime($importedItemInfo["delivery_date"]));
            if (!empty($resultData)) {
                foreach ($resultData as $curResult) {

                    $result = $hlblock->updateData($curResult["ID"], array(
                        'UF_ITEM_ID' => $importedItemInfo["item_name"],
                        'UF_DELIVERY_DATE' => $formattedDate,
                    ));
                }
            } else {

                $result = $hlblock->addData(array(
                    'UF_ITEM_ID' => $importedItemInfo["item_name"],
                    'UF_DELIVERY_DATE' => $formattedDate,
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