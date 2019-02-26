<?php
class StemResultaat {
  private $conn;
  private $record;

  /**
   * __construct
   *
   * @param  PDO $conn
   * @param  array $record
   *
   * @return void
   */
  private function __construct(PDO $conn, array $record) {
    $this->conn = $conn;
    $this->record = $record;
  }

  /**
   * getVerkiesbare
   *
   * @return Verkiesbare
   */
  public function getVerkiesbare() {
    return Verkiesbare::fromID($this->conn, $this->record["verkiesbare_id"]);
  }

  /**
   * fromArray
   *
   * @param  PDO $conn
   * @param  array $record
   *
   * @return StemResultaat
   */
  public static function fromArray(PDO $conn, array $record) {
    return new StemResultaat($conn, $record);
  }
}