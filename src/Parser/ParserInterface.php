<?php

namespace SlayerBirden\Parser;

interface ParserInterface
{
    /**
     * parse given input
     * @param mixed $input
     * @return array
     */
    public function parse($input);
}
