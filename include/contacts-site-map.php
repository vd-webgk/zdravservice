<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view",
	"",
	Array(
		"CONTROLS" => array("ZOOM","TYPECONTROL","SCALELINE"),
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:55.73854169429274;s:10:\"yandex_lon\";d:37.59796485627498;s:12:\"yandex_scale\";i:11;s:10:\"PLACEMARKS\";a:2:{i:0;a:3:{s:3:\"LON\";d:37.610560509809;s:3:\"LAT\";d:55.751516980843;s:4:\"TEXT\";s:12:\"точка 1\";}i:1;a:3:{s:3:\"LON\";d:37.606376263746;s:3:\"LAT\";d:55.75253956872;s:4:\"TEXT\";s:12:\"точка 2\";}}}",
		"MAP_HEIGHT" => "500",
		"MAP_ID" => "",
		"MAP_WIDTH" => "100%",
		"OPTIONS" => array("ENABLE_DBLCLICK_ZOOM","ENABLE_DRAGGING")
	)
);?>