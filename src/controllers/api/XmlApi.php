<?php

namespace App\controllers\api;

use App\lib\Rest;
use App\models\FilesModel;

class XmlApi {

    private FilesModel $filesModel;

    public function __construct()
    {
        $this->filesModel = new FilesModel();
    }

    public function run()
    {
        error_reporting(0);
        $data = json_decode(file_get_contents("php://input"));
        try {
            switch ($data->method) {
                case 'delete':
                    $result = $this->delete($data->id);
                    new Rest('Ok', $result ? 'Successfully deleted!' : 'Error!');
                    break;
                case 'files':
                    $result = $this->getFiles();
                    new Rest('Ok', !$result ? 'There is no any files!' : '', $result);
                    break;
                default:
                    throw new \Exception('Error: request is incorrect');
            }
        } catch (\Exception $e) {
            new Rest('Ok', $e->getMessage());
        }

    }

    /**
     * @param $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $currentDate = date('Y-m-d H:i:s');
        return $this->filesModel->update(['deleted_at' => "'{$currentDate}'"], "id = '{$id}'");
    }

    /**
     * @param string|null $where
     * @param string|null $order_by
     * @return array
     */
    public function getFiles(string $where = null, string $order_by = null): array
    {
        $fields = "id, file_name, file_path, created_at, updated_at";
        return $this->filesModel->select($fields, $where, $order_by);
    }

}

