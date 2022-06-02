<?php

namespace app\Decode;

interface ISaveFile
{

    /**
     * Save file.
     * 
     * @param string $directory
     * @param string $fileName
     * @return string
     */
    public function save(string $directory, string $fileName) :string;
}
