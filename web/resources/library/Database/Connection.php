<?php

class Connection
{
  private $host = "127.0.0.1";
  private $db_name = "ondernemingsraad";
  private $username = "root";
  private $password = "";

  private $conn;

  /**
   * Connection constructor.
   */
  public function __construct()
  {
    try {
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8;", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
      exit("Connection Error: " . $exception->getMessage());
    }
    return $this;
  }

  /**
   * @return PDO Connection
   */
  public function getConnection()
  {
    return $this->conn;
  }
}