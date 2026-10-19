<?php

$publicPath = __DIR__.'/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Only serve static assets if it is an actual existing file (not a directory)
// This prevents Windows case-insensitive directories like public/Dashboard from hijacking route /dashboard
if ($uri !== '/' && is_file($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';
