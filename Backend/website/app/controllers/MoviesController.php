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

}

?>