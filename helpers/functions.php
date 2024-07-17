<?php

function debug(mixed $var) : never {
  echo "<pre>";
  var_dump($var);
echo "</pre>";
  exit;
}

function sanitize(string $html) : string {
  $sanitized = htmlspecialchars($html);
  return $sanitized;
}
