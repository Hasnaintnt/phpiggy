<?php

declare(strict_types=1);

use Framework\App;
use App\Controllers\HomeController;

require __DIR__ . "/../Framework/functions.php";

require __DIR__ . "/../../vendor/autoload.php";

$app = new App();

$app->get("/",[HomeController::class,"home"]);

return $app;