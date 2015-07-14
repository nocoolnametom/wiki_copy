<?php

require_once(__DIR__ . '/vendor/autoload.php');

function pre($val, $die = false)
{
  print_r($val);

  if($die)
  {
    die("\n");
  }
}
