<?php

namespace App\Views;

class View
{
    private string $header = ROOT . 'views/templates/header.php';
    private string $footer = ROOT . 'views/templates/footer.php';

    public function render(string $view, array $data): void
    {
        $fileView = ROOT . 'views/templates/' . strtolower($view) . '.php';
        if (file_exists($fileView)) {
            extract($data);
            include($this->header);
            include($fileView);
            include($this->footer);
        } else {
            $this->render('error', ['msg' => "Error: There is no view: {$fileView}! "]);
        }
    }
}