<?php

require 'input-validation/general-validation.php';
require 'input-validation/specific-validation.php';
require 'help-text.php';

const VALIDATION_FLOW = array(
    'emptyOptions',
    'continueFlow',
    'validateSpecificCases'
);

/**
 * Start options validation flow. Returns an array with errors if there are any.
 *
 * @param array $options
 * @return array
 */

function validateInput(array $options) : array
{
    if (isset($options["help"])) {
        return getHelpText($options["help"]);
    }
    $errors = [];
    foreach (VALIDATION_FLOW as $stage) {
        $error = startValidation($options, $stage);
        if (!empty($error)) {
            $errors += $error;
        }
    }
    return $errors;
}

/**
 * Calls the appropiate function for the proper validation stage.
 *
 * @param array $options
 * @param string $stage
 * @return array
 */

function startValidation(array $options, string $stage) : array
{
    switch ($stage) {
        case 'emptyOptions':
            return checkForEmptyOptions($options);
        case 'continueFlow':
            return optionsValidationFlow($options);
        case 'validateSpecificCases':
            return specificOptionValidation($options);
    }
}
