<?php

declare(strict_types=1);

use Framework\App;
use function App\Config\{registerRoutes,registerMiddleware};
use App\Config\Paths;
use Dotenv\Dotenv;

require __DIR__ . "/../App/functions.php";

require __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

$app = new App(Paths::SOURCE . "App/container-definitions.php");

registerRoutes($app);
registerMiddleware($app);

return $app;