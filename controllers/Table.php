<?php

namespace App\Controllers;

use App\Models\FilesModel;
use App\Views\View;

class Table
{
    private FilesModel $filesModel;

    public function __construct()
    {
        $this->filesModel = new FilesModel();
    }

    public function run(): void
    {
        $files = $this->filesModel->select('`id`, `file_name`, `file_path`, `created_at`',);
        $view = new View();
        $view->render('list', [
            'files' => $files,
            'title' => 'Таблица загруженных XML фалов',
        ]);

    }
}