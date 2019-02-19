<?php
Class Stemmen {
  private $conn;

  /**
   * __contruct
   *
   * @param  PDO $conn
   */
  private function __contruct(PDO $conn) {
    $this->conn = $conn;
  }

  /**
   * addStem
   *
   * @param  PDO $conn
   * @param  Verkiesbare $verkiesbare
   * @param  Gebruiker $gebruiker
   *
   * @return int
   */
  public static function addStem(PDO $conn, Verkiesbare $verkiesbare, Gebruiker $gebruiker) {
    $stmt = $conn->prepare("INSERT INTO `stemmen` (`verkiesbare_id`, `gebruiker`, `periode_id`) VALUES (:verkiesbare, :gebruiker, :periode)");

    $verkiesbareID = $verkiesbare->getID();
    $gebruikerID = $gebruiker->getEncryptedID();
    $periodeID = 1;

    $stmt->bindParam(":verkiesbare", $verkiesbareID);
    $stmt->bindParam(":gebruiker", $gebruikerID);
    $stmt->bindParam(":periode", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return 0;
    }
    else{
      return 2;
    }
    return 1;
  }

}