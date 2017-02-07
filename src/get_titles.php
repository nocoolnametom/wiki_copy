<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/bootstrap.php');

use Masterminds\HTML5;

$options = getopt("h:p:", array(
  "namespace:"
));

$context = stream_context_create(array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Accept-Encoding: gzip\r\n"
  )
));

$protocol = 'http';
$url = $options['h'] ?: 'en.wikipedia.org';

$filename = 'titles.' . $url . '.' . date('U');

$page_titles = array();

$all_pages_path = '/index.php?title=Special:AllPages';

if (!empty($options['namespace']))
{
  $all_pages_path .= '&namespace=' . $options['namespace'];
}

$html5 = new HTML5();
$not_last_page = true;

while ($not_last_page)
{
  $html = gzdecode(file_get_contents($protocol . '://' . $url . $all_pages_path, false, $context));
  $dom = qp($html5->loadHTML($html), 'body');

  $list = $dom->find('ul.mw-allpages-chunk');

  foreach ($list->find('li') as $li)
  {
    $title = $li->text();
    $page_titles[] = urlencode($title);
  }

  $next_link = $dom->find('a:contains("Next page")');

  $all_pages_path = $next_link->attr('href');

  $not_last_page = $next_link->length > 0;
}

foreach($page_titles as $title)
{
  print($title . PHP_EOL);
}