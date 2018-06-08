<?php 

namespace Webgk\Main;
use Bitrix\Main\Loader;
use Bitrix\Main as MainModule;
use Bitrix\Iblock;    
use Bitrix\Main\Entity;
use Bitrix\Main\Option;
use Webgk\Main\Hlblock\Prototype; 
class ClientInfoClass {
    
    public function ClientsInfo($phoneNumber = ""){
        $curl = curl_init();
    if (!empty($phoneNumber)) {
        $paramArr = json_encode(['phone' => $phoneNumber]);
    } else {
        return false;
    }
    $url = \COption::GetOptionString("grain.customsettings", "url"); 
    $login = \COption::GetOptionString("grain.customsettings", "login");
    $password = \COption::GetOptionString("grain.customsettings", "password");
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1, //1 - возврат результата в виде строки, 0 - вывод результата в браузер
        CURLOPT_URL => $url, //урл для запроса
        CURLOPT_PORT => 333,
        CURLOPT_POST => 1, //метод POST
        CURLOPT_USERPWD => $login.":".$password,
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

    $totalBalance = floatval($clientInfo->Balance[0]);
    $clientInfoArr["USER_BALANCE"] = $totalBalance;  
    curl_close($curl);
    $hlblock = Prototype::getInstance("ClientsBonusCards");
    
       $resultData = $hlblock->getElements(array(
                "select" => array("*"),
                "filter" => array("UF_PHONE_NUMBER" => $clientInfoArr["PHONE_NUMBER"])
           ));
       if (!empty($resultData)) {
           foreach ($resultData as $curResult) {
               
           $result = $hlblock->updateData($curResult["ID"], array(
                       'UF_PHONE_NUMBER' => $clientInfoArr["PHONE_NUMBER"],
                       'UF_TOTAL_BALANCE' => $clientInfoArr["USER_BALANCE"],
                       'UF_TIMESTAMP_X' => time()
                   ));
           }
       } else {
           
           $result = $hlblock->addData(array(
                       'UF_PHONE_NUMBER' => $clientInfoArr["PHONE_NUMBER"],
                       'UF_TOTAL_BALANCE' => $clientInfoArr["USER_BALANCE"],
                       'UF_TIMESTAMP_X' => time()
                   ));
       }
    //}
    $resultId = $result->getId();
    if ($resultId) {
        return $resultId;
    } else {
        return false;
    }
    }

    public function checkUpdatedClientsInfo() {
          
           $hlblock = Prototype::getInstance("ClientsBonusCards");
           $resultData = $hlblock->getElements(array(
                "select" => array("*"),
                "filter" => array(">UF_TIMESTAMP_X" => time() - 86400),
                "limit" => 100
           ));
           $phonesArr = array();
           foreach ($resultData as $curResult) {
                $phonesArr[] = $curResult["UF_PHONE_NUMBER"];
           }
           foreach ($phonesArr as $phoneNumber) {
               $this->ClientsInfo($phoneNumber);
           }
    }
}