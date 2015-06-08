<?php

namespace SlayerBirden\Dumper;

class FileDumper implements DumperInterface
{
    /**
     * @var resource
     */
    protected $file;

    /**
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->file = new \SplFileObject($fileName, 'w');
    }

    /**
     * {@inheritdoc}
     */
    public function dump(array $directives)
    {
        foreach ($directives as $row) {
            $this->file->fputcsv($row);
        }
    }
}
