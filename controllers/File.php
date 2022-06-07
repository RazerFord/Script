<?php

namespace app\controllers;

use app\Decode\DecodeFile;

class File
{
    public function SaveLecture()
    {
        return $this->save('lectures/');
    }

    public function SaveCourse()
    {
        return $this->save('courses/');
    }

    public function DeleteFile()
    {
        return $this->delete();
    }

    public function test()
    {
        return response(true, 'Hello, world!', null, 200);
    }

    private function save(string $dir)
    {
        $request = request();

        $file = isset($request['file']) ? $request['file'] : null;

        if (empty($file)) {
            return response(false, 'attribute file must not be empty', null, 422);
        }

        if (!is_string($file)) {
            return response(false, 'attribute file must be string', null, 422);
        }

        $fileDecoder = new DecodeFile();

        if (!$fileDecoder->setBase64($file)) {
            return response(false, 'invalid base64', null, 422);
        }

        if ($fileDecoder->getSize() / 1024 / 1024 / 1024.0 > 1) {
            return response(false, 'max size file 1 GB', null, 422);
        }

        $name = microtime(true) . str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $path = $fileDecoder->save($dir, $name);

        return response(true, 'file saved', ['path' => $path], 200);
    }

    public function delete()
    {
        if (in_array($_SERVER['REMOTE_ADDR'], ['92.63.64.239', '95.170.145.167'])) {
        }
        $path = request()['path'] ?? null;

        if (empty($path)) {
            return response(false, 'path must be requied', null, 422);
        }

        // if (preg_match(/$path/)) {
            // return response(false, 'path must be requied', null, 422);
        // }

        die(file_exists($path));
    }
}