<?php
namespace Webgk\Main;

use Bitrix\Main\Loader;

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
    }
}