<?php

class Stemmen {
  public $omschrijving;

  private $conn;

  /**
   * __construct
   *
   * @param  PDO $conn
   * @param  array $verkiesbare
   */
  private function __construct(PDO $conn, array $verkiesbare) {
    $this->record = $verkiesbare;
    $this->conn = $conn;

    $this->omschrijving = $verkiesbare['omschrijving'];
  }

  public function getGebruiker() {
    return Gebruiker::fromGebruikerID($this->conn, $this->record["gebruiker_id"]);
  }

  /**
   * getVerkiesbare
   *
   * @param  PDO $conn
   *
   * @return Stemmen[]
   */
  public static function getVerkiesbare(PDO $conn) {
      $stmt = $conn->prepare("SELECT * FROM `verkiesbare` WHERE `gekeurd` = 1");
  
      $stmt->execute();
  
      if ($stmt->rowCount() > 0) {
        $gebruikers = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $verkiesbare) {
          array_push($gebruikers, new Stemmen($conn, $verkiesbare));
        }
        return $gebruikers;
      }
  
      return false;
    }
    
}

?>