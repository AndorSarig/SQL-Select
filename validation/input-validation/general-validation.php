<?php

/**
 * Collects and returns all the errors returned by specific functions which verifies mandatory/other option
 * dependent/validated by a regex options. At the end it also checks for empty options.
 *
 * @param array $options
 * @return string
 */

function optionsValidationFlow(array $options) : string
{
    $errors = [];
    foreach(VALIDATE_OPTIONS as $key => $validData) {
        $error = callFunctionForSpecificValidation($key, $validData, $options);
        if (!empty($error)) {
            array_push($errors, $error);
        }
    }
    return implode(PHP_EOL, $errors);
}

/**
 * Calls function for specific validation and returns all the errors occured.
 *
 * @param string $key
 * @param $validData
 * @param $options
 * @return string
 */

function callFunctionForSpecificValidation(string $key, array $validData, array $options) : string
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
 * @return string
 */

function verifyMandatoryOptions(array $options, array $validData) : string
{
    $errors = [];
    foreach($validData as $option) {
        if (!isset($options[$option]) || empty($options[$option])) {
            array_push($errors, "--$option not set and is mandatory!");
        }
    }
    return implode(PHP_EOL, $errors);
}

/**
 * Verifies if all options are set for an option which needs complementary options.
 * (Ex.: --aggregate-list-glue must be set if --aggregate-list is set.)
 *
 * @param array $options
 * @param array $validData
 * @return string
 */

function verifyIfComplementaryOptionsAreSet(array $options, array $validData) : string
{
    $errors = [];
    foreach ($validData as $option => $needle) {
        if (isset($options[$option]) && !isset($options[$needle])) {
            array_push($errors, "--$needle option missing (must be set if --$option is set)!");
        }
    }
    return implode(PHP_EOL, $errors);
}

/**
 * Verifies option values which can be verified with regex.
 *
 * @param array $options
 * @param array $validData
 * @return string
 */

function verifyOptionValuesWithRegex(array $options, array $validData) : string
{
    $errors = [];
    foreach ($validData as $option => $regexForOptionValue) {
        if (isset($options[$option]) && !preg_match($regexForOptionValue, $options[$option])) {
            array_push($errors, "Invalid or missing argument for --$option ($options[$option])!");
        }
    }
    return implode(PHP_EOL, $errors);
}

/**
 * Checks for empty option values.
 *
 * @param array $options
 * @return string
 */

function checkForEmptyOptions(array $options) : string
{
    $errors = [];
    foreach ($options as $option => $value) {
        if (empty($value)) {
            array_push($errors, "--$option is empty!");
        }
    }
    return implode(PHP_EOL, $errors);
}
