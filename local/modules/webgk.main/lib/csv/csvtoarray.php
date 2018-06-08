<?php

namespace Webgk\Main\CSV;

use Webgk\Main\Tools;
use Webgk\Main\Exception;

/**
 *
 */
class CSVToArray
{

    public function CSVParse($file, $hasFieldNames = false, $delimiter = ',', $enclosure='"')
    {

        $result = [];
        $file = $_SERVER['DOCUMENT_ROOT']."/".$file;

        if (!file_exists($file)) {
            throw new Exception("Неверный файл");
        }

        $file = fopen($file, 'r');

        if ($hasFieldNames) {

            if (is_array($hasFieldNames)) {
                $keys = $hasFieldNames;
            } else {
                $keys = fgetcsv($file, 0, $delimiter, $enclosure);
            }
        }

        while (($row = fgetcsv($file, 0, $delimiter, $enclosure)) !== false) {
            $n = count($row); $res=array();
            for($i = 0; $i < $n; $i++) {
                if ($hasFieldNames && isset($keys[$i])) {
                    $idx = $keys[$i];
                } else {
                    $idx = $i;
                }

                // $idx = ($hasFieldNames) ? $keys[$i] : $i;
                $res[$idx] = $row[$i];
            }
            $result[] = $res;
        }

        fclose($file);
        return $result;
    }

}
