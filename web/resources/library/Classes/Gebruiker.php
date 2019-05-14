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

  public function getGroepen() {
    return explode(',', $this->record['groepen']);
  }

  public function getPropositie($column = 'naam') {
    $groepenPDO = "'".implode("', '", $this->getGroepen())."'";
    $stmt = $this->conn->prepare("SELECT * FROM proposities WHERE code IN (".$groepenPDO.")");
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC)[$column];
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
    return $this->record['recht'] != 0;
  }

  /**
   * setBeheerder
   *
   * @param  int $recht
   *
   * @return bool
   */
  public function setRecht($recht) {
    $stmt = $this->conn->prepare("UPDATE gebruikers SET recht = :recht WHERE id = :uID");

    $gebruikerID = $this->getID();

    $stmt->bindParam(":recht", $recht);
    $stmt->bindParam(":uID", $gebruikerID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }
    
    return false;
  }

  /**
   * getType
   *
   * @return string
   */
  public function getType() {
    if ($this->isBeheerder()) {
      return "Beheerder";
    }
    
    return "Gebruiker";
  }

  /**
   * getVerkiesbareAanvragen
   *
   * @return Verkiesbare[]|bool
   */
  public function getVerkiesbareAanvragen() {
    $stmt = $this->conn->prepare("SELECT * FROM `verkiesbare` WHERE gebruiker_id = :gebruiker");

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
    try {
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
    } catch (PDOException $exception) { }

    return false;
  }

  public function checkGestemd(Verkiesbare $verkiesbare) {
    $stmt = $this->conn->prepare("SELECT * FROM `stemmen` WHERE `gebruiker` = :gebruiker AND `verkiesbare_id` = :verkiesbareID");

    $verkiesbareID = $verkiesbare->getID();
    $gebruikerID = $this->getEncryptedID();

    $stmt->bindParam(":gebruiker", $gebruikerID);
    $stmt->bindParam(":verkiesbareID", $verkiesbareID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return false;
    }

    return true;
  }

  public function getAantalGestemd(Periode $periode) {
    $stmt = $this->conn->prepare("SELECT COUNT(*) as stemmen FROM stemmen INNER JOIN verkiesbare ON verkiesbare.id = stemmen.verkiesbare_id INNER JOIN periodes ON verkiesbare.periode_id = periodes.id WHERE stemmen.gebruiker = :gebruiker AND periodes.id = :periodeID");
   
    $periodeID = $periode->getID();
    $gebruikerID = $this->getEncryptedID();

    $stmt->bindParam(":gebruiker", $gebruikerID);
    $stmt->bindParam(":periodeID", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)['stemmen'];
    }

    return 0;
  }

  public function getTotaalStemmen(Periode $periode) {
    $propositieID = $this->getPropositie('id');
    $periodeID = $periode->getID();

    $stmt = $this->conn->prepare("SELECT * FROM groepen WHERE propositie_id = :propositieID AND periode_id = :periodeID");

    $stmt->bindParam(":propositieID", $propositieID);
    $stmt->bindParam(":periodeID", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)['zetels'];
    }

    return 0;
  }

  public function magStemmen(Periode $periode) {
    return $this->getAantalGestemd($periode) < $this->getTotaalStemmen($periode);
  }

  /**
   * getZetels
   *
   * @param  PDO $conn
   *
   * @return int
   */
  public function getZetels(PDO $conn) {
    
    $stmt = $conn->prepare("SELECT * FROM `groepen`");
    
    $gebruikerID = $this->getID();

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)['zetels'];
    }
    return 0;
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

  /**
   * isIngelogd
   *
   * @param  PDO $conn
   *
   * @return Gebruiker[]|bool
   */
  public static function getGebruikers(PDO $conn) {
    $stmt = $conn->prepare("SELECT * FROM `gebruikers`");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $gebruikers = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $gebruiker) {
        array_push($gebruikers, new Gebruiker($conn, $gebruiker));
      }
      return $gebruikers;
    }

    return false;
  }

}

?>