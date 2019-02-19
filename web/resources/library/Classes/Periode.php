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

  public function getBeginDatum($format = null) {
    return date($format !== null ? $format : Variables::DATE_FORMAT, strtotime($this->record["begin"]));
  }

  public function getEindDatum($format = null) {
    return date($format !== null ? $format : Variables::DATE_FORMAT, strtotime($this->record["eind"]));
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
      $sql = "SELECT * FROM periodes WHERE DATE(begin) > NOW() - INTERVAL 3 MONTH AND DATE(begin) > NOW() - INTERVAL 1 WEEK ORDER BY begin ASC";
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