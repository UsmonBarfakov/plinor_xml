<?php

namespace App\models;

use App\lib\DataBase;

class FilesModel extends DataBase
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('files');
    }

}