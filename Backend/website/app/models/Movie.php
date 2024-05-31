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
}
?>