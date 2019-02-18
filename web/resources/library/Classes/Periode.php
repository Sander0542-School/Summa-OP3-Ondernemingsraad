<?php

class Periode {
  private $conn;
  private $row;

  /**
   * __construct
   *
   * @param  mixed $periodeRow
   */
  private function __construct(PDO $conn, array $periodeRow) {
    $this->conn = $conn;
    $this->row = $periodeRow;
  }

  /**
   * getID
   *
   * @return int
   */
  public function getID() {
    return $this->row["id"];
  }

  /**
   * getNaam
   *
   * @return string
   */
  public function getNaam() {
    return $this->row["naam"];
  }

  /**
   * getPeriodes
   *
   * @param  mixed $conn
   *
   * @return Periode[]|false
   */
  public static function getPeriodes(PDO $conn) {
    $stmt = $conn->prepare("SELECT * FROM periodes ORDER BY begin ASC");

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