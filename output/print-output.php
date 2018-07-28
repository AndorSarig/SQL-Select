<?php

/**
 * Function to decide where to print the output.
 *
 * @param array $result
 * @param array $options
 */

function printOutput(array $result, array $options)
{
    if (!isset($options["output"]) || $options["output"] === "screen") {
        printJson($result);
        return;
    }
    writeCsv($result, $options["output-file"]);
    return;
}

/**
 * Prints output to screen in JSON format.
 *
 * @param array $result
 */

function printJson(array $result)
{
    echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
}

/**
 * Prints output to file in CSV format.
 *
 * @param array $result
 * @param string $filename
 */

function writeCsv(array $result, string $filename)
{
    $file = fopen($filename, 'w');
    foreach ($result as $rowNumber => $row){
        $implodedRows[] = implode(',', $row);
    }
    $queryCsv = implode(PHP_EOL, $implodedRows);
    fwrite($file, $queryCsv);
    fclose($file);
}
