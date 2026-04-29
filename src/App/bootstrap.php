<?php

declare(strict_types=1);

use Framework\App;
use function App\Config\{registerRoutes,registerMiddleware};
use App\Config\Paths;

require __DIR__ . "/../App/functions.php";

require __DIR__ . "/../../vendor/autoload.php";

$app = new App(Paths::SOURCE . "App/container-definitions.php");

registerRoutes($app);
registerMiddleware($app);

return $app;