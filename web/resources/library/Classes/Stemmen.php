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
   * @return bool
   */
  public static function addStem(PDO $conn, Verkiesbare $verkiesbare, Gebruiker $gebruiker) {
    $stmt = $conn->prepare("INSERT INTO 'stemmen' ('verkiesbare_id', 'gebruiker') VALUES (:verkiesbare, :gebruiker)");

    $stmt->bindParam(":verkiesbare", $verkiesbare->getID());
    $stmt->bindParam(":gebruiker", $gebruiker->getEncryptedID());

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }
    return false;
  }

}