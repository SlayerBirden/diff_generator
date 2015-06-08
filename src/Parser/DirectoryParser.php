<?php

namespace SlayerBirden\Parser;

class DirectoryParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse($input)
    {
        if (!file_exists($input) || !is_dir($input)) {
            throw new \InvalidArgumentException("Wrong input provided.");
        }
        /** @var \SplFileInfo[] $iterator */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($input, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        $directives = [];
        foreach ($iterator as $fileName => $file) {
            if (strpos($fileName, $input) === 0) {
                $fileName = str_replace($input, '', $fileName);
            }
            $fileName = ltrim($fileName, DIRECTORY_SEPARATOR);
            $directives[] = ['add', $fileName, $fileName];
        }
        return $directives;
    }
}
