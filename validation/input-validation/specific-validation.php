<?php

/**
 * Contains option names which requires some specific validations too.
 */

const SPECIFIC_OPTIONS = array(
    "from",
    "multi-sort",
    "output",
    "sort-column"
);

/**
 * Starts validation flow of all specific cases of options.
 *
 * @param array $options
 * @return array
 */

function specificOptionValidation(array $options) : array
{
    $errors = [];
    foreach (SPECIFIC_OPTIONS as $option => $functionToCall) {
        if (isset($options[$option])) {
            $error = $functionToCall($options);
            if (!empty($error)) {
                $errors[$option] = $error;
            }
        }
    }
    return $errors;
}

/**
 * Calls proper function for validating some options for specific cases.
 *
 * @param array $options
 * @param string $option
 * @return string
 */

function callSpecificValidatorForOption(array $options, string $option) : string {
    switch($option) {
        case 'from':
            return validateFrom($options);
        case 'multi-sort':
            return validateMultiSort($options);
        case 'output':
            return validateOutput($options);
        case 'sort-column':
            return validateSort($options);
    }
}

/**
 * Checks if the number of column names given to --multi-sort option is equal to --multi-sort-dir.
 *
 * @param array $options
 * @return string
 */

function validateMultiSort(array $options) : string
{
    if (isset($options["multi-sort-dir"]) && count(explode(',', $options["multi-sort"])) !==
        count(explode(',', $options["multi-sort-dir"]))) {
        return "At the --multi-sort option there is too much/few directions or column names!";
    }
    return '';
}

/**
 * Checks if file given to --from option exists.
 *
 * @param array $options
 * @return string
 */

function validateFrom(array $options) : string
{
    if (!file_exists($options["from"])) {
        return "File set for --from option does not exist!";
    }
    return '';
}

/**
 * Checks if the --output is set to csv and if the --output-file option is set.
 *
 * @param array $options
 * @return string
 */

function validateOutput(array $options) : string
{
    if ($options["output"] === "csv" && !isset($options["output-file"])) {
        return '--output option is set to csv, but --output-file is not defined!';
    }
return '';
}

/**
 * Checks if the number of columns to sort the table by is equal with the number of directions given to the
 * --multi-sort-dir option.
 *
 * @param array $options
 * @return string
 */

function validateSort(array $options) : string
{
    if (!isset($options["sort-mode"]) || !isset($options["sort-direction"])) {
        return 'Obligatory option missing for --sort-column! For more type --help!';
    }
    return '';
}