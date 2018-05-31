<?php             

namespace Webgk\Main;

/**
 * Базовый каталог модуля
 */
use Bitrix\Main\Event;
const BASE_DIR = __DIR__;

$event = new Event('webgk.main', 'onModuleInclude');
$event->send();