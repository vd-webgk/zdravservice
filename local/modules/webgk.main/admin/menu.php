<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$menu = array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 400,
        'text' => Loc::getMessage('GKMAIN_MENU_TITLE'),
        'title' => Loc::getMessage('GKMAIN_MENU_TITLE'),
        'url' => 'webgk.main_index.php',
        'items_id' => 'menu_references',
        'items' => array(
            array(
                'text' => Loc::getMessage('GKMAIN_SUBMENU_TITLE'),
                'url' => 'webgk.main_index.php?param1=paramval&lang=' . LANGUAGE_ID,
                'more_url' => array('webgk.main_index.php?param1=paramval&lang=' . LANGUAGE_ID),
                'title' => Loc::getMessage('GKMAIN_SUBMENU_TITLE'),
            ),
        ),
    ),
);

return $menu;
