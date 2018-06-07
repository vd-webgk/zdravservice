<?php 

namespace Webgk\Main;
use Bitrix\Main\Loader;
use Bitrix\Main;
use Bitrix\Iblock;    
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity; 
class ClientInfoClass {
    
    function __construct()
    {
        \Bitrix\Main\Loader::includeModule('highloadblock');
    }
    
    public function ClientsInfo($phoneNumber = ""){
        $curl = curl_init();
    if (!empty($phoneNumber)) {
        $paramArr = json_encode(['phone' => $phoneNumber]);
    } else {
        return false;
    }
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
    $totalBalance = 0; 
    foreach ($clientInfo->attributes() as $attrKey => $attrVal) {
        if ($attrKey == "Number") {
            $clientInfoArr["PHONE_NUMBER"] = (string)$attrVal;
        }
    }

    foreach ($clientInfo->Balance as $cardBalance) {
        $totalBalance += floatval($cardBalance);
    }
    $clientInfoArr["USER_BALANCE"] = $totalBalance;  
    curl_close($curl);
    //if (CModule::IncludeModule('highloadblock')) {
    $hlblockId = HLBlockClass::gettingHLBlockId("ClientsBonusCards");
       $hlblock = HL\HighloadBlockTable::getById($hlblockId) -> fetch();
       $entity = HL\HighloadBlockTable::compileEntity($hlblock);
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
       if ($arRes = $resultData->Fetch()) {
           $result = $entity_data_class::update($arRes["ID"],
               array(
                   'UF_PHONE_NUMBER' => $clientInfoArr["PHONE_NUMBER"],
                   'UF_TOTAL_BALANCE' => $clientInfoArr["USER_BALANCE"],
                   'UF_TIMESTAMP_X' => time()
               )
           );
       } else {
           $result = $entity_data_class::add(
               array(
                   'UF_PHONE_NUMBER' => $clientInfoArr["PHONE_NUMBER"],
                   'UF_TOTAL_BALANCE' => $clientInfoArr["USER_BALANCE"],
                   'UF_TIMESTAMP_X' => time()
               )
           );
       }
    //}
    return $result;
    }

    public function checkUpdatedClientsInfo() {
      // if (CModule::IncludeModule('highloadblock')) {
          $hlblockId = HLBlockClass::gettingHLBlockId("ClientsBonusCards");
           $hlblock = HL\HighloadBlockTable::getById($hlblockId) -> fetch();
           $entity = HL\HighloadBlockTable::compileEntity($hlblock);
           $entity_data_class = $entity->getDataClass();
           $entity_table_name = $hlblock["TABLE_NAME"];
           $sTableID = 'tbl_'.$entity_table_name;
           $resultData = $entity_data_class::getList(
               array(
                    "select" => array("*"),
                    "filter" => array(">UF_TIMESTAMP_X" => time() - 86400),
                    "limit" => 100
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
}