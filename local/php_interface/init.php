<?
use Webgk\Main\ClientInfoClass;

function gettingClientsInfoAgent() {
if (ClientInfoClass::checkUpdatedClientsInfo) {
    return "gettingClientsInfoAgent();";
}    
}

AddEventHandler('main', 'OnAfterUserRegister', 'gettingNewClientInfo');

function gettingNewClientInfo(&$arFields) {
    $userInfo = CUser::GetByID($arFields["ID"]);
    while ($user = $userInfo -> Fetch()) {
        if ($user["PERSONAL_PHONE"]) {
            ClientInfoClass::ClientsInfo($user["PERSONAL_PHONE"]);
        }
    }
}
?>