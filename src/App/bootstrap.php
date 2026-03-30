<?php

declare(strict_types=1);

use Framework\App;

require __DIR__ . "/../Framework/functions.php";

require __DIR__ . "/../../vendor/autoload.php";

$app = new App();

$app->get("/");

$app->get("/",["\App\Controllers\HomeController","home"]);

dd($app);

return $app;