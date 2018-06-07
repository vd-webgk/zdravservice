<?php

namespace Webgk\Main\CSV;

use Webgk\Main\Tools;

/**
 *
 */
class CSVToArray
{

    public function CSVParse($file, $index = '', $hasFieldNames = false, $delimiter = ',', $enclosure='"')
    {

        $result = [];
        $file = $_SERVER['DOCUMENT_ROOT']."/".$file;

        if (!file_exists($file)) {
            throw new Exception("Неверный файл");
        }

        $file = fopen($file, 'r');

        if ($hasFieldNames) {

            $keys = fgetcsv($file, 0, $delimiter, $enclosure);
            print_r($keys);
        }
        while (($row = fgetcsv($file, 0, $delimiter, $enclosure)) !== false) {
            $n = count($row); $res=array();
            for($i = 0; $i < $n; $i++) {
                $idx = ($hasFieldNames) ? $keys[$i] : $i;
                $res[$idx] = $row[$i];
            }
            $result[] = $res;
        }

        if (strlen($index) > 0) {
            $result = Tools::getIndexedArray($result,$index);
        }
        fclose($file);
        return $result;
    }

}
