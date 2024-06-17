<?php
require_once(dirname(__DIR__) . '../config/config.php');

require_once(dirname(__DIR__) . '../Db.php');

class Admin extends DB{
    function getAdmins() {
        try {
            $sql = "SELECT * FROM admins";
            $stmt = $this->pdo->query($sql);
            $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $admins;
        } catch (PDOException $e) {
            echo "Error fetching admins: " . $e->getMessage();
            return null;
        }
    }

    public function addAdmin($data) {
        try {
            $sql = "INSERT INTO admins (`Email`, `Password`) VALUES (:email, :pass)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $data['Email'], PDO::PARAM_STR);
            $stmt->bindParam(':pass', $data['Password'], PDO::PARAM_STR);
            $stmt->execute();
            return ['message' => 'Admin created successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error adding admin: ' . $e->getMessage()];
        }
    }

    function editAdmin($id, $email, $pass) {
        try {
            $sql = "UPDATE admins SET `Email` = :email, `Password` = :pass WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error editing admin: " . $e->getMessage();
            return false;
        }
    }

    function deleteAdmin($id) {
        try {
            $sql = "DELETE FROM admins WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }
    }
}
?>