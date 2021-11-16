<?php

namespace App\Models;

use App\Lib\DataBase;

class FilesModel extends DataBase
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('files');
    }

}