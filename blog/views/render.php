<?php

require('../vendor/autoload.php');

use Michelf\Markdown;

$requestUri = $_SERVER['REQUEST_URI'];

$path = join(array_filter(explode('/', $requestUri)), '/');
$path = $path ? $path : 'home';

$templateHTML = @file_get_contents('./template.html');
$contentMD = @file_get_contents('../content/' . $path . '.md');
$contentMD = $contentMD ? $contentMD : @file_get_contents('../content/404.md');

$contentHTML = Markdown::defaultTransform($contentMD);
preg_match_all('/<h1.*?>(.*)<\/h1>/msi', $contentHTML, $matches);
$title = $matches[1][0];

$navigationHTML = @file_get_contents('./navigation.html');
$footerHTML = @file_get_contents('./footer.html');

$outputHTML = $templateHTML;
$outputHTML = str_replace('{{title}}', "$title - Project Maid", $outputHTML);
$outputHTML = str_replace('{{navigation}}', $navigationHTML, $outputHTML);
$outputHTML = str_replace('{{body}}', $contentHTML, $outputHTML);
$outputHTML = str_replace('{{footer}}', $footerHTML, $outputHTML);

print $outputHTML;
