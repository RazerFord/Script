<?php

namespace app\Decode;

// use Illuminate\Support\Facades\Storage;

class DecodeFile implements IDecodeInterface, ISaveFile
{
    /**
     * Name of file.
     * 
     * @var string 
     */
    private string $name;

    /**
     * String in base64.
     * 
     * @var string 
     */
    private string $base64;

    /**
     * Extension of file
     * 
     * @var string
     */
    private string $extension;

    /**
     * Set string or extension.
     * 
     * @return bool
     */
    public function setBase64(string $str): bool
    {
        $pos = strpos($str, ',');
        $status = preg_match('/data:[@a-zA-Z]*\/(png|jpeg|jpg|mp4|webm|pdf|mp3|wav|doc|docx|xlsx|pptx|txt);base64/', substr($str, 0, $pos), $matches);
        if ($status == false) {
            return false;
        }
        $this->extension = $matches[1];
        $this->base64 = substr($str, $pos + 1);

        return true;
    }

    /**
     * Return file.
     * 
     * @return string
     */
    public function getFile(): string
    {
        return base64_decode($this->base64);
    }

    /**
     * Return extension file.
     * 
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * Get size of file.
     * 
     * @return int
     */
    public function getSize(): int
    {
        return mb_strlen($this->getFile(), '8bit');
    }

    /**
     * Save file.
     * 
     * @param string $directory
     * @param string $fileName
     * @return string
     */
    public function save(string $directory, string $fileName): string
    {
        $fileName = $fileName . '.' . $this->extension;
        $data = $this->getFile();

        if (!$data) {
            return false;
        }

        // $status = Storage::disk('s3')->put($fileName, $data, 'public');
        $path = $this->getPath($directory, $fileName);

        if (!$path) {
            return false;
        }
        // var_dump(file_put_contents('test' . $this->getExtension(), $data));
        if (!file_put_contents($path, $data)) {
            return false;
        }

        return ($_SERVER['SERVER_NAME']) . '/api/public/' . $directory . $fileName;
    }

    /**
     * Get path of file.
     * 
     * @param string $directory
     * @param string $fileName
     * @return mixed
     */
    private function getPath(string $directory, string $fileName)
    {
        if ($path = realpath('../storage/app')) {
            return $path . '/' . $directory . $fileName;
        }
        return false;
    }
}
