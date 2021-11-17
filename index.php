<?php

namespace Root;

use App\controllers\api\XmlApi;
use App\controllers\Table;
use App\controllers\XmlHandler;
use App\View;

require_once __DIR__ . '/vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];
switch ($request){
    case '/index.php/upload':
        $xmlHandler = new XmlHandler();
        $xmlHandler->run();
        break;
    case '/index.php/list':
        $table = new Table();
        $table->run();
        break;
    case '/index.php/api':
        $api = new XmlApi();
        $api->run();
        break;
    default:
        $view = new View();
        $view->render('create', [
            'title' => 'Выберите XML файл для обработки, анализа и дальнейшего сохранения'
        ]);
        break;
}






