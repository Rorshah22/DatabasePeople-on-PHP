<?php

namespace Lib;

use PDO;
use Exception;
use Lib\PeopleDatabase;

if (!class_exists(PeopleDatabase::class)) {
  throw new Exception("Class PeopleDatabase not found", 1);;
}
/**
 * This class work with array ID people
 */
class ListPeople
{
  private  $idPeople = [];

  public function __construct(array $arrayFields, string $mod = '=')
  {

    $sql = "SELECT ID FROM USERS
     WHERE FIRST_NAME$mod'$arrayFields[firstName]'
     OR LAST_NAME$mod'$arrayFields[lastName]'
     OR BIRTHDAY$mod'$arrayFields[birthday]'
     AND SEX$mod'$arrayFields[sex]'
     OR CITY$mod'$arrayFields[city]'
     OR ID$mod'$arrayFields[id]'
     ";
    $db = new PDO('mysql:host=localhost;dbname=people', 'root', '');
    $this->idPeople = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getArrayPeople(): array
  {

    foreach ($this->idPeople as $id) {
      $arrayPeople[] = new PeopleDatabase(['id' => $id['ID']]);
    }

    return $arrayPeople;
  }

  public function deletePeopleArray(): string
  {
    $delete = new PeopleDatabase();
    foreach ($this->idPeople as $id) {
      $delete->deletePeople($id['ID']);
    }
    return 'Delete completed';
  }
}
