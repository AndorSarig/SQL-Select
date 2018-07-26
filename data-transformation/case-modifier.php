<?php

/**
 * Modifies values of a column to uppercase.
 *
 * @param array $tableContent
 * @param string $column
 * @return array
 */

function uppercaseColumn(array $tableContent,  string $column) : array
{
    array_walk($tableContent, function (&$row) use ($column) {
        $row[$column] = strtoupper($row[$column]);
    });
    return $tableContent;
}

/**
 * Modifies values of a column to lowercase.
 *
 * @param array $tableContent
 * @param string $column
 * @return array
 */

function lowercaseColumn(array $tableContent, string $column) : array
{
    array_walk($tableContent, function (&$row) use ($column) {
        $row[$column] = strtolower($row[$column]);
        return $row;
    });
    return $tableContent;
}

/**
 * Modifies values of a column to titlecase.
 *
 * @param array $tableContent
 * @param string $column
 * @return array
 */

function titlecaseColumn(array $tableContent, string $column) : array
{
    array_walk($tableContent, function (&$row) use ($column) {
        $row[$column] = ucwords($row[$column]);
        return $row;
    });
    return $tableContent;
}

/**
 * Adds column with the value involved to the given power.
 *
 * @param array $tableContent
 * @param string $inputData
 * @return array
 */

function powerValueColumn(array $tableContent, string $inputData) : array
{
    $inputData  = explode(' ', $inputData);
    $column     = $inputData[0];
    $power      = $inputData[1];
    array_walk($tableContent, function (&$row) use ($column, $power) {
        $row["POWER_VAl($column)"] = pow($column, $power);
        return $row;
    });
    return $tableContent;
}
