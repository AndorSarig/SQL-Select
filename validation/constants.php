<?php

define("VALIDATE_OPTIONS", array(
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
));



define("SPECIFIC_OPTIONS", array(
    "from" => "validateFrom",
    "multi-sort" => "validateMultiSort",
    "output" => "validateOutput",
    "sort-column" => "validateSort"
));
