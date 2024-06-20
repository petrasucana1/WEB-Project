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

    function getTop10Actors() {
        try {
            $sql = "SELECT * FROM actors ORDER BY popularity DESC LIMIT 10";
            $stmt = $this->pdo->query($sql);
            $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $actors;
        } catch (PDOException $e) {
            echo "Error fetching actors: " . $e->getMessage();
            return null;
        }
    }

    function getTop20Actors() {
        try {
            $sql = "SELECT * FROM actors ORDER BY popularity DESC LIMIT 20";
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

    function getActorByString($input_string){
        try {
            $string = strtoupper($input_string);
            $sql = "SELECT * FROM actors WHERE name LIKE CONCAT('%', :name, '%')";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $string, PDO::PARAM_STR);
            $stmt->execute();
            $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $actors;
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
    public function addActor($data) {
        try {
            $sql = "INSERT INTO actors (`name`, `gender`, `popularity`, `profile_path`, `known_for_departament`, `biography`, `place_of_birth`, `birthday`) 
                    VALUES (:nname, :gender, :popularity, :picture_url, :departament, :bio, :birth_place, :birthday)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nname', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':gender', $data['gender'], PDO::PARAM_INT);
            $stmt->bindParam(':popularity', $data['popularity'], PDO::PARAM_INT);
            $stmt->bindParam(':picture_url', $data['picture_url'], PDO::PARAM_STR);
            $stmt->bindParam(':departament', $data['departament'], PDO::PARAM_STR);
            $stmt->bindParam(':bio', $data['bio'], PDO::PARAM_STR);
            $stmt->bindParam(':birth_place', $data['birth_place'], PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $data['birthday'], PDO::PARAM_STR);
            $stmt->execute();
            return ['message' => 'Actor created successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error adding actor: ' . $e->getMessage()];
        }
    }

    function editActor($id, $name, $gender, $popularity, $profile_path, $known_for_departament, $biography, $place_of_birth, $birthday) {
        try {
            $sql = "UPDATE actors SET `name` = :nname, `gender` = :gender, `popularity` = :popularity, `profile_path` = :profile_path, `known_for_departament` = :known_for_departament, `biography` = :biography, `place_of_birth` = :place_of_birth, 'birthday' =:birthday WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nname', $name, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':popularity', $popularity, PDO::PARAM_INT);
            $stmt->bindParam(':profile_path', $profile_path, PDO::PARAM_STR);
            $stmt->bindParam(':known_for_departament', $known_for_departament, PDO::PARAM_STR);
            $stmt->bindParam(':biography', $biography, PDO::PARAM_STR);
            $stmt->bindParam(':place_of_birth', $place_of_birth, PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error editing actor: " . $e->getMessage();
            return false;
        }
    }

    function deleteActor($id) {
        try {
            $sql = "DELETE FROM actors WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error deleting actor: " . $e->getMessage();
            return false;
        }
    }
}

?>