<?php

declare(strict_types=1);

Namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AboutController{
    private TemplateEngine $view;

    public function __construct(){
        $this->view = new TemplateEngine(paths::VIEW);
    }
    public function about(){
        echo $this->view->render("about",[
            'title' => "About PHPiggy"
        ]);
    }
}