<?php

class Periode {
  const PERIODES_ALL = 0;
  const PERIODES_HUIDIG = 1;
  const PERIODES_AANKOMEND = 2;

  private $conn;
  private $record;

  /**
   * __construct
   *
   * @param  mixed $record
   */
  private function __construct(PDO $conn, array $record) {
    $this->conn = $conn;
    $this->record = $record;
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
   * getNaam
   *
   * @return string
   */
  public function getNaam() {
    return $this->record["naam"];
  }

  public function getStemmer(Gebruiker $gebruiker) {
    $gebruikerID = $gebruiker->getGebruikersnaam();
    $periodeID = $this->getID();

    $stmt = $this->conn->prepare("SELECT * FROM periode_groepen WHERE gebruikerCode = :gebruikerID AND periodeID = :periodeID");
    $stmt->bindParam(":gebruikerID", $gebruikerID);
    $stmt->bindParam(":periodeID", $periodeID);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return PeriodeGroep::fromArray($this->conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }

  public function aantalGestemd(Gebruiker $gebruiker) {
    $gebruikerID = $gebruiker->getEncryptedID();
    $periodeID = $this->getID();

    $stmt = $this->conn->prepare("SELECT id FROM stemmen WHERE gebruiker = :gebruikerID AND verkiesbare_id IN (SELECT periode_id FROM verkiesbare WHERE periode_id = :periodeID)");
    $stmt->bindParam(":gebruikerID", $gebruikerID);
    $stmt->bindParam(":periodeID", $periodeID);
    $stmt->execute();

    return $stmt->rowCount();
  }

  public function maxStemmen(Gebruiker $gebruiker) {
    $stemmer = $this->getStemmer($gebruiker);
    if ($stemmer) {
      return $stemmer->getStemmen();
    }

    return 0;
  }

  public function magStemmen(Gebruiker $gebruiker) {
    $aantalStemmen = $this->aantalGestemd($gebruiker);
    $maxStemmen = $this->maxStemmen($gebruiker);

    return $aantalStemmen < $maxStemmen;
  }

  public function heeftGestemd(Gebruiker $gebruiker, Verkiesbare $verkiesbare) {
    $gebruikerID = $gebruiker->getEncryptedID();
    $verkiesbareID = $verkiesbare->getID();

    $stmt = $this->conn->prepare("SELECT id FROM stemmen WHERE gebruiker = :gebruikerID AND verkiesbare_id = :verkiesbareID");
    $stmt->bindParam(":gebruikerID", $gebruikerID);
    $stmt->bindParam(":verkiesbareID", $verkiesbareID);
    $stmt->execute();

    return $stmt->rowCount() == 0;
  }

  /**
   * getBeginDatum
   *
   * @param  mixed $format
   *
   * @return string
   */
  public function getBeginDatum($format = null) {
    return DateTime::createFromFormat('Y-m-d H:i:s', $this->record["begin"])->format($format !== null ? $format : Variables::DATE_FORMAT);
  }

  /**
   * getEindDatum
   *
   * @param  mixed $format
   *
   * @return string
   */
  public function getEindDatum($format = null) {
    return DateTime::createFromFormat('Y-m-d H:i:s', $this->record["eind"])->format($format !== null ? $format : Variables::DATE_FORMAT);
  }

  public function updatePeriode($naam, $beginDatum, $eindDatum) {
    $stmt = $this->conn->prepare("UPDATE `periodes` SET `naam` = :naam, `begin` = :beginDatum, `eind` = :eindDatum  WHERE `id` = :periodeID");

    $periodeID = $this->getID();

    $stmt->bindParam(":periodeID", $periodeID);
    $stmt->bindParam(":naam", $naam);
    $stmt->bindParam(":beginDatum", $beginDatum);
    $stmt->bindParam(":eindDatum", $eindDatum);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
        }

    return false;
  }

  /**
   * getAantalStemmen
   *
   * @return int
   */
  public function getAantalStemmen() {
    $stmt = $this->conn->prepare("SELECT id FROM stemmen WHERE verkiesbare_id IN (SELECT id FROM verkiesbare WHERE periode_id = :periode)");

    $periodeID = $this->getID();

    $stmt->bindParam(":periode", $periodeID);

    $stmt->execute();

    return $stmt->rowCount();
  }

  /**
   * getaantalVerkiesbaar
   *
   * @return Verkiesbare[]|bool
   */
  public function getVerkiesbare(Gebruiker $gebruiker = null) {
    if (!is_null($gebruiker)) {
      $stmt = $this->conn->prepare("SELECT * FROM `verkiesbare` WHERE `gebruiker_id` IN( SELECT `id` FROM `gebruikers` WHERE `gebruikersnaam` IN ( SELECT `gebruikerCode` FROM `periode_groepen` WHERE `groep` LIKE ( SELECT `groep` FROM `periode_groepen` WHERE `gebruikerCode` = :gebruikerCode AND `periode_id` = :periodeID) ) )");
    } else {
      $stmt = $this->conn->prepare("SELECT * FROM verkiesbare WHERE periode_id = :periode AND gekeurd = 1 AND ");
    }

    $periodeID = $this->getID();
    $gebruikerCode = $gebruiker->getGebruikersnaam();

    $stmt->bindParam(":periodeID", $periodeID);
    $stmt->bindParam(":gebruikerCode", $gebruikerCode);

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

  public function getStemmers() {
    $stmt = $this->conn->prepare("SELECT * FROM periode_groepen WHERE periodeID = :periode");

    $periodeID = $this->getID();

    $stmt->bindParam(":periode", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $groepen = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $periodeGroep) {
        array_push($groepen, PeriodeGroep::fromArray($this->conn, $periodeGroep));
      }
      return $groepen;
    }

    return false;
  }

  public static function addPeriode(PDO $conn, $naam, $beginDatum, $eindDatum) {
    $stmt = $conn->prepare("INSERT INTO `periodes` (`naam`, `begin`, `eind`) VALUES (:naam, :beginDatum, :eindDatum)");

    $stmt->bindParam(":naam", $naam);
    $stmt->bindParam(":beginDatum", $beginDatum);
    $stmt->bindParam(":eindDatum", $eindDatum);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }
    return false;
  }

