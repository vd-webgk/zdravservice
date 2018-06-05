<?php 

namespace Webgk\Main;
use Bitrix\Main\Loader;
use Bitrix\Main;
use Bitrix\Iblock;    
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity; 
Class gettingClientsInfo {
    
    public static function ClientsInfo($phoneNumber = ""){
        \Bitrix\Main\Loader::includeModule('highloadblock');
        $curl = curl_init();
    if (strlen($phoneNumber) > 0) {
        $paramArr = json_encode(['phone' => $phoneNumber]);
    } else {
        $paramArr = "";
    }
    // Определение параметров. Ссылку (куда будет делаться запрос), какие заголовки будут у этого запроса, задаем, что запрос должен быть в формате POST и передаем параметры этого запроса в виде массива 'ключ' => 'значение'. 
    //описание возможных параметров описано вот здесь http://php.net/manual/ru/function.curl-setopt.php
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1, //1 - возврат результата в виде строки, 0 - вывод результата в браузер
        CURLOPT_URL => 'https://ws2.tvojdoktor.ru/Monitoring/hs/Web/GetPhone', //урл для запроса
        CURLOPT_PORT => 333,
        CURLOPT_POST => 1, //метод POST
        CURLOPT_USERPWD => "robot1C:Sa1ch34ee9",
        CURLOPT_POSTFIELDS => $paramArr
    ]);
    // Отправляем запроса и сохраняем его в $res
    $res = curl_exec($curl);
    $clientInfo = simplexml_load_string($res);
    $clientInfoArr = array();
    // Закрываем запрос и удаляем инициализацию $curl
    $cardNumber = "";
    foreach ($clientInfo->Card->attributes() as $attrKey => $attrVal) { 
        if ($attrKey == "Kod") {
            $clientInfoArr["CARD_NUMBER"] = $attrVal;
        }
    }
    foreach ($clientInfo->attributes() as $attrKey => $attrVal) {
        if ($attrKey == "Number") {
            $clientInfoArr["PHONE_NUMBER"] = $attrVal;
        }
    }
    $clientInfoArr["CARD_BALANCE"] = (string)$clientInfo->Balance[0];  
    curl_close($curl);
    //if (CModule::IncludeModule('highloadblock')) {
       $entity = HL\HighloadBlockTable::compileEntity(6);
       $hlblock = HL\HighloadBlockTable::getById(6) -> fetch();
       $entity_table_name = $hlblock["TABLE_NAME"];
       $sTableID = 'tbl_'.$entity_table_name;
       $entity_data_class = $entity->getDataClass(); 
       $resultData = $entity_data_class::getList(
           array(
                "select" => array("*"),
                "filter" => array("UF_PHONE_NUMBER" => $clientInfoArr["PHONE_NUMBER"])
           )
       );
       $resultData = new \CDBResult($resultData, $sTableID);  
       if (empty($resultData)) {
           $result = $entity_data_class::add(
               array(
                   'UF_PHONE_NUMBER' => $clientInfoArr["PHONE_NUMBER"],
                   'UF_CARD_NUMBER' => $clientInfoArr["CARD_NUMBER"],
                   'UF_CARD_BALANCE' => $clientInfoArr["CARD_BALANCE"],
                   'UF_TIMESTAMP_X' => time()
               )
           );
       } else {
           while ($arRes = $resultData->Fetch()) {
               $result = $entity_data_class::update($arRes["ID"],
                   array(
                       'UF_PHONE_NUMBER' => $clientInfoArr["PHONE_NUMBER"],
                       'UF_CARD_NUMBER' => $clientInfoArr["CARD_NUMBER"],
                       'UF_CARD_BALANCE' => $clientInfoArr["CARD_BALANCE"],
                       'UF_TIMESTAMP_X' => time()
                   )
               );
           }
       }
       print_r($result);
    //}
    return $result;
    }
    
}

function checkingUpdatedClientsInfo() {
  // if (CModule::IncludeModule('highloadblock')) {
  \Bitrix\Main\Loader::includeModule('highloadblock');
       $hlblock = HL\HighloadBlockTable::getById(6) -> fetch();
       $entity_data_class = $hlblock->getDataClass();
       $entity_table_name = $hlblock["TABLE_NAME"];
       $sTableID = 'tbl_'.$entity_table_name;
       $resultData = $entity_data_class::getList(
           array(
                "select" => array("*"),
                "filter" => array(">TIMESTAMP_X" => time() - 86400)
           )
       );
       $resultData = new \CDBResult($resultData, $sTableID);
       $phonesArr = array();
       while ($arRes = $resultData->Fetch()) {
            $phonesArr[] = $arRes["UF_PHONE_NUMBER"];
       }
       foreach ($phonesArr as $phoneNumber) {
           $this->ClientsInfo($phoneNumber);
       }
  //  } 
}