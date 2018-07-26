<?php

require 'validation/validate-input.php';
require 'validation/validate-after-parseing.php';
require 'parsing/read-file.php';
require 'filtering/where.php';
require 'filtering/unique.php';
require 'data-transformation/sort.php';
require 'data-transformation/function_mapping.php';
require 'data-transformation/aggregation.php';
require 'data-transformation/case-modifier.php';
require 'output/prepare-output.php';
require 'output/print-output.php';

define("FLOW", array(
    "where",
    "unique",
    "sort-column",
    "multi-sort",
    "map-function",
    "aggregate-sum",
    "aggregate-product",
    "aggregate-list",
    "uppercase-column",
    "lowercase-column",
    "titlecase-column",
    "power-values",
    "column-sort",
    "select"
));

selectQuery();

/**
 * Query flow controller.
 */

function selectQuery() : void
{
    $options = getOptions();
    $errors = validateInput($options);
    if (!empty($errors)) {
        printErrors($errors);
        return;
    }
    $tableContent = readTableContent($options["from"]);
    $columns = getColumnsName($tableContent);
    $tableContent = getTableContent($tableContent, $columns);
    $errors = validateAfterParsing($tableContent, $columns, $options);
    if (!empty($errors)) {
        printErrors($errors);
        return;
    }
    $finalQuery = startQueryFlow($tableContent, $options, $columns);
    printResult($finalQuery, $options);
    return;
}

/**
 * Reads the options given in command line.
 *
 * @return array
 */

function getOptions() : array
{
    return getopt("", [
        "help::",
        "select:",
        "from:",
        "output:",
        "output-file:",
        "sort-column:",
        "sort-mode:",
        "sort-direction:",
        "multi-sort:",
        "multi-sort-dir:",
        "unique:",
        "where:",
        "aggregate-sum:",
        "aggregate-product:",
        "aggregate-list:",
        "aggregate-list-glue:",
        "uppercase-column:",
        "lowercase-column:",
        "titlecase-column:",
        "power-values:",
        "map-function:",
        "map-function-column:",
        "column-sort:"
    ]);
}

/**
 * Applies options to the table data.
 *
 * @param array $tableContent
 * @param array $options
 * @param array $columns
 * @return array
 */

function startQueryFlow(array $tableContent, array $options, array $columns) : array
{
    foreach (FLOW as $optionToApply) {
        if (isset($options[$optionToApply])) {
            $tableContent = callFunctionForOption($tableContent, $columns, $optionToApply, $options);
        }
    }
    return $tableContent;
}

/**
 * Calls the corresponding function for an option.
 *
 * @param array $tableContent
 * @param array $columns
 * @param string $option
 * @param array $options
 * @return array
 */

function callFunctionForOption(array $tableContent, array $columns,  string $option, array $options) : array
{
    switch($option) {
        case 'where':
            return filter($tableContent, $options[$option], $columns);
        case 'unique':
            return unique($tableContent, $options[$option]);
        case 'sort-column':
            return sortByColumn($tableContent, $options[$option], $options["sort-mode"], $options["sort-direction"]);
        case 'multi-sort':
            return sortByMultipleColumns($tableContent, $options[$option], $columns, $options["multi-sort-dir"]);
        case 'map-function':
            return functionMapping($tableContent, $columns[$options["map-function-column"]], $options[$option]);
        case 'uppercase-column':
            return uppercaseColumn($tableContent, $options[$option]);
        case 'lowercase-column':
            return lowercaseColumn($tableContent, $options[$option]);
        case 'titlecase-column':
            return titlecaseColumn($tableContent, $options[$option]);
        case 'power-values':
            return powerValueColumn($tableContent, $options[$option]);
        case 'aggregate-sum':
            return aggregateSum($tableContent, $options[$option]);
        case 'aggregate-product':
            return aggregateProduct($tableContent, $options[$option]);
        case 'aggregate-list':
            return aggregateList($tableContent, $options[$option], $options["aggregate-list-glue"]);
        case 'column-sort':
            return sortColumns($tableContent, $options[$option]);
        case 'select':
            return selectColumns($tableContent, $columns, $options["select"]);
    }
}
