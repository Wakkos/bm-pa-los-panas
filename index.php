Welcome to Wakkos' Localhost III.
<?php
require "phpums_20/lib/ums.php";


$doc = new DOMDocument();
$doc->loadHTMLFile("sample_bookmark.html");
$html = $doc->saveHTML(); //load bookmark file

$dom = new DOMDocument;
$dom->loadHTML($html);
foreach ($dom->getElementsByTagName('a') as $node)
{
  echo 'Title = ' .$node->nodeValue. '</br>';
  echo 'URL = ' .$node->getAttribute("href"). '</br>';
  echo 'Icon = ' . $node->getAttribute("icon"). '</br>';
  echo 'Date Added = ' . $node->getAttribute("add_date"). '</br>';
  echo '<br>';
}

?>