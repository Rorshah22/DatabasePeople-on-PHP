<?php

namespace Lib;

use PDO;
use PDOException;
use stdClass;
use Lib\Database;


/**
 * This is class for work with people database
 */

class PeopleDatabase
{

  private $id;
  private $firstName;
  private $lastName;
  private $birthday;
  private $sex;
  private $city;


  /**
   * @param array $data
   */
  public function __construct(array $data = [])
  {
    if (empty($this->id = $data['id'])) {
      $this->firstName = $data['firstName'];
      $this->lastName = $data['lastName'];
      $this->birthday = $data['birthday'];
      $this->sex = $data['sex'];
      $this->city = $data['city'];

      preg_match('/^[a-zA-Zа-яА-Я\ \']+$/', $this->firstName, $first);
      preg_match('/^[a-zA-Zа-яА-Я\ \']+$/', $this->lastName, $last);

      if (empty($first) || empty($last)) {
        echo '<pre>';
        print_r('Don\'t use numbers');
        echo '</pre>';
        return;
      }
      $this->savePeople();
    } else {
      $this->getPeople();
    }
  }


  /**
   * @return void
   */
  private function savePeople(): void
  {
    $sqlCheck = "SELECT EXISTS(
       SELECT * FROM users
       WHERE first_name='$this->firstName'
       AND last_name= '$this->lastName'
       AND birthday='$this->birthday'
       AND sex=$this->sex
       AND city='$this->city'
       ) ";

    $db = new PDO('mysql:host=localhost;dbname=people', 'root', '');
    $exists = $db->query($sqlCheck)->fetch();

    $sql = "INSERT INTO users(
      first_name,
      last_name,
      birthday,
      sex,
      city
    ) values(
      '$this->firstName',
      '$this->lastName',
      '$this->birthday',
       $this->sex,
      '$this->city'
    )";

    if (empty($exists[0])) {
      $db->exec($sql);
      echo "man saved at db";
    } else {
      echo "man exists at db";
    }
  }

  /**
   * @param int $id
   * 
   * @return string
   */
  public function deletePeople(int $id): string
  {
    $sql = "DELETE FROM users WHERE id=$id";
    $db = new Database();
    $db->queryPDO($sql);
    return "people with id=$id delete";
  }

  /**
   * @param string $birthday
   * 
   * @return int
   */
  private static function getAge(string $birthday): int
  {

    $birthday = strtotime($birthday);
    $age = date('Y') - date('Y',   $birthday);
    if (date('md', $birthday) > date('md')) {
      $age--;
    }

    return $age;
  }


  /**
   * @param bool $sex
   * 
   * @return string
   */
  private static function getSex(bool $sex): string
  {

    return $sex ? 'женщина' : 'мужчина';
  }

  /**
   * @return string
   */
  private function getPeople(): string
  {
    try {
      $sql = "SELECT * FROM users WHERE ID=$this->id";
      $db = new PDO('mysql:host=localhost;dbname=people', 'root', '');
      $obj = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
      $this->firstName = $obj['FIRST_NAME'];
      $this->lastName = $obj['LAST_NAME'];
      $this->birthday = $obj['BIRTHDAY'];
      $this->sex = $obj['SEX'];
      $this->city = $obj['CITY'];
    } catch (PDOException $e) {
      return $e;
    }
  }

  /**
   * @param bool $age
   * @param bool $sex
   * 
   * @return object
   */
  public function formatPeople(bool $age = false, bool $sex = false): object
  {

    $obj = new stdClass();
    $obj->id = $this->id;
    $obj->firstName = $this->firstName;
    $obj->lastName = $this->lastName;
    if ($age) {
      $obj->birthday =  self::getAge($this->birthday);
    } else {
      $obj->birthday = $this->birthday;
    }
    if ($sex) {
      $obj->sex = self::getSex($this->sex);
    } else {
      $obj->sex = $this->sex;
    }
    $obj->city = $this->city;
    return $obj;
  }
}
