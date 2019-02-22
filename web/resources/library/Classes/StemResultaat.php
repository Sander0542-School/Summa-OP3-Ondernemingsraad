<?php
class StemResultaat {
  private $conn;
  private $record;

  private function __construct(PDO $conn, array $record) {
    $this->conn = $conn;
    $this->record = $record;
  }

  public function getVerkiesbare() {
    return Verkiesbare::fromID($this->conn, $this->record["verkiesbare_id"]);
  }

  public static function fromArray(PDO $conn, array $record) {
    return new StemResultaat($conn, $record);
  }
}