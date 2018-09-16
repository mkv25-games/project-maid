<?php

require('../vendor/autoload.php');

use Michelf\Markdown;

$requestUri = $_SERVER['REQUEST_URI'];

$path = join(array_filter(explode('/', $requestUri)), '/');
$path = str_replace('blog', '', $path);
$path = $path ? $path : 'home';

$templateHTML = @file_get_contents('./template.html');
$contentMD = @file_get_contents('../content/' . $path . '.md');
$contentMD = $contentMD ? $contentMD : @file_get_contents('../content/404.md');

preg_match_all('/```background: (.*)```/msi', $contentMD, $matches);
$backgroundImage = $matches[1][0];
$contentMD = preg_replace('/```background: .*```/', '', $contentMD);

$contentHTML = renderIconsAsHTML(Markdown::defaultTransform($contentMD));
preg_match_all('/<h1.*?>(.*)<\/h1>/msi', $contentHTML, $titles);
$title = trim(strip_tags($titles[1][0]));

$navigationHTML = @file_get_contents('./navigation.html');
$footerHTML = @file_get_contents('./footer.html');

$outputHTML = $templateHTML;
$outputHTML = str_replace('{{title}}', "$title - Project Maid", $outputHTML);
$outputHTML = str_replace('{{navigation}}', $navigationHTML, $outputHTML);
$outputHTML = str_replace('{{body}}', $contentHTML, $outputHTML);
$outputHTML = str_replace('{{footer}}', $footerHTML, $outputHTML);
$outputHTML = str_replace('{{backgroundImage}}', $backgroundImage, $outputHTML);
$outputHTML = str_replace('{{location}}', $path, $outputHTML);
$outputHTML = renderIconsAsHTML($outputHTML);

function renderIconsAsHTML($searchText) {
  return preg_replace(
      '/({{icon:([a-z-]+)}})/',
      '<i class="fas fa-$2"></i>',
      $searchText
  );
}

print $outputHTML;
