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
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif (filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;

        if (!in_array($ip, ['92.63.64.239', '95.170.145.167', '192.168.144.4', '185.210.141.213'])) {
            return response(true,  $ip . ' unauthorized', null, 403);
        }

        $path = request()['path'] ?? null;

        if (empty($path)) {
            return response(false, 'path must be requied', null, 422);
        }
        // preg_match('/^\/api\/public\/((lectures|courses)\/[0-9a-z.]*.(png|jpeg|jpg|mp4|webm|pdf|mp3|wav|doc|docx|xlsx|pptx|txt))$/', $path, $matches);
        if (!preg_match('/^((lectures|courses)\/[0-9a-z.]*.(png|jpeg|jpg|mp4|webm|pdf|mp3|wav|doc|docx|xlsx|pptx|txt))$/', $path, $matches)) {
            return response(false, 'invalid format path', null, 422);
        }

        $path = '../storage/app/' . $matches[0];

        if (file_exists($path)) {
            unlink($path);
            return response(true, 'file deleted', null, 200);
        }

        return response(false, 'file not exists', null, 422);
    }
}
