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
                $pattern = '#' . preg_quote($ignore, '#') . '#';
                $pattern = str_replace('\*', '.*', $pattern);
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
