<?php
namespace Webgk\Main;

use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

/**
 * Основной класс модуля
 */
class Module {
    /**
     * Обработчик начала отображения страницы
     *
     * @return void
     */
    public static function onPageStart() {
        Loader::IncludeModule("webgk.main");

        self::setupEventHandlers();
        self::defineConstants();
    }

    protected static function setupEventHandlers()
    {
        $eventManager = EventManager::getInstance();

        // examples:
        // $eventManager->addEventHandler('main', 'OnEndBufferContent', ['Webgk\Main\Request', "saveBackUrl"]);
        // $eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ["\\Webgk\\Tools\\catalog\\CatalogSortProperties", "setSortProperties"]);
        // $eventManager->addEventHandler("iblock", "OnAfterIBlockElementAdd", ["\\Webgk\\Tools\\catalog\\CatalogSortProperties", "setSortProperties"]);

    }

    public static function defineConstants()
    {
        Hlblock\Prototype::defineConstants();
        Iblock\Prototype::defineConstants();
    }

}