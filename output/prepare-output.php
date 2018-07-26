<?php

/**
 * Sorts column order according to the direction given.
 *
 * @param array $tableContent
 * @param string $direction
 * @return array
 */

function sortColumns(array $tableContent, string $direction) : array
{
    foreach ($tableContent as $rowNumber => $row) {
        if ($direction === "asc") {
            ksort($tableContent[$rowNumber]);
        }
        if ($direction === "desc") {
            krsort($tableContent[$rowNumber]);
        }
    }
    return $tableContent;
}

/**
 * Unsets columns which are not given to the --select option.
 *
 * @param array $tableData
 * @param array $columns
 * @param string $select
 * @return array
 */

function selectColumns(array $tableData, array $columns, string $select) : array
{
    if ($select === '*') {
        return $tableData;
    }
    $columnsToSelect = explode(',', $select);
    foreach ($tableData as $rowNr => $row) {
        foreach ($row as $colName => $value) {
            if (!in_array($colName, $columnsToSelect) && in_array($colName, $columns)) {
                unset($row[$colName]);
            }
        }
        $tableData[$rowNr] = $row;
    }
    return $tableData;
}



