<?php

class Gebruiker {
  /**
   * Properties
   */
  public $voornaam;
  public $achternaam;

  private $record;

  /**
   * __construct
   *
   * @param  PDO $conn
   * @param  array $gebruiker
   */
  private function __construct(PDO $conn, array $gebruiker) {
    $this->record = $gebruiker;

    $this->voornaam = $gebruiker['voornaam'];
    $this->achternaam = $gebruiker['achternaam'];
  }

  /**
   * getNaam
   *
   * @return string
   */
  public function getNaam() {
    return $this->voornaam . ' ' . $this->achternaam;
  }

  /**
   * heeftGestemd
   *
   * @return bool
   */
  public function heeftGestemd() {
    return $this->record['gestemd'] !== 0;
  }

  /**
   * fromGebruikerID
   *
   * @param  PDO $conn
   * @param  int $gebruikerID
   *
   * @return Gebruiker|bool
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

  /**
   * fromGebruikersnaam
   *
   * @param  PDO $conn
   * @param  string $gebruikersnaam
   *
   * @return Gebruiker|bool
   */
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