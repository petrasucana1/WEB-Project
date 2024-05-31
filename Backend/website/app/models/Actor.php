<?php
require_once(dirname(__DIR__) . '../config/config.php');

require_once(dirname(__DIR__) . '../Db.php');

class Actor extends DB{

    function getAllActors() {
        try {
            $sql = "SELECT * FROM actors";
            $stmt = $this->pdo->query($sql);
            $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $actors;
        } catch (PDOException $e) {
            echo "Error fetching actors: " . $e->getMessage();
            return null;
        }
    }

    function getActorById($id) {
        try {
            $sql = "SELECT * FROM actors WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $actor = $stmt->fetch(PDO::FETCH_ASSOC);
            return $actor;
        } catch (PDOException $e) {
            echo "Error fetching actor: " . $e->getMessage();
            return null;
        }
    }

    function getActorByName($name) {
        try {
            $sql = "SELECT * FROM actors WHERE name LIKE :name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $actor = $stmt->fetch(PDO::FETCH_ASSOC);
            return $actor;
        } catch (PDOException $e) {
            echo "Error fetching actor: " . $e->getMessage();
            return null;
        }
    }
}

?>