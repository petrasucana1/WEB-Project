<?php

class MoviesController{
    private $movieModel;

    public function __construct(){
        $this->movieModel= new Movie();
    }

    public function getMovies(){
        http_response_code(200);
        echo json_encode($this->movieModel->getAllMovies());
    }

    public function getMoviesByActorId($actor_id){
        $movies=$this->movieModel->getMoviesByActorId($actor_id);
        if($movies) {
            http_response_code(200);
            echo json_encode($movies);
            return;
        }
        http_response_code(404);
        echo '404 Not Found';
    }

    public function createMovie(){
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['actor_id', 'title', 'release_date', 'vote_average', 'poster_path'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $newMovieId = $this->movieModel->addMovie($data);
    
        http_response_code(201);
        header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $newMovieId);
        echo json_encode(['message' => 'Movie created successfully']);
    }

    public function updateMovie($id){
          $json_data = file_get_contents('php://input');
          $data = json_decode($json_data, true);

          if ($data === null) {
              http_response_code(400);
              echo json_encode(['error' => 'Invalid JSON data']);
              return;
          }

          $required_fields = ['actor_id', 'title', 'release_date', 'vote_average', 'poster_path'];
            
          foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;
                }
          }  

        $result = $this->movieModel->editMovie($data['id'],$data['actor_id'],$data['title'], $data['release_date'], $data['vote_average'], $data['poster_path']);

        if($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Movie updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Movie not found']);
        }
    }

    public function deleteMovie($id){
        $success= $this->movieModel->deleteMovie($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'Movie deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Movie not found']);
        }
    }
    

}

?>