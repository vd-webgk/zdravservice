<?
namespace Webgk\Main\Iblock\catalog_1c;
use Webgk\Main\Iblock\Prototype;
use \Webgk\Main\Tools;
class catalog extends Prototype {
    public static function getInstance()
    {
        return parent::getInstance();
    }
    public function getXmlIdProperties($getBigDataElements){
        $explodeBigDataElements = explode(';', $getBigDataElements[0]);
        $ourAdditionalGetElement = array(
            "filter" => array('XML_ID' => $explodeBigDataElements),
            "select" => array("ID"),
            "cacheTime" => 3600,
        );
        $getBigDataAdditionalElements = $this -> getElements($ourAdditionalGetElement);
        return Tools::getAssocArrItemsKey($getBigDataAdditionalElements, "ID");
    } 
}