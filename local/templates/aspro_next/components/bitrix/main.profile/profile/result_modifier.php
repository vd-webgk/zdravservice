<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arResult["BONUS_BALANCE"] = "";
if (!empty($arResult["arUser"]["PERSONAL_PHONE"])) {
    $hlblock = Prototype::getInstance("ClientsBonusCards");
    $resultData = $hlblock->getElements(array(
        "select" => array("*"),
        "filter" => array("UF_PHONE_NUMBER" => "+".$arResult["arUser"]["PERSONAL_PHONE"])
    ));
    if (!empty($resultData)) {
        $arResult["BONUS_BALANCE"] = $resultData[0]["UF_TOTAL_BALANCE"];
    }
}
?>