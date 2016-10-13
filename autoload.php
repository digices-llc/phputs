<?php

$lib = __DIR__.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR;

$di = new DirectoryIterator($lib);

foreach ($di as $item) {
  $file = $item->getFilename();
  if (substr($file,0,1) != '.') {
    require_once($lib.$file);
  }
}
