<?php

require_once(dirname(__DIR__) . '../config/config.php');

require_once(dirname(__DIR__) . '../Db.php');

class Nominee extends DB{

    function getAllNominees() {
        try {
            $sql = "SELECT * FROM nominees";
            $stmt = $this->pdo->query($sql);
            $nominees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $nominees;
        } catch (PDOException $e) {
            echo "Error fetching nominees: " . $e->getMessage();
            return null;
        }
    }

    function getNomineeById($id) {
        try {
            $sql = "SELECT * FROM nominees WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $nominee = $stmt->fetch(PDO::FETCH_ASSOC);
            return $nominee;
        } catch (PDOException $e) {
            echo "Error fetching nominee: " . $e->getMessage();
            return null;
        }
    }

    function getNomineesByYear($year) {
        try {
            $sql = "SELECT * FROM nominees WHERE year = :year";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            $nominees= $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $nominees;
        } catch (PDOException $e) {
            echo "Error fetching nominee: " . $e->getMessage();
            return null;
        }
    }

    public function addNominee($data) {
        try {
            $sql = "INSERT INTO nominees (`First Name`, `Last Name`, `Category`, `Project`, `Year`, `Show`, `Award`) 
                    VALUES (:fName, :lName, :category, :project, :yr, :show, :award)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':fName', $data['First Name'], PDO::PARAM_STR);
            $stmt->bindParam(':lName', $data['Last Name'], PDO::PARAM_STR);
            $stmt->bindParam(':category', $data['Category'], PDO::PARAM_STR);
            $stmt->bindParam(':project', $data['Project'], PDO::PARAM_STR);
            $stmt->bindParam(':yr', $data['Year'], PDO::PARAM_INT);
            $stmt->bindParam(':show', $data['Show'], PDO::PARAM_INT);
            $stmt->bindParam(':award', $data['Award'], PDO::PARAM_STR);
            $stmt->execute();
            return ['message' => 'Nominee created successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error adding nominee: ' . $e->getMessage()];
        }
    }

    function editNominee($id, $lname, $fname, $category, $project, $yr, $show, $award) {
        try {
            $sql = "UPDATE nominees SET 
                `Last Name` = :lname, 
                `First Name` = :fname, 
                `Category` = :category, 
                `Project` = :project, 
                `Year` = :yr, 
                `Show` = :show, 
                `Award` = :award 
                WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':project', $project, PDO::PARAM_STR);
            $stmt->bindParam(':yr', $yr, PDO::PARAM_INT); 
            $stmt->bindParam(':show', $show, PDO::PARAM_INT);
            $stmt->bindParam(':award', $award, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error editing nominee: " . $e->getMessage();
            return false;
        }
    }

    function deleteNominee($id) {
        try {
            $sql = "DELETE FROM nominees WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error deleting nominee: " . $e->getMessage();
            return false;
        }
    }

    function importCSV($file) {
        try {
            $handle = fopen($file, "r");
            if ($handle === FALSE) {
                throw new Exception("Could not open the file!");
            }

            $sql = "INSERT INTO nominees (`First Name`, `Last Name`, `Category`, `Project`, `Year`, `Show`, `Award`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
    
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $stmt->execute($data);
            }
  
            fclose($handle);
    
            return true; 
        } catch (PDOException $e) {
            echo "Error importing data: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
        
}

?>