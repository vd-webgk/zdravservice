<?
use Webgk\Main\gettingClientsInfo;

function gettingClientsInfoAgent() {
if (gettingClientsInfo::ClientsInfo) {
    return true;
}    
}

AddEventHandler('main', 'OnAfterUserRegister', 'gettingNewClientInfo');

function gettingNewClientInfo(&$arFields) {
    $userInfo = CUser::GetByID($arFields["ID"]);
    while ($user = $userInfo -> Fetch()) {
        gettingClientsInfo::ClientsInfo($user["PERSONAL_PHONE"]);
    }
}
?>