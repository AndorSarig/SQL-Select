<?php

/**
 * Calculates and adds sum of values of a column to the first row. Returns only the first row.
 *
 * @param array $tableContent
 * @param array $columns
 * @param string $columnToSum
 * @return array
 */

function aggregateSum(array $tableContent, string $columnToSum) : array
{
    $result = array_sum(array_column($tableContent, $columnToSum));
    $tableContent = array_slice($tableContent, 0, 1);
    $tableContent[0]["SUM($columnToSum)"] = $result;
    return $tableContent;
}

/**
 * Calculates and adds production of values of a column to the first row. Returns only the first row.
 *
 * @param array $tableContent
 * @param array $columns
 * @param string $columnToProduct
 * @return array
 */

function aggregateProduct(array $tableContent, string $columnToProduct) : array
{
    $result = array_product(array_column($tableContent, $columnToProduct));
    $tableContent = array_slice($tableContent, 0, 1);
    $tableContent[0]["PROD($columnToProduct)"] = $result;
    return $tableContent;
}

/**
 * Creates string from a column and adds it to the first row. Returns only the first row.
 *
 * @param array $tableContent
 * @param array $columns
 * @param string $columnToList
 * @param string $glue
 * @return array
 */

function aggregateList(array $tableContent, string $columnToList, string $glue) : array
{
    $result = array_reduce($tableContent, function ($carry, $current) use ($glue, $columnToList) {
        if (empty($carry)) {
            return $current[$columnToList];
        }
        $carry .= $glue . $current[$columnToList];
        return $carry;
    });
    $tableContent = array_slice($tableContent, 0, 1);
    $tableContent[0]["LIST($columnToList)"] = $result;
    return $tableContent;
}
