<?php

class Gebruiker {
  /**
   * Properties
   */
  private $conn;

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
    $this->conn = $conn;

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

  /**
   * getEncryptedID
   *
   * @return string
   */
  public function getEncryptedID() {
    $data = '3jeui';
    $data.= ($this->getID() + 3);
    $data.= '4589hkjfjk';
    $data.= ($this->getID() + 23);
    $data.= 'ef8fk8';
    $data.= ($this->getID() + 89);
    $data.= '4r9dv893478fr3fv3rv89rcd';

    $data = substr($data, 0, 40);

    return hash('sha1', $data);
  }

  /**
   * isBeheerder
   *
   * @return bool
   */
  public function isBeheerder() {
    return $this->record['recht'] == 1;
  }

  /**
   * getVerkiesbareAanvragen
   *
   * @return Verkiesbare[]|bool
   */
  public function getVerkiesbareAanvragen() {
    $stmt = $this->conn->prepare("SELECT * FROM `verkiesbare` WHERE gebruiker_id = :gebruiker AND gekeurd = 0");

    $gebruikerID = $this->getID();
    
    $stmt->bindParam(":gebruiker", $gebruikerID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $gebruikers = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $verkiesbare) {
        array_push($gebruikers, Verkiesbare::fromArray($this->conn, $verkiesbare));
      }
      return $gebruikers;
    } 
    
    return false;
  }

  /**
   * verkiesbaarStellen
   *
   * @param  Periode $periode
   * @param  string $omschrijving
   *
   * @return bool
   */
  public function verkiesbaarStellen(Periode $periode, $omschrijving) {
    $stmt = $this->conn->prepare("INSERT INTO `verkiesbare` (gebruiker_id, periode_id, omschrijving) VALUES (:gebruiker, :periode, :omschrijving)");

    $gebruikerID = $this->getID();
    $periodeID = $periode->getID();
    
    $stmt->bindParam(":gebruiker", $gebruikerID);
    $stmt->bindParam(":periode", $periodeID);
    $stmt->bindParam(":omschrijving", $omschrijving);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }

    return false;
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