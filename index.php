<?php

namespace App;

use App\Controllers\Table;
use App\Controllers\XmlHandler;
use App\Views\View;

require_once __DIR__ . '/vendor/autoload.php';

$request = "$_SERVER[REQUEST_URI]";

switch ($request){
    case '/index.php/upload':
    case 'upload':
        $xmlHandler = new XmlHandler();
        $xmlHandler->run();
        break;
    case '/index.php/list':
        $table = new Table();
        $table->run();
        break;
    default:
        $view = new View();
        $view->render('create', [
            'title' => 'Выберите XML файл для обработки, анализа и дальнейшего сохранения'
        ]);
        break;
}




