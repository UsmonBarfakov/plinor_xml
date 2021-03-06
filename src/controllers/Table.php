<?php

namespace App\controllers;

use App\Models\FilesModel;
use App\View;

class Table
{
    private FilesModel $filesModel;

    public function __construct()
    {
        $this->filesModel = new FilesModel();
    }

    public function run(): void
    {
        $files = $this->filesModel->select('`id`, `file_name`, `file_path`, `created_at`, `updated_at`',);
        $view = new View();
        $view->render('list', [
            'files' => $files,
            'title' => 'Таблица загруженных XML фалов',
        ]);
    }
}