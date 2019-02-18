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
   * getID
   *
   * @return int
   */
  public function getID() {
    return $this->record["id"];
  }

  /**
   * getGebruikersnaam
   *
   * @return string
   */
  public function getGebruikersnaam() {
    return $this->record["gebruikersnaam"];
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

  public function getEncryptedID() {
    $data = '3jef7ui';
    $data.= ($this->getID() + 3);
    $data.= '4589fjk';
    $data.= ($this->getID() + 23);
    $data.= 'ef8dfk8';
    $data.= ($this->getID() + 89);
    $data.= '4r9dv893478fr3fv3rv89rcd';

    $data = substr($data, 0, 40);

    return hash('sha1', $data);
  }

  /**
   * fromID
   *
   * @param  PDO $conn
   * @param  int $gebruikerID
   *
   * @return Gebruiker|bool
   */
  public static function fromID(PDO $conn, $gebruikerID) {
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

  /**
   * isIngelogd
   *
   * @param  PDO $conn
   *
   * @return bool
   */
  public static function isIngelogd(PDO $conn) {
    if (isset($_SESSION["userID"])) {
      if (Gebruiker::fromID($conn, $_SESSION["userID"]) !== false) {
        return true;
      }
    }

    return false;
  }
}

?>