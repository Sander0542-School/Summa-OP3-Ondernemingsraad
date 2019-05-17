<?php

class Connection
{
  private $host = "localhost";
  private $db_name = "or-verk-test1";
  private $username = "or-verk-test1";
  private $password = "t@AehWn2iQ";

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