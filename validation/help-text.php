<?php

define("HELP_TEXT", array(
    "a" => "Simple, procedural implementation of SQL SELECT query." . PHP_EOL
        . "OPTIONS:",
    "select" => "--select 'column names' - This option is mandatory and it requires the name of columns to be selected
    for query, each separated by a comma. For selecting all the columns write '*'.",
    "from" => "--from '.csv file name' - This option is mandatory and it requires a valid, existing .csv file name
    containing the database with the column names in the first line, each field separated by commas.",
    "output" => "--output screen|csv - This option is optional, it redirects the output either to a file, or to the 
    screen. By default it's value is screen. If csv is set, the --output-file option is required.",
    "output-file" => "--output-file '.csv file name' - Mandatory if the --output option is set to 'csv'. The output of
    the script will be written into the file given for this option",
    "sort-column" => "--sort-column 'column name' - Sorts the lines of the database according to this column. If this
    option is set, the --sort-mode and --sort-direction options are mandatory.",
    "sort-mode" => "--sort-mode natural|alpha|numeric - Mandatory if the --sort-column option is set. This option
    defines the sorting mode (If it's not obvious enough).",
    "sort-direction" => "--sort-direction asc|desc - This option is mandatory if --sort-column is set! Defines the 
    direction of sorting.",
    "multi-sort" => "--multi-sort 'column name 1, column name 2, etc' - Sorts the table's content according to multiple
    column values. If this option is set, the --multi-sort-dir option is mandatory and he two options must have the same
    number of comma separated values!",
    "multi-sort-dir" => "--multi-sort-dir 'asc|desc,asc|desc,etc.' - Mandatory if the --multi-sort option is set and he two options must have the same
    number of comma separated values! Sets the sort direction for each column.",
    "unique" => "--unique 'column name' - Keeps only the first occurence of each value in the given column.",
    "where" => "--where '[column name][<|>|<>|=][value]' - Keeps only those lines, where the column-value comparation
    evaluates to true.",
    "aggregate-sum" => "--aggregate-sum 'column name' - Sums up the values of the given column.",
    "aggregate-product" => "--aggregate-product 'column name' - Puts into a new column the product of all values from 
    the given column",
    "aggregate-list" => "--aggregate-list 'column name' - Lists values of the given column separated by value given to
    --aggregate-list-glue option. If this option is set, --aggregate-list-glue option is mandatory!",
    "aggregate-list-glue" => "--aggregate-list-glue [char] - Separator for values listed by --aggregate-list option.
    Mandatory if --aggregate-list option is set.",
    "uppercase-column" => "--uppercase-column 'column name' - Uppercases the values in the given column.",
    "lowercase-column" => "--lowercase-column 'column name' - Lowercases the values in the given column.",
    "titlecase-column" => "--titlecase-column 'column name' - Titlecases the values in the given column.",
    "power-values" => "--power-values '[column name][space][numeric value]' - Involves the values in the given column to
    the given power.",
    "map-function" => "--map-function 'function name' - Applies the given function to the column given to the
    --map-function-column option. The value given to this option must be the name of a .php (without the file extension)
    file which contains a function with the same name. If this option is set, the -- map-function-column option is
    mandatory!",
    "map-function-column" => "--map-function-column 'column name' - Mandatory if the --map-function option is set.
    Applies the function given to the --map-function option to the column name given to this function.",
    "column-sort" => "--column-sort asc|desc - Sorts columns according to the direction given to this option."
));

/**
 * Returns the required help message.
 *
 * @param $help
 * @return string
 */

function getHelpText($help) : string {
    if (empty($help)) {
        return implode(PHP_EOL,HELP_TEXT);
    }
    if (isset(HELP_TEXT[$help])) {
        return HELP_TEXT[$help];
    }
    return 'Invalid option name!';
}
