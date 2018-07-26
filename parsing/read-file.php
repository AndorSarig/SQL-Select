<?php

/**
 * Reads file content and returns an array containing its lines.
 *
 * @param string $filename
 * @return array
 */

function readTableContent(string $filename) : array
{
    return file($filename, FILE_IGNORE_NEW_LINES);
}

/**
 * Extracts column names (first line of file) from content read from file.
 *
 * @param array $tableContent
 * @return array
 */

function getColumnsName(array $tableContent) : array
{
    return explode(",", $tableContent[0]);
}

/**
 * Deletes the first line containing column names and returns each line as an associative array with column names as
 * indexes.
 *
 * @param array $tableContent
 * @param array $columnNames
 * @return array
 */

function getTableContent(array $tableContent, array $columnNames) : array
{
    unset($tableContent[0]);
    foreach ($tableContent as $lineNr => $line) {
        $tableContent[$lineNr] = array_combine($columnNames, explode(",", $line));
    }
    return $tableContent;
}