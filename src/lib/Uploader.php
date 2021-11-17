<?php

namespace App\lib;


class Uploader
{
    private string $destination;
    private string $fileName;
    private string $fileTempName;

    /**
     * Uploader constructor.
     * @param string $fileTempName
     * @param string $fileName
     */
    public function __construct(string $fileTempName, string $fileName)
    {
        $this->fileTempName = $fileTempName;
        $this->fileName = $fileName;
    }
    /**
     * @param string $uploadDir - dir where will moved file from temp dir on server
     * @return bool
     */
    public function uploadFile(string $uploadDir): bool
    {
        $this->destination = $uploadDir . '/' . $this->fileName;
        return move_uploaded_file($this->fileTempName, $this->destination);
    }

    public function getFilePath(): string
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}