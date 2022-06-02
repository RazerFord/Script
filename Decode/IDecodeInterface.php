<?php

namespace app\Decode;

interface IDecodeInterface
{

    /**
     * Return file.
     * 
     * @return string
     */
    public function getFile(): string;

    /**
     * Return extension file.
     * 
     * @return string
     */
    public function getExtension(): string;
}
