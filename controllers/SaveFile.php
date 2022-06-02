<?php

namespace app\controllers;

use app\Decode\DecodeFile;

class SaveFile
{
    public function SaveLecture()
    {
        return $this->save('lectures/');
    }

    public function SaveCourse()
    {
        return $this->save('courses/');
    }

    public function test()
    {
        return response(true, 'Hello, world!', null, 200);
    }

    private function save(string $dir)
    {
        $file = request()['file'];

        if (empty($file)) {
            return response(false, 'attribute file must not be empty', null, 422);
        }

        if (!is_string($file)) {
            return response(false, 'attribute file must be string', null, 422);
        }

        $fileDecoder = new DecodeFile();

        if (!$fileDecoder->setBase64($file)) {
            response(false, 'invalid base64', null, 422);
        }

        if ($fileDecoder->getSize() / 1024 / 1024 / 1024.0 > 1) {
            response(false, 'max size file 1 GB', null, 422);
        }

        $name = microtime(true) . str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $path = $fileDecoder->save($dir, $name);

        return response(true, 'file saved', ['path' => $path], 200);
    }
}
