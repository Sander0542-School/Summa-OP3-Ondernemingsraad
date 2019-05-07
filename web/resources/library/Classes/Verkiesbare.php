<?php

class Verkiesbare {
  private $conn;
  private $record;

  public $omschrijving;
  public $status;

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
    $this->status = $record['gekeurd'];
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

  public function getStatus() {
    switch ($this->status) {
      case 1:
        return "Goedgekeurd";
      case 2:
        return "Afgekeurd";
      default:
        return "In Afwachting";
    }
  }

  public function getAantalStemmen() {
    $verkiesbareID = $this->getID();
    $stmt = $this->conn->prepare("SELECT COUNT(`id`) as aantal FROM `stemmen` WHERE `verkiesbare_id` = :vID");
    $stmt->bindParam(":vID", $verkiesbareID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)['aantal'];
    }

    return 0;
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

  public static function acceptAanvraag(PDO $conn, $verkiesbareID) {
    $stmt = $conn->prepare("UPDATE `verkiesbare` SET `gekeurd` = 1 WHERE `id` = :verkiesbareID");
    $stmt->bindParam(":verkiesbareID", $verkiesbareID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
        }

    return false;
  }

}