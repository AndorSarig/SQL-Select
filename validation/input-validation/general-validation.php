<?php

const VALIDATE_OPTIONS = array(
    "MANDATORY_OPTS" => array(
        "select",
        "from"
    ),
    "NEEDS_MORE_OPTS" => array(
        "aggregate-list" => "aggregate-list-glue",
        "multi-sort" => "multi-sort-dir",
        "map-function" => "map-function-column"
    ),
    "REGEX_VALIDATED_OPTS" => array(
        "sort-mode" => "/^natural|alphabetic|numeric$/",
        "sort-direction" => "/^asc|desc$/",
        "column-sort" => "/^asc|desc$/",
        "output" => "/^screen|csv$/",
        "where" => "/^((?:[^<>=]+)(?:(?:(?:<>){1})|(?:<|>|=)){1}(?:[^<>=]+))$/"
    )
);

/**
 * Collects and returns all the errors returned by specific functions which verifies mandatory/other option
 * dependent/validated by a regex options. At the end it also checks for empty options.
 *
 * @param array $options
 * @return array
 */

function optionsValidationFlow(array $options) : array
{
    $errors = [];
    foreach(VALIDATE_OPTIONS as $key => $validData) {
        $error = callFunctionForSpecificValidation($key, $validData, $options);
        if (!empty($error)) {
            $errors += $error;
        }
    }
    return $errors;
}

/**
 * Calls function for specific validation and returns all the errors occured.
 *
 * @param string $key
 * @param $validData
 * @param $options
 * @return array
 */

function callFunctionForSpecificValidation(string $key, array $validData, array $options) : array
{
    switch($key) {
        case 'MANDATORY_OPTS':
            return verifyMandatoryOptions($options, $validData);
        case 'NEEDS_MORE_OPTS':
            return verifyIfComplementaryOptionsAreSet($options, $validData);
        case 'REGEX_VALIDATED_OPTS':
            return verifyOptionValuesWithRegex($options, $validData);
    }
}

/**
 * Verifies if mandatory options are set.
 *
 * @param array $options
 * @param array $validData
 * @return array
 */

function verifyMandatoryOptions(array $options, array $validData) : array
{
    $errors = [];
    foreach($validData as $option) {
        if (!isset($options[$option]) || empty($options[$option])) {
            $errors[$option] = "--$option not set and is mandatory!";
        }
    }
    return $errors;
}

/**
 * Verifies if all options are set for an option which needs complementary options.
 * (Ex.: --aggregate-list-glue must be set if --aggregate-list is set.)
 *
 * @param array $options
 * @param array $validData
 * @return array
 */

function verifyIfComplementaryOptionsAreSet(array $options, array $validData) : array
{
    $errors = [];
    foreach ($validData as $option => $needle) {
        if (isset($options[$option]) && !isset($options[$needle])) {
            $errors[$needle] = "--$needle option missing (must be set if --$option is set)!";
        }
    }
    return $errors;
}

/**
 * Verifies option values which can be verified with regex.
 *
 * @param array $options
 * @param array $validData
 * @return array
 */

function verifyOptionValuesWithRegex(array $options, array $validData) : array
{
    $errors = [];
    foreach ($validData as $option => $regexForOptionValue) {
        if (isset($options[$option]) && !preg_match($regexForOptionValue, $options[$option])) {
            $errors[$option] = "Invalid or missing argument for --$option ($options[$option])!";
        }
    }
    return $errors;
}

/**
 * Checks for empty option values.
 *
 * @param array $options
 * @return array
 */

function checkForEmptyOptions(array $options) : array
{
    $errors = [];
    foreach ($options as $option => $value) {
        if (empty($value)) {
            $errors[$option] = "--$option is empty!";
        }
    }
    return $errors;
}
