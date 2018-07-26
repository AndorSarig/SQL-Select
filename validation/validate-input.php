<?php

require 'constants.php';
require 'input-validation/general-validation.php';
require 'input-validation/specific-validation.php';
require 'help-text.php';

/**
 * Start options validation flow. Returns an array with errors if there are any.
 *
 * @param array $options
 * @return string
 */

function validateInput(array $options) : string{
    if (isset($options["help"])) {
        return getHelpText($options["help"]);
    }
    $errors = [];
    foreach (VALIDATION_FLOW as $functionToCall) {
        $error = $functionToCall($options);
        if (!empty($error)) {
            array_push($errors, $error);
        }
    }
    return implode(PHP_EOL, $errors);
}
