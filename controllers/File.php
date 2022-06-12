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
        return $this->saveFileForCourse();
    }

    public function DeleteFile()
    {
        return $this->delete();
    }

    public function DeleteFiles()
    {
        return $this->deletes();
    }

    public function test()
    {
        return response(true, 'Hello, world!', null, 200);
    }

    private function save(string $dir)
    {
        $request = request();

        $file = isset($request['file']) ? $request['file'] : null;

        if (is_string($file)) {
            return response(false, 'attribute file must not be string', null, 422);
        }

        if (empty($file)) {
            return response(false, 'attribute file must not be empty', null, 422);
        }

        if ($file['size'] / 1024 / 1024 / 1024.0 > 1) {
            return response(false, 'max size file 1 GB', null, 422);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!preg_match('/(png|jpeg|jpg|mp4|webm|pdf|mp3|wav|doc|docx|xlsx|pptx|txt)/', $extension)) {
            return response(false, 'invalid extension', null, 422);
        }

        $name = microtime(true) . str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $tmpName = $file["tmp_name"];
        move_uploaded_file($tmpName, __DIR__ . "/../storage/app/$dir/$name.$extension");
        $path = '/api/public/' . $dir  . $name . '.' . $extension;

        return response(true, 'file saved', ['path' => $path], 200);
    }

    public function delete()
    {
        $path = request()['path'] ?? null;

        if (empty($path)) {
            return response(false, 'path must be requied', null, 422);
        }

        if (!preg_match('/((lectures|courses)\/[0-9a-z.]*.(png|jpeg|jpg|mp4|webm|pdf|mp3|wav|doc|docx|xlsx|pptx|txt))$/', $path, $matches)) {
            return response(false, 'invalid format path', null, 422);
        }

        $path = '../storage/app/' . $matches[0];

        if (file_exists($path)) {
            unlink($path);
            return response(true, 'file deleted', null, 200);
        }

        return response(false, 'file not exists', null, 422);
    }

    public function deletes()
    {
        $paths = isset(request()['paths']) ? request()['paths'] : [];

        if (empty($paths) || !is_array($paths)) {
            return response(false, 'paths must be requied and array', null, 422);
        }

        foreach ($paths as $path) {
            $files[] = str_replace("https://avtospas.com/api/public/", "", $path);
        }

        $saveFiles = $this->getDirFiles(__DIR__ . '/../storage/app');

        if (empty($saveFiles)) {
            return response(false, 'path don\'t exist files', null, 422);
        }

        foreach ($saveFiles as $key1 => $saveFile) {
            foreach ($files as $key2 => $file) {
                if (strpos($saveFile, $file) !== false) {
                    unset($saveFiles[$key1]);
                    unset($files[$key2]);
                }
            }
        }

        foreach ($saveFiles as $saveFile) {
            if (is_file($saveFile)) {
                unlink($saveFile);
            }
        }

        return response(true, 'files deleted', null, 200);
    }

    /**
     * Получает пути всех файлов и папок в указанной папке.
     *
     * @param  string $dir             Путь до папки (на конце со слэшем или без).
     * @return array Вернет массив путей до файлов/папок.
     */
    function getDirFiles($dir)
    {
        $directory = new \RecursiveDirectoryIterator($dir);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = array();

        foreach ($iterator as $info) {
            $files[] = $info->getPathname();
        }

        return $files;
    }

    public function saveFileForCourse()
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

        if ($fileDecoder->getSize() / 1024 / 1024.0 > 30) {
            return response(false, 'max size file 1 GB', null, 422);
        }

        $name = microtime(true) . str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $path = $fileDecoder->save('courses/', $name);

        return response(true, 'file saved', ['path' => $path], 200);
    }
}
