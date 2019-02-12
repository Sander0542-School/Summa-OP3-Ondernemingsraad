<?php

class Gebruiker {
  /**
   * Properties
   */
  public $voornaam;
  public $achternaam;

  private $record;

  /**
   * Constructor
   */
  private function __construct(PDO $conn, array $gebruiker) {
    $this->record = $gebruiker;

    $this->voornaam = $gebruiker['voornaam'];
    $this->achternaam = $gebruiker['achternaam'];
  }

  /**
   * Methods
   */
  public function heeftGestemd() {
    return $this->record['gestemd'] !== 0;
  }

  /**
   * Init
   */
  public static function fromGebruikerID(PDO $conn, $gebruikerID) {
    $stmt = $conn->prepare("SELECT * FROM `gebruikers` WHERE `id` = :gebruikerID");
    $stmt->bindParam(":gebruikerID", $gebruikerID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Gebruiker($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }

  public static function fromGebruikersnaam(PDO $conn, $gebruikersnaam) {
    $stmt = $conn->prepare("SELECT * FROM `gebruikers` WHERE `gebruikersnaam` = :gebruikersnaam");
    $stmt->bindParam(":gebruikersnaam", $gebruikersnaam);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Gebruiker($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }
}

?>