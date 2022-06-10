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
        //fiction
        $path = ["123", "123", "123", "https:\/\/file-upload-academy.s3.eu-central-1.amazonaws.com\/courses\/1653996440_1653996440\u041a\u0443\u0440\u0441\u043f\u043e\u0430\u043b\u0433\u043e\u0440\u0438\u0442\u043c\u0430\u043c.png", "\/api\/public\/courses\/1654569183.85muojidztcklwgx2vbqehparnsyf.xlsx", "\/api\/public\/courses\/1654569183.85muojidztcklwgx2vbqehparnsyf.png", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/courses\/1654569183.85muojidztcklwgx2vbqehparnsyf.png", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/courses\/1654659263.6279uhnzgqctwvpodksayebmxfirjl.png", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/courses\/1654659263.6279uhnzgqctwvpodksayebmxfirjl.png", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/courses\/1654569183.85muojidztcklwgx2vbqehparnsyf.png", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/courses\/1654745437.8943dcloxvnzhtfpykbusjwmaeigqr.png", "0.0.0.0:8081\/api\/public\/courses\/s.85muojidztcklwgx2vbqehparnsyf.png", "\/api\/public\/courses\/s.85muojidztcklwgx2vbqehparnsyf.png", "https:\/\/file-upload-academy.s3.eu-central-1.amazonaws.com\/courses\/1653733500_1653733500\u041d\u043e\u0432\u043e\u0435\u0438\u043c\u044f.png", "https:\/\/file-upload-academy.s3.eu-central-1.amazonaws.com\/courses\/1653996672_1653996672\u041d\u043e\u0432\u043e\u0435\u0438\u043c\u044f.png", "123", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "\/api\/public\/lectures\/1654569226.5763kvgmwurnqzspleoyhxbfdcatij.xlsx", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/lectures\/1654659263.6279uhnzgqctwvpodksayebmxfirjl.png", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/lectures\/1654659263.6279uhnzgqctwvpodksayebmxfirjl.png", "http:\/\/ec2-3-68-233-73.eu-central-1.compute.amazonaws.com:8080\/api\/public\/lectures\/1654659421.2535qbtnedacygkrumhwvxzifsoplj.xlsx"];
        // var_dump($path);
        ($this->getDirFiles(__DIR__ . '/../storage/app'));
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
            var_dump($info->getPathname());
            $files[] = $info->getPathname();
        }

        return $files;
    }
}
