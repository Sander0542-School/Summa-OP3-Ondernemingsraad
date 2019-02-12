<?php

class Stemmen {

  /**
   * __construct
   *
   * @param  PDO $conn
   * @param  array $verkiesbare
   */
  private function __construct(PDO $conn, array $verkiesbare) {
    $this->record = $verkiesbare;

    $this->omschrijving = $verkiesbare['omschrijving'];
  }

  /**
   * getVerkiesbare
   *
   * @param  PDO $conn
   *
   * @return Stemmen
   */
  public static function getVerkiesbare(PDO $conn) {
      $stmt = $conn->prepare("SELECT * FROM `verkiesbare` WHERE `gekeurd` = :gekeurd");
      $stmt->bindParam(1, $gekeurd);
  
      $stmt->execute();
  
      if ($stmt->rowCount() > 0) {
        return new Gebruiker($conn, $stmt->fetch(PDO::FETCH_ASSOC));
      }
  
      return false;
    }
    
}

?>