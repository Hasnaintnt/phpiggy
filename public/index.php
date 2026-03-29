<?php

$app = include __DIR__ . "/../src/App/bootstrap.php";

$app->run();

echo "<pre>";
print_r($_SERVER);
echo "</pre>";