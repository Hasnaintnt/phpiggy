<?php

declare(strict_types=1);

use Framework\App;
use App\Controllers\{HomeController,AboutController};

require __DIR__ . "/../App/functions.php";

require __DIR__ . "/../../vendor/autoload.php";

$app = new App();

$app->get("/",[HomeController::class,"home"]);

$app->get("/about",[AboutController::class,"about"]);

return $app;