<?php

class Groep {
  private $conn;
  private $record;

  /**
   * __construct
   *
   * @param  mixed $record
   */
  private function __construct(PDO $conn, array $record) {
    $this->conn = $conn;
    $this->record = $record;
  }

  /**
   * getID
   *
   * @return int
   */
  public function getID() {
    return $this->record["id"];
  }

  public function getNaam() {
    return $this->record["naam"];
  }

  public function getCode() {
    return $this->record["code"];
  }

  public function getZetels() {
    return $this->record["zetels"];
  }

  public static function getGroepen(PDO $conn) {

    $stmt = $conn->prepare("SELECT `groepen`.*, `proposities`.`naam`, `proposities`.`code` FROM `groepen` INNER JOIN `proposities` ON `groepen`.`propositie_id` = `proposities`.`id`");

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $periodes = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $periode) {
        array_push($periodes, new Groep($conn, $periode));
      }
      return $periodes;
    }
    return false;
  }

  public static function fromID(PDO $conn, $groepID) {
    $stmt = $conn->prepare("SELECT * FROM `groepen` WHERE `id` = :groepID");
    $stmt->bindParam(":groepID", $groepID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Groep($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }
}