<?php

require_once(dirname(__DIR__) . '../config/config.php');
require_once(dirname(__DIR__) . '../Db.php');

class News extends DB{

    function getAllNews(){
        try {
            $sql = "SELECT * FROM news";
            $stmt = $this->pdo->query($sql);
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $news;
        } catch (PDOException $e) {
            echo "Error fetching nominees: " . $e->getMessage();
            return null;
        } 
    }

    function getNewsWithPagination($offset, $limit) {
        try {
            $sql = "SELECT * FROM news ORDER BY Date DESC LIMIT :offset, :limit";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $news;
        } catch (PDOException $e) {
            echo "Error fetching news: " . $e->getMessage();
            return null;
        }
    }

    public function addNews($data) {
        try {
            $sql = "INSERT INTO news (`Title`, `Date`, `Link`) 
                    VALUES (:title, :ndate, :link)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':ndate', $data['date'], PDO::PARAM_STR);
            $stmt->bindParam(':link', $data['link'], PDO::PARAM_STR);
            $stmt->execute();
            return ['message' => 'News added successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error adding news: ' . $e->getMessage()];
        }
    }

    function editNews($id, $title, $date, $link) {
        try {
            $sql = "UPDATE news SET `Title` = :title, `Date` = :ddate, 'Link' = :link WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':ddate', $date, PDO::PARAM_STR);
            $stmt->bindParam(':link', $link, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error editing news: " . $e->getMessage();
            return false;
        }
    }

    function deleteNews($id) {
        try {
            $sql = "DELETE FROM news WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error deleting news: " . $e->getMessage();
            return false;
        }
    }

}
?>
