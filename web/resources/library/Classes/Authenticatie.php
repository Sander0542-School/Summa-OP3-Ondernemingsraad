<?php

class Authenticatie
{
  const LOGIN_SUCCESS = 0;
  const LOGIN_INVALID_SESSION = 1;
  const LOGIN_INVALID_DATA = 2;

  public static function login(PDO $conn, array $session)
  {
    try {
      if (isset($session["samlUserdata"]) && isset($session['samlNameId'])) {
        $stmtCheck = $conn->prepare("SELECT id FROM gebruikers WHERE gebruikersnaam = :userID");
        $stmtCheck->bindParam(":userID", $session["samlNameId"]);
        $stmtCheck->execute();
        if ($stmtCheck->rowCount() == 1) {
          try {
            //Gebruiker bestaat al
            $stmtUpdate = $conn->prepare("UPDATE gebruikers SET voornaam = :voornaam, achternaam = :achternaam WHERE gebruikersnaam = :userID");
            $stmtUpdate->bindParam(":userID", $session["samlNameId"]);
            $stmtUpdate->bindParam(":voornaam", $session["samlUserdata"]["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname"][0]);
            $stmtUpdate->bindParam(":achternaam", $session["samlUserdata"]["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname"][0]);
            $stmtUpdate->execute();
          } catch (Exception $exception) { }
        } else {
          try {
            //Gebruiker bestaat nog niet
            $stmtNieuw = $conn->prepare("INSERT INTO gebruikers (gebruikersnaam, voornaam, achternaam) VALUES (:userID, :voornaam, :achternaam);");
            $stmtNieuw->bindParam(":userID", $session["samlNameId"]);
            $stmtNieuw->bindParam(":voornaam", $session["samlUserdata"]["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname"][0]);
            $stmtNieuw->bindParam(":achternaam", $session["samlUserdata"]["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname"][0]);
            $stmtNieuw->execute();
            if ($stmtNieuw->rowCount() != 1) {
              return Authenticatie::LOGIN_INVALID_DATA;
            }
          } catch (Exception $exception) { }
        }
        try {
          $stmtUser = $conn->prepare("SELECT id FROM gebruikers WHERE gebruikersnaam = :userID");
          $stmtUser->bindParam(":userID", $session["samlNameId"]);
          $stmtUser->execute();
          //Set userSession to the UserID;
          $_SESSION["userSession"] = $stmtUser->fetch(PDO::FETCH_ASSOC)["id"];
        } catch (Exception $exception) { }
        return Authenticatie::LOGIN_SUCCESS;
      }
    } catch (Exception $exception) { }
    return Authenticatie::LOGIN_INVALID_SESSION;
  }

  /**
   * Destroy the session and log the user out
   */
  public static function loguit()
  {
    session_start();
    session_unset();
    session_destroy();
  }
}