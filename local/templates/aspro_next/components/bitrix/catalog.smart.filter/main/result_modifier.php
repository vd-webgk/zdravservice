<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

foreach($arResult["ITEMS"] as $key => $arItem)
{
	if($arItem["CODE"]=="IN_STOCK"){
		sort($arResult["ITEMS"][$key]["VALUES"]);
		if($arResult["ITEMS"][$key]["VALUES"])
			$arResult["ITEMS"][$key]["VALUES"][0]["VALUE"]=$arItem["NAME"];
	}
}
$getIBlock = CIBlockElement::GetList(Array(), Array("IBLOCK_TYPE"=>"catalog_1c", "IBLOCK_ID" => 26), false, false, array("ID", "IBLOCK_ID"));
if($get346prop = $getIBlock->GetNextElement())
{   
    $prop346 = $get346prop->GetProperties(array("ID" => "ASC"), array('CODE' => 'DEYSTVUYUSHCHEE_VESHCHESTVO'));
} 
foreach($arResult["ITEMS"][$prop346['DEYSTVUYUSHCHEE_VESHCHESTVO']['ID']]['VALUES'] as  $key => $property346){
    $property346["VALUE"] = str_replace("*", "", $property346["VALUE"]);
    if(strripos($property346["VALUE"], "(")){
        $property346["VALUE"] = explode('(', $property346["VALUE"]);
        $property346["VALUE"] = trim($property346["VALUE"][0], " ");
        $arResult["ITEMS"][346]['VALUES'][$key]['VALUE'] = $property346['VALUE'];
    } else {
        $arResult["ITEMS"][346]['VALUES'][$key]['VALUE'] = $property346['VALUE'];
        }                
}