<?php

namespace SlayerBirden\Util;

class Filter
{
    /**
     * Filter directives by ignores
     * Supports next constructions:
     * name/* --> root directory
     * *\/name/* --> intermediate directory
     * *\/name -> filename
     * name -> full file name
     *
     * @param array $directives
     * @param array $ignores
     * @return array filtered directives
     */
    public function getFiltered(array $directives, array $ignores)
    {
        $files = array_map(function ($row) {
            return $row[2];
        }, $directives);

        foreach ($ignores as $ignore) {
            $i = 0;
            foreach ($files as $file) {
                if (substr($ignore, 0, 1) === '*') {
                    // first char's wildcard
                    $pattern = '#.*' . preg_quote(substr($ignore, 1), '#') . '$#';
                } elseif (substr($ignore, -1) === '*') {
                    // last char's wildcard
                    $pattern = '#^' . preg_quote(substr($ignore, 0, -1), '#') . '.*#';
                } else {
                    $pattern = '#^' . preg_quote($ignore, '#') . '$#';
                }
                if (preg_match($pattern, $file)) {
                    unset($directives[$i]);
                }
                $i++;
            }
        }
        // reindex prior to returning
        return array_values($directives);
    }
}
