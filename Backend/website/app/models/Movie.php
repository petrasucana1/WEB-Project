<?php
require_once(dirname(__DIR__) . '../config/config.php');

require_once(dirname(__DIR__) . '../Db.php');

class Movie extends DB{

    function getAllMovies() {
        try {
            $sql = "SELECT * FROM movies";
            $stmt = $this->pdo->query($sql);
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $movies;
        } catch (PDOException $e) {
            echo "Error fetching movies: " . $e->getMessage();
            return null;
        }
    }

    function getMoviesByActorId($actor_id) {
        try {
            $sql = "SELECT * FROM movies WHERE actor_id = :actor_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
            $stmt->execute();
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $movies;
        } catch (PDOException $e) {
            echo "Error fetching movies: " . $e->getMessage();
            return null;
        }
    }

    public function addMovie($data) {
        try {
            $sql = "INSERT INTO movies (`actor_id`, `title`, `release_date`, `vote_average`, `poster_path`) 
                    VALUES (:actor_id, :title, :release_date, :vote_average, :poster_path)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_id', $data['actor_id'], PDO::PARAM_INT);
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':release_date', $data['release_date'], PDO::PARAM_STR);
            $stmt->bindParam(':vote_average', $data['vote_average'], PDO::PARAM_INT);
            $stmt->bindParam(':poster_path', $data['poster_path'], PDO::PARAM_STR);
            $stmt->execute();
            return ['message' => 'Movie created successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error adding movie: ' . $e->getMessage()];
        }
    }

    function editMovie($id, $actor_id, $title, $release_date, $vote_average, $poster_path) {
        try {
            $sql = "UPDATE movies SET `actor_id` = :actor_id, `title` = :title, `release_date` = :release_date, `vote_average` = :vote_average, `poster_path` = :poster_path WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':release_date', $release_date, PDO::PARAM_STR);
            $stmt->bindParam(':vote_average', $vote_average, PDO::PARAM_INT);
            $stmt->bindParam(':poster_path', $poster_path, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error editing movie: " . $e->getMessage();
            return false;
        }
    }

    function deleteMovie($id) {
        try {
            $sql = "DELETE FROM movies WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error deleting movie: " . $e->getMessage();
            return false;
        }
    }
}
?>