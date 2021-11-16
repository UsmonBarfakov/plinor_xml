<?php

namespace App\Controllers;

use App\Lib\Uploader;
use App\Lib\Xml\XmlValidator;
use App\Models\FilesModel;
use App\Lib\FileValidator;
use App\Views\View;
use Exception;

class XmlHandler
{
    private $xPathQuery = XPATH_QUERY;
    protected FileValidator $fileValidator;
    private FilesModel $filesModel;
    private Uploader $uploader;

    public function __construct()
    {
        $this->filesModel = new FilesModel();
    }

    public function run()
    {
        if (!isset($_FILES['file']) || empty($_FILES['file'])) {
            $this->showError('Please, select file and upload it <a href="'.BASE_URL.'">here</a>');
            exit;
        }
        $this->fileValidator = new FileValidator($_FILES['file']['tmp_name'], $_FILES['file']['name']);

        try {
            if (!$this->fileValidator->isFileExists()) {
                throw new Exception('Error: There is no file exists!');
            }

            if (!$this->fileValidator->isFileXMLExtension('xml')) {
                throw new Exception('Error: File is not xml extension!');
            }

            $xml = $this->fileValidator->getXmlFromUploadedFile();
            $xmlValidator = new XmlValidator($xml, $this->xPathQuery);
            if (!$xmlValidator->isValid()) {
                throw new Exception("The XML file structure doesn't meet the requirements");
            }

            //Save - move file to upload folder
            $this->uploader = new Uploader($_FILES['file']['tmp_name'], $_FILES['file']['name']);
            if (!$this->uploader->uploadFile(UPLOAD_DIR)) {
                throw new Exception("Error: Can't save file!");
            }

            //Check file to early added. If yes, it's mean that file was updated
            $result = $this->filesModel->select('*', "file_name = '{$this->uploader->getFileName()}'");
            if ($result) {
                //update exist file in DB
                $currentDate = date('Y-m-d H:i:s');
                $this->filesModel->update([
                    'updated_at' => "'{$currentDate}'"
                ], "id = {$result[0]['id']}");

            } else {
                //insert file name to BD
                $this->filesModel->insert([
                    'file_name' => "'" . $this->uploader->getFileName() . "'",
                    'file_path' => "'" . $this->uploader->getFilePath() . "'",
                ]);
            }

            $fileTable = new Table();
            $fileTable->run();

        } catch (Exception $e) {
            $this->showError($e->getMessage());
        }
    }

    public function showError(string $text):void
    {
        $view = new View();
        $view->render('error', [
            'title' => 'Ой! Произошла ошибка',
            'msg' => $text
        ]);
    }
}