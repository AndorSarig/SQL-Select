<?php

// Contains function names according to operator given.

define("FILTER_FUNCTIONS", array(
    '<>' => 'notEqualFilter',
    '<' => 'smallerThanFilter',
    '>' => 'biggerThanFilter',
    '=' => 'equalFilter'
));

/**
 * Calls specific filter function for condition given for --where option. (Looks weird, but works.)
 *
 * @param array $tableContent
 * @param string $filterCondition
 * @param array $columns
 * @return array
 */

function filter(array $tableContent, string $filterCondition, array $columns) : array
{
    preg_match("/^([^<>=]*)((?:(?:<>){1})|(?:<|>|=)){1}([^<>=]*)$/", $filterCondition, $result);
    return FILTER_FUNCTIONS[$result[2]]($tableContent, $result[1], $result[3]);
}

/**
 * @param array $table
 * @param string $column
 * @param string $value
 * @return array
 */

function notEqualFilter(array $table, string $column, string $value) : array
{
    return array_filter($table, function($row) use ($column, $value) {
        if ($row[$column] !== $value) {
            return $row;
        }
    return 0;
    });
}

/**
 * @param array $table
 * @param string $column
 * @param string $value
 * @return array
 */

function smallerThanFilter(array $table, string $column, string $value) : array
{
    return array_filter($table, function($row) use ($column, $value) {
        if ($row[$column] < $value) {
            return $row;
        }
        return 0;
    });
}

/**
 * @param array $table
 * @param string $column
 * @param string $value
 * @return array
 */

function biggerThanFilter(array $table, string $column, string $value) : array
{
    return array_filter($table, function($row) use ($column, $value) {
        if ($row[$column] > $value) {
            return $row;
        }
        return 0;
    });
}

/**
 * @param array $table
 * @param string $column
 * @param string $value
 * @return array
 */

function equalFilter(array $table, string $column, string $value) : array
{
    return array_filter($table, function($row) use ($column, $value) {
        if ($row[$column] === $value) {
            return $row;
        }
        return 0;
    });
}