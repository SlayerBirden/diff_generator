<?php

namespace SlayerBirden\Dumper;

interface DumperInterface
{
    /**
     * dump directives
     * @param array $directives
     * @return mixed
     */
    public function dump(array $directives);
}
