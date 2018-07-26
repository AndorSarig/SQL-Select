<?php

define("SORT_MODE", array(
    "natural" => SORT_NATURAL,
    "numeric" => SORT_NUMERIC,
    "alph" => SORT_STRING
));

define("SORT_DIR", array(
    "asc" => SORT_ASC,
    "desc" => SORT_DESC
));

/**
 * Sorts table by values of a given column, according to the direction given.
 *
 * @param array $tableContent
 * @param string $column
 * @param string $mode
 * @param string $dir
 * @return array
 */

function sortByColumn(array $tableContent, string $column, string $mode, string $dir) : array
{
    $dir    = SORT_DIR[$dir];
    $mode   = SORT_MODE[$mode];
    array_multisort(array_column($tableContent, $column), $dir, $mode, $tableContent);
    return $tableContent;
}

/**
 * Sorts table by multiple values of columns given, according to the directions given.
 * @param array $tableContent
 * @param string $columnsToSort
 * @param array $columns
 * @param string $sortDirs
 * @return array
 */

function sortByMultipleColumns(array $tableContent, string $columnsToSort, array $columns, string $sortDirs) : array
{
    $parameters = [];
    $sortDirs   = explode(",", $sortDirs);
    foreach (explode(",", $columnsToSort) as $key => $columnName) {
        array_push($parameters, array_column($tableContent, $columns[$columnName]), SORT_DIR[$sortDirs[$key]]);
    }
    $parameters[] = &$tableContent;
    call_user_func_array('array_multisort', $parameters);
    return $tableContent;
}
