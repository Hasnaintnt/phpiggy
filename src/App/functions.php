<?php

declare(strict_types=1);

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function escape(mixed $value): string
{
    return htmlspecialchars((string)$value);
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirectTo(string $path)
{
    header("Location: {$path}");
    http_response_code(302);
    exit;
}