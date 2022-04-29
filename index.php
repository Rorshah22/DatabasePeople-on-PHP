<?php

use Lib\PeopleDatabase;


spl_autoload_register(function ($class) {
  $class = $class . '.php';
  if (file_exists($class)) {
    require_once $class;
  }
});

$user = [
  'id' => 55,
  // 'firstName' => 'Sev',
  // 'lastName' => 'Smitsdfh',
  // 'birthday' => '1891-01-11',
  // 'sex' => 1,
  // 'city' => 'Sank york',
];
// $user = 1;

$p = new PeopleDatabase($user);


$form = $p->formatPeople(true, true);
echo '<pre>';
print_r($form);
echo '</pre>';
