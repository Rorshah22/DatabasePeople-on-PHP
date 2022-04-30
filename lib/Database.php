<?php

namespace Lib;

use PDO;
use PDOException;

/**
 * This class create database and table if db not found
 */
class Database
{

  private $host = 'localhost';
  private $dbname = 'people';
  private $user = 'root';
  private $password = '';

  public function __construct()
  {
    if (!$this->queryPDO()) {
      $this->createDb();
      $this->createTableDb();
    }
  }

  private function createDb()
  {
    $dns = "mysql:host=$this->host";
    $sql = "CREATE DATABASE $this->dbname";

    $this->queryPDO($sql, $dns);
    echo 'Db created <br>';
  }

  private function createTableDb()
  {
    $sql = "CREATE TABLE users(
      ID integer auto_increment primary key,
      FIRST_NAME varchar(25),
      LAST_NAME varchar(25),
      BIRTHDAY varchar(25),
      SEX boolean,
      CITY varchar(25)
    )";
    $this->queryPDO($sql);
    echo 'Table created';
  }

  public function queryPDO(string $sql = '', string $dns = '')
  {
    try {

      if (empty($dns)) {
        $dns = "mysql:host=$this->host;dbname=$this->dbname";
      }

      $db =  new PDO($dns, $this->user, $this->password);
      if ($sql) {
        $db->exec($sql);
      }
      return true;
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }
}
