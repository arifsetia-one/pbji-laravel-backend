<?php

namespace App\Helpers;

class UtilityHelper
{

    /**
     * Maps an array to a string using the given template.
     *
     * @param array $array The array to map.
     * @param string $template The template to use for mapping. Defaults to '%s: %s'.
     *
     * @return array An array of strings mapped from the given array.
     */
    static function mapArrayToString($array = [], $template = '%s: %s')
    {
        return array_map(function ($value, $key) use ($template) {
            return $template ? sprintf($template, $key, $value) : $value;
        }, $array, array_keys($array));
    }

    /**
     * Generates a PostgreSQL CASE statement for a given array, column name and suffix.
     *
     * @param array $array An array of codes and labels.
     * @param string $column The name of the column to use in the statement.
     * @param string $suffix The suffix to append to the column name.
     *
     * @return string A CASE statement as a string.
     */
    static function getCaseStatement($array = [], $column = 'table.column_name', $suffix = '_label')
    {
        $statement = "CASE\n";
        foreach ($array as $code => $label) {
            $statement .= "WHEN {$column} = '{$code}' THEN '{$label}'\n";
        }

        $asLabel = @explode('.', $column)[1];
        $statement .= "END as {$asLabel}{$suffix}";
        return $statement;
    }

    /**
     * Get url from path. If url is valid, return url. If not, return url from storage.
     *
     * @param string $path Path to file
     *
     * @return string URL generated
     */

    static function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return filter_var($path, FILTER_VALIDATE_URL) ? $path : url('storage/' . $path);
    }
}
