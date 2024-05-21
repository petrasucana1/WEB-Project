<?php
include_once __DIR__ . '/config/config.php';

class Database extends mysqli {
    function __construct() {
        global $host, $username, $password, $database;
        parent::__construct($host, $username, $password, $database);
        if ($this->connect_error) {
            echo "Fail to connect to DataBase :" . $this->connect_error;
        }
    }
    function importCSV($file, $tableName, $fields) {
        // Deschide fișierul CSV în modul de citire
        $handle = fopen($file, "r");
        if ($handle !== FALSE) {
            // Verifică dacă există deja date în tabelul din baza de date
            $existingData = $this->query("SELECT COUNT(*) FROM $tableName")->fetch_row()[0];
            if ($existingData > 0) {
                echo "Data already exists in the table. Import aborted.";
                return;
            }
            // Construiește șablonul pentru instrucțiunea pregătită
            $sql = "INSERT INTO $tableName (`" . implode("`, `", explode(", ", $fields)) . "`) VALUES (";
            $placeholders = rtrim(str_repeat("?,", count(explode(", ", $fields))), ",");
            $sql .= $placeholders . ")";
            
            // Preparează instrucțiunea SQL
            $stmt = $this->prepare($sql);
            if ($stmt === FALSE) {
                echo "Error preparing SQL statement: " . $this->error;
                return;
            }
            
            // Iterează prin fiecare linie a fișierului CSV
            while (($data = fgetcsv($handle)) !== FALSE) {
                // Bind parametrii 
                $types = str_repeat("s", count($data)); 
                $stmt->bind_param($types, ...$data);
                $result = $stmt->execute();
                if (!$result) {
                    echo "Error inserting data: " . $stmt->error;
                }
            }
            
            fclose($handle);
            echo "CSV data imported successfully.";
        } else {
            echo "Error opening CSV file.";
        }
    }
    function getAllNominees() {
        $result = $this->query("SELECT * FROM nominees");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getNomineeById($id) {
        $stmt = $this->prepare("SELECT * FROM nominees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function createNominee($data) {
        $sql = "INSERT INTO nominees (`Last Name`, `First Name`, `Category`, `Project`, `Year`, `Show`, `Award`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssiss", $data['LastName'], $data['FirstName'], $data['Category'], $data['Project'], $data['Year'], $data['Show'], $data['Award']);
        return $stmt->execute();
    }

    function updateNominee($id, $data) {
        $sql = "UPDATE nominees SET `Last Name` = ?, `First Name` = ?, `Category` = ?, `Project` = ?, `Year` = ?, `Show` = ?, `Award` = ? WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssissi", $data['LastName'], $data['FirstName'], $data['Category'], $data['Project'], $data['Year'], $data['Show'], $data['Award'], $id);
        return $stmt->execute();
    }

    function deleteNominee($id) {
        $stmt = $this->prepare("DELETE FROM nominees WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>