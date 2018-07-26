<?php

/**
 * Gets unique values from all lines for specific column and according to the keys and values returned from
 * getUniqueElements() function keeps correct lines.
 *
 * @param array $tableContent
 * @param string $column
 * @return array
 */

function unique(array $tableContent, string $column) : array
{
    $uniqueRows = getUniqueElements($tableContent, $column);
    foreach ($uniqueRows as $key => $row) {
        $uniqueRows[$key] = $tableContent[$key];
    }
    return $uniqueRows;
}

/**
 * Gets the values of column which the --unique option is applied to and returns it's unique values.
 *
 * @param array $tableContent
 * @param string $column
 * @return array
 */

function getUniqueElements(array $tableContent, string $column) : array
{
    $unique = [];
    foreach ($tableContent as $key => $row) {
        $unique[$key] = $row[$column];
    }
    return array_unique($unique);
}
