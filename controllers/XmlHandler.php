<?php

namespace App\Controllers;

use App\Lib\Xml\XmlValidator;
use App\Models\FilesModel;
use App\Models\Xml\Xml_model;
use App\Views\View;
use Exception;

class XmlHandler
{
    private $xPathQuery = XPATH_QUERY;
    private Xml_model $xml_model;
    private FilesModel $filesModel;

    public function __construct()
    {

        $this->filesModel = new FilesModel();
    }

    public function run()
    {
        $this->xml_model = new Xml_model($_FILES['file']['tmp_name'], $_FILES['file']['name']);
        try {
            if (!$this->xml_model->isFileExists()) {
                throw new Exception('Error: There is no file exists!');
            }

            if (!$this->xml_model->isFileXMLExtension('xml')) {
                throw new Exception('Error: File is not xml extension!');
            }

            $xml = $this->xml_model->getXmlFromUploadedFile();
            $xmlValidator = new XmlValidator($xml, $this->xPathQuery);
            if (!$xmlValidator->isValid()) {
                throw new Exception("The XML file structure doesn't meet the requirements");
            }

            //Save - move file to upload folder
            if (!$this->xml_model->saveXmlFile(UPLOAD_DIR)) {
                throw new Exception("Error: Can't save file!");
            }

            //insert file name to BD
            $this->filesModel->insert([
                'file_name' => "'" . $this->xml_model->getFileName() . "'",
                'file_path' => "'" . $this->xml_model->getFilePath() . "'",
            ]);

            $fileTable = new Table();
            $fileTable->run();

        } catch (Exception $e) {
            $view = new View();
            $view->render('error', [
                'title' => 'Ой! Произошла ошибка',
                'msg' => $e->getMessage()
            ]);
        }
    }
}