  /**
   * getPeriodes
   *
   * @param  mixed $conn
   *
   * @return Periode[]|false
   */
  public static function getPeriodes(PDO $conn, int $type = self::PERIODES_ALL) {

    switch ($type) {
      case self::PERIODES_AANKOMEND:
        $sql = "SELECT * FROM periodes WHERE NOW() BETWEEN DATE(begin) - INTERVAL 3 MONTH AND DATE(begin) - INTERVAL 1 WEEK ORDER BY begin ASC";
        break;
      case self::PERIODES_HUIDIG:
        $sql = "SELECT * FROM periodes WHERE NOW() BETWEEN begin AND eind ORDER BY begin ASC";
        break;
      default:
        $sql = "SELECT * FROM periodes ORDER BY begin ASC";
        break;
    }

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $periodes = array();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $periode) {
        array_push($periodes, new Periode($conn, $periode));
      }
      return $periodes;
    }
    return false;
  }

  public static function getHuidige(PDO $conn) {
    $stmt = $conn->prepare("SELECT * FROM periodes WHERE NOW() BETWEEN begin AND eind ORDER BY begin ASC LIMIT 1");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Periode($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }

  public static function getOpkomende(PDO $conn) {
    $stmt = $conn->prepare("SELECT * FROM periodes WHERE begin > NOW() ORDER BY begin ASC LIMIT 1");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Periode($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }

  /**
   * fromID
   *
   * @param  PDO $conn
   * @param  int $periodeID
   *
   * @return Periode|bool
   */
  public static function fromID(PDO $conn, $periodeID) {
    $stmt = $conn->prepare("SELECT * FROM `periodes` WHERE `id` = :periodeID");
    $stmt->bindParam(":periodeID", $periodeID);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return new Periode($conn, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
  }
}