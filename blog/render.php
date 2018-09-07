<?php

require('./vendor/autoload.php');

use Michelf\Markdown;

$contentPath = 'README.md';
$contentMD = file_get_contents($contentPath);

$outputHTML = Markdown::defaultTransform($contentMD);

print $outputHTML;
