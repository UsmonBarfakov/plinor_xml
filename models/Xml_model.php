<?php
namespace App\Models\Xml;

use Exception;

class Xml_model
{
    private string $fileTempName;
    private string $fileName;
    private string $destination;

    public function __construct(string $tmp_name, string $name)
    {
        $this->fileTempName = $tmp_name;
        $this->fileName = $name;
    }

    /**
     * @return bool
     */
    public function isFileExists(): bool
    {
        return file_exists($this->fileTempName);
    }

    /**
     * Checked for is file xml extension or not
     * @param string $ext
     * @return bool
     */
    function isFileXMLExtension(string $ext): bool
    {
        $extension = pathinfo($this->fileName, PATHINFO_EXTENSION);//function returned string or array
        return $extension == $ext;//because previous comment here used in_array()
    }

    /**
     * Extract file data and create SimpleXMLElement
     * @return false|\SimpleXMLElement
     * @throws Exception
     */
    function getXmlFromUploadedFile()
    {
        $xml = simplexml_load_file($this->fileTempName);
        if ($xml == false) {
            throw new Exception('File loading error: file has incorrect XML structure!');
        }
        return $xml;
    }

    /**
     * @param string $uploadDir - dir where will moved file from temp dir on server
     * @return bool
     */
    public function saveXmlFile(string $uploadDir): bool
    {
        $this->destination = $uploadDir . '/' . $this->fileName;
        return move_uploaded_file($this->fileTempName, $this->destination);
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFilePath(): string
    {
      return $this->destination;
    }


}