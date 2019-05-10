<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class ExcelImport {
  public static function LaadGebruikers($conn, $uploaded_file, $periodeID) {

      //Controleer het bestand
      try {
        //Maak een Excel Reader aan
        $reader = new Xlsx();
        //Laad het geuploaden bestand naar een variable
        $spreadsheet = $reader->load($uploaded_file["tmp_name"]);
        //Kijk of er iets fout is gegaan
      } catch (Exception $e) {
        //Stop het script
        echo "Er is iets fout met het bestand dat je probeert te uploaden";
        die();
      }

      $worksheet = $spreadsheet->getActiveSheet();

      $highestRow = $worksheet->getHighestRow();
      $highestColumn = $worksheet->getHighestColumn();
      $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

      $huidigeGroep = '';
      $aantalZetels = 0;
      
      $stmt = $conn->prepare("DELETE FROM periode_groepen WHERE periodeID = :pID");
      $stmt->bindParam(":pID", $periodeID);
      $stmt->execute();

      for ($row = 2; $row <= $highestRow; $row++) {

        $value = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $gebruiker = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

        if (!empty($value) && !endsWith($value, 'zetels') && !endsWith($value, 'zetel')) {
          $huidigeGroep = $value;

          // $aantalZetels = substr($worksheet->getCellByColumnAndRow(1, $row + 1)->getValue(),0,1);
          $aantalZetels = $worksheet->getCellByColumnAndRow(1, $row + 1)->getValue()[0];
        }

        $gebruikerCode = strtoupper(str_replace('@summacollege.nl','',$gebruiker));
        
        ExcelImport::addGebruiker($conn, $periodeID, $gebruikerCode, $huidigeGroep, $aantalZetels);
        
      }
  }

  private static function addGebruiker(PDO $conn, $periodeID, $gebruikerCode, $groep, $stemmen) {

    $stmt = $conn->prepare("INSERT INTO periode_groepen (periodeID, gebruikerCode, groep, stemmen) VALUES (:pID, :gCode, :groep, :stemmen)");
    $stmt->bindParam(':pID', $periodeID);
    $stmt->bindParam(':gCode', $gebruikerCode);
    $stmt->bindParam(':groep', $groep);
    $stmt->bindParam(':stemmen', $stemmen);
    $stmt->execute();

    return $stmt->rowCount() > 0;
  }
}