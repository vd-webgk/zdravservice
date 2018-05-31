<?php

    use Bitrix\Main\Application;
    use Bitrix\Main\Loader;
    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\ModuleManager;

    Loc::loadMessages(__FILE__);

    class webgk_main extends CModule
    {
        public function __construct()
        {
            $arModuleVersion = array();

            include __DIR__ . '/version.php';

            if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
            {
                $this->MODULE_VERSION = $arModuleVersion['VERSION'];
                $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
            }

            $this->MODULE_ID = 'webgk.main';
            $this->MODULE_NAME = Loc::getMessage('GKMAIN_MODULE_NAME');
            $this->MODULE_DESCRIPTION = Loc::getMessage('GKMAIN_MODULE_DESCRIPTION');
            $this->MODULE_GROUP_RIGHTS = 'N';
            $this->PARTNER_NAME = Loc::getMessage('GKMAIN_MODULE_PARTNER_NAME');
            $this->PARTNER_URI = 'http://webgk.ru';

            $this->eventHandlers = array(
                array(
                    'main',
                    'OnPageStart',
                    '\Webgk\Main\Module',
                    'onPageStart',
                )
            );
        }

        /**
        * Устанавливает события модуля
        *
        * @return boolean
        */
        public function installEvents()
        {
            $eventManager = \Bitrix\Main\EventManager::getInstance();

            foreach ($this->eventHandlers as $handler) {
                $eventManager->registerEventHandler($handler[0], $handler[1], $this->MODULE_ID, $handler[2], $handler[3]);
            }

            return true;
        }


        /**
        * Удаляет события модуля
        *
        * @return boolean
        */
        public function unInstallEvents()
        {
            $eventManager = \Bitrix\Main\EventManager::getInstance();

            foreach ($this->eventHandlers as $handler) {
                $eventManager->unRegisterEventHandler($handler[0], $handler[1], $this->MODULE_ID, $handler[2], $handler[3]);
            }

            return true;
        }


        /**
        * Устанавливает модуль
        *
        * @return void
        */
        public function DoInstall()
        {
            if ($this->installEvents()) {
                \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
            }
        }

        /**
        * Удаляет модуль
        *
        * @return void
        */
        public function DoUninstall()
        {
            if ($this->unInstallEvents()) {
                \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
            }
        }  

    }
