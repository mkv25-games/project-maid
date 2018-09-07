<?php

require('../vendor/autoload.php');

use Michelf\Markdown;

$requestUri = $_SERVER['REQUEST_URI'];

$path = join(array_filter(explode('/', $requestUri)), '/');
$path = $path ? $path : 'home';

$contentMD = @file_get_contents('../content/' . $path . '.md');
$contentMD = $contentMD ? $contentMD : @file_get_contents('../content/404.md');

$outputHTML = Markdown::defaultTransform($contentMD);

function breadcrumb($content) {
  return '<breadcrumb>Location: ' . join(explode('/', $content), ' / ') . '</breadcrumb>';
}

print breadcrumb($path) . $outputHTML;
