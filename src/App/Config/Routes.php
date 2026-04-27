<?php

declare(strict_types=1);

Namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController,AboutController};

function registerRoutes(App $app){

    $app->get("/",[HomeController::class,"home"]);

    $app->get("/about",[AboutController::class,"about"]);
}