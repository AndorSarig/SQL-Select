<?php

define("OPTIONS_NEED_SPEC_VAL", array(
    "multi-sort" => "validateColumnsGivenForOptions",
    "map-function-column" => "validateColumnsGivenForOptions",
    "select" => "validateSelect",
    "where" => "validateWhere",
    "power-values" => "validatePowerValues",
    "unique" => "validateColumnsGivenForOptions",
    "aggregate-sum" => "validateColumnsGivenForOptions",
    "aggregate-product" => "validateColumnsGivenForOptions",
    "aggregate-list" => "validateColumnsGivenForOptions",
    "sort-column" => "validateColumnsGivenForOptions",
    "uppercase-column" => "validateColumnsGivenForOptions",
    "lowercase-column" => "validateColumnsGivenForOptions",
    "titlecase-column" => "validateColumnsGivenForOptions"
));

/**
 * Starts option validation flow after parsing. Calls the function which verifies if the table is coherent and which
 * verifies other values given for options.
 *
 * @param array $tableContent
 * @param array $columns
 * @param array $options
 * @return string
 */

function validateAfterParsing(array $tableContent, array $columns, array $options) : array
{
    $error = isTableCoherent($tableContent, count($columns));
    if (!empty($error)) {
        return $error;
    }
    $error = validateColumnDependentOptions($columns, $options);
    if (!empty($error)) {
        return $error;
    }
    return [];
}

/**
 * Verifies if every line of the table contains as many fields as many columns is there.
 *
 * @param array $table
 * @param int $nrOfColumns
 * @return string
 */

function isTableCoherent(array $table, int $nrOfColumns) : array
{
    $error = [];
    foreach ($table as $rowNr => $row) {
        if (count($row) !== $nrOfColumns) {
            $error["table"] = "The table is not coherent! There is too much/few data in row nr $rowNr!";
        }
    }
    return $error;
}

/**
 * Calls specific function for every option where correct values depends on if the column set exists in the table or
 * not.
 *
 * @param array $columns
 * @param array $options
 * @return string
 */

function validateColumnDependentOptions(array $columns, array $options) : array
{
    $errors = [];
    foreach (OPTIONS_NEED_SPEC_VAL as $option => $functionToValidate) {
        if (isset($options[$option])) {
            $error =  OPTIONS_NEED_SPEC_VAL[$option]($options[$option], $columns);
            if (!empty($error)) {
                $errors[$option] = $error;
            }
        }
    }
    return $errors;
}

/**
 * Specific function for validating --select option's value. If it's not '*', it verifies if all the column names exist
 * in the table.
 *
 * @param string $columnsGiven
 * @param array $columns
 * @return string
 */

function validateSelect(string $columnsGiven, array $columns) : string
{
        if ($columnsGiven === '*') {
            return '';
        }
        return validateColumnsGivenForOptions($columnsGiven, $columns);
}

/**
 * Checks if value given for --where option has the correct form and calls the validateColumnsGivenForOptions() to check
 * if the column name given for it exists in the table.
 *
 * @param string $condition
 * @param array $columns
 * @return string
 */

function validateWhere(string $condition, array $columns) : string
{
    if (!preg_match('/^([^<>=]*)((?:(?:<>){1})|(?:<|>|=)){1}([^<>=]*)$/', $condition, $results)) {
        return "Value of --where option is not valid!";
    }
    return validateColumnsGivenForOptions($results[1], $columns);
}

/**
 * Separates the 2 values given for --power-value option and calls the function validateColumnsGivenForOptions() to
 * check if column name exists in the table.
 *
 * @param string $colPower
 * @param array $columns
 * @return string
 */

function validatePowerValue(string $colPower, array $columns) : string
{
    $exploded = explode(' ', $colPower);
    return validateColumnsGivenForOptions($exploded[0], $columns);
}

/**
 * Checks if column names given for options exists.
 *
 * @param string $columnsGiven
 * @param array $columns
 * @return string
 */

function validateColumnsGivenForOptions(string $columnsGiven, array $columns) : string
{
    foreach (explode(',', $columnsGiven) as $colName) {
        if (!in_array($colName, $columns)) {
            return "Column name '$colName' given does not exist in table!";
        }
    }
    return '';
}
