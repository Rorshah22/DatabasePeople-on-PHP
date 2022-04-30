<?php

use Lib\ListPeople;
use Lib\PeopleDatabase;


spl_autoload_register(function ($class) {
  $class = $class . '.php';
  if (file_exists($class)) {
    require_once $class;
  }
});

$user = [
  'id' => 1,
  'firstName' => 'Nik',
  'lastName' => 'Алик',
  'birthday' => '200-03-10',
  'sex' => 1,
  'city' => 'Минск',
];

// $p = new PeopleDatabase($user);


// $form = $p->formatPeople(true, true);
// echo '<pre>';
// print_r($p->formatPeople(true, true));
// echo '</pre>';
$p2 = new ListPeople($user);
$user = $p2->deletePeopleArray();
echo '<pre>';
print_r($p2);
echo '</pre>';
