<?php

/**
 * Requires file where the user function can be found and then applies the function to the values of the given column.
 *
 * @param array $tableContent
 * @param int $columnToMap
 * @param string $function
 * @return array
 */

function functionMapping(array $tableContent, int $columnToMap, string $function) : array {
    require "$function.php";
    return array_map(function (array $row) use ($columnToMap, $function) : array {
        $row[$columnToMap] = $function($row[$columnToMap]);
        return $row;
    }, $tableContent);
}