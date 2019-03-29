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
    $stmt = $conn->prepare("INSERT INTO `stemmen` (`verkiesbare_id`, `gebruiker`) VALUES (:verkiesbare, :gebruiker)");

    $verkiesbareID = $verkiesbare->getID();
    $gebruikerID = $gebruiker->getEncryptedID();

    $stmt->bindParam(":verkiesbare", $verkiesbareID);
    $stmt->bindParam(":gebruiker", $gebruikerID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }
    return false;
  }

}