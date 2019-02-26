<?php

class Periode {
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

  /**
   * getNaam
   *
   * @return string
   */
  public function getNaam() {
    return $this->record["naam"];
  }

  /**
   * getBeginDatum
   *
   * @param  mixed $format
   *
   * @return string
   */
  public function getBeginDatum($format = null) {
    return DateTime::createFromFormat('Y-m-d H:i:s', $this->record["begin"])->format($format !== null ? $format : Variables::DATE_FORMAT);
  }

  /**
   * getEindDatum
   *
   * @param  mixed $format
   *
   * @return string
   */
  public function getEindDatum($format = null) {
    return DateTime::createFromFormat('Y-m-d H:i:s', $this->record["eind"])->format($format !== null ? $format : Variables::DATE_FORMAT);
  }

  /**
   * getAantalStemmen
   *
   * @return int
   */
  public function getAantalStemmen() {
    $stmt = $this->conn->prepare("SELECT id FROM stemmen WHERE verkiesbare_id IN (SELECT id FROM verkiesbare WHERE periode_id = :periode)");

    $periodeID = $this->getID();

    $stmt->bindParam(":periode", $periodeID);

    $stmt->execute();

    return $stmt->rowCount();
  }

  /**
   * getAantalStemmen
   *
   * @return StemResultaat[]|bool
   */
  public function getResultaten() {
    $stmt = $this->conn->prepare("SELECT verkiesbare_id, COUNT(id) FROM stemmen GROUP BY verkiesbare_id WHERE periode_id = :periode");

    $periodeID = $this->getID();

    $stmt->bindParam(":periode", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $gebruikers = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $verkiesbare) {
        array_push($gebruikers, StemResultaat::fromArray($this->conn, $verkiesbare));
      }
      return $gebruikers;
    }

    return false;
  }

  /**
   * getaantalVerkiesbaar
   *
   * @return Verkiesbare[]|bool
   */
  public function getVerkiesbare() {
    $stmt = $this->conn->prepare("SELECT * FROM verkiesbare WHERE periode_id = :periode AND gekeurd = 1");

    $periodeID = $this->getID();

    $stmt->bindParam(":periode", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $gebruikers = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $verkiesbare) {
        array_push($gebruikers, Verkiesbare::fromArray($this->conn, $verkiesbare));
      }
      return $gebruikers;
    }

    return false;
  }

  /**
   * getPeriodes
   *
   * @param  mixed $conn
   *
   * @return Periode[]|false
   */
  public static function getPeriodes(PDO $conn, bool $showAll = true) {

    $sql = "SELECT * FROM periodes ORDER BY begin ASC";
    if ($showAll == false) {
      $sql = "SELECT * FROM periodes WHERE NOW() BETWEEN DATE(begin) - INTERVAL 3 MONTH AND DATE(begin) - INTERVAL 1 WEEK ORDER BY begin ASC";
    }

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $periodes = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $periode) {
        array_push($periodes, new Periode($conn, $periode));
      }
      return $periodes;
    }
    return false;
  }

  /**
   * fromID
   *
   * @param  PDO $conn
   * @param  int $periodeID
   *
   * @return Periode|bool
   */
  public static function fromID(PDO $conn, $periodeID) {
    $stmt = $conn->prepare("SELECT * FROM `periodes` WHERE `id` = :periodeID");
    $stmt->bindParam(":periodeID", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Periode($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }
}