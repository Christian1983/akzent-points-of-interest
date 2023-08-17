<?php

namespace AkzentPointsOfInterest\Helper;

function to_snake_case($input) {
  return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
}

function to_camel_case($input) {
  $_tmp = $input;
  $_split = explode('_', $input);
  foreach($_split as $element) {
    $a = $element;
    $b = 1;
  }
}
