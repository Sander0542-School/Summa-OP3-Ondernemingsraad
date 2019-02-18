<?php

class Verkiesbare {
  private $conn;
  private $record;

  public $omschrijving;

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

  /**
   * getGebruiker
   *
   * @return Gebruiker|bool
   */
  public function getGebruiker() {
    return Gebruiker::fromGebruikerID($this->conn, $this->record["gebruiker_id"]);
  }

  /**
   * getID
   *
   * @return void
   */
  public function getID() {
    return $this->recrod["id"];
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
    
}

?>