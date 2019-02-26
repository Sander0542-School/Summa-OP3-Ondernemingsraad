<?php

class Verkiesbare {
  private $conn;
  private $record;

  public $omschrijving;

  /**
   * __construct
   *
   * @param  PDO $conn
   * @param  array $record
   */
  private function __construct(PDO $conn, array $record) {
    $this->record = $record;
    $this->conn = $conn;

    $this->omschrijving = $record['omschrijving'];
  }

  /**
   * getGebruiker
   *
   * @return Gebruiker|bool
   */
  public function getGebruiker() {
    return Gebruiker::fromID($this->conn, $this->record["gebruiker_id"]);
  }

  /**
   * getPeriode
   *
   * @return Periode|bool
   */
  public function getPeriode() {
    return Periode::fromID($this->conn, $this->record["periode_id"]);
  }

  /**
   * getID
   *
   * @return void
   */
  public function getID() {
    return $this->record["id"];
  }

  /**
   * fromID
   *
   * @param  PDO $conn
   * @param  int $verkiesbareID
   *
   * @return Verkiesbare|bool
   */
  public static function fromID(PDO $conn, $verkiesbareID) {
    $stmt = $conn->prepare("SELECT * FROM `verkiesbare` WHERE `id` = :verkiesbareID");
    $stmt->bindParam(":verkiesbareID", $verkiesbareID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Verkiesbare($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }

  /**
   * fromArray
   *
   * @param  PDO $conn
   * @param  array $record
   *
   * @return Verkiesbare
   */
  public static function fromArray(PDO $conn, $record) {
    return new Verkiesbare($conn, $record);
  }

  /**
   * getVerkiesbare
   *
   * @param  PDO $conn
   *
   * @return getVerkiesbare[]
   */
  public static function getVerkiesbare(PDO $conn) {
    $stmt = $conn->prepare("SELECT * FROM `verkiesbare` WHERE `gekeurd` = 1");

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $gebruikers = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $verkiesbare) {
        array_push($gebruikers, new Verkiesbare($conn, $verkiesbare));
      }
      return $gebruikers;
    }

    return false;
  }

  public static function getAanvraag(PDO $conn) {
    $stmt = $conn->prepare("SELECT * FROM `verkiesbare` WHERE `gekeurd` = 0");

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $gebruikers = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $verkiesbare) {
        array_push($gebruikers, new Verkiesbare($conn, $verkiesbare));
      }
      return $gebruikers;
    }

    return false;
  }

}