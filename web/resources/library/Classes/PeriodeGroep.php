<?php
class PeriodeGroep {
  private $conn;
  private $record;

  private function __construct(PDO $conn, array $record) {
    $this->conn = $conn;
    $this->record = $record;
  }
  
  public function getID() {
    return $this->record["id"];
  }
  
  public function getCode() {
    return $this->record["gebruikerCode"];
  }

  public function getGebruiker() {
    return Gebruiker::fromGebruikersnaam($this->conn, $this->record["gebruikerCode"]);
  }

  public function getGroep() {
    return $this->record["groep"];
  }

  public function getStemmen() {
    return $this->record["stemmen"];
  }

  public static function fromArray(PDO $conn, $record) {
    return new PeriodeGroep($conn, $record);
  }
}