<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";
foreach($arResult["ITEMS"] as $key => $arItem)
{
	if($arItem["CODE"]=="IN_STOCK"){
		sort($arResult["ITEMS"][$key]["VALUES"]);
		if($arResult["ITEMS"][$key]["VALUES"]){
			$arResult["ITEMS"][$key]["VALUES"][0]["VALUE"]=$arItem["NAME"];
        }
    }   
    if($arItem["CODE"]=="DEYSTVUYUSHCHEE_VESHCHESTVO"){
        
        foreach($arItem['VALUES'] as $keyVal => $propVal){          
            $arResult["ITEMS"][$key]['VALUES'][$keyVal]['VALUE'] = \Webgk\Main\Tools::explodeProperty($propVal['VALUE']);                 
        }                
    }
}