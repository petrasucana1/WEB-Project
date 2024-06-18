<?php

class ActorsController{
    private $actorModel;

    public function __construct(){
        $this->actorModel= new Actor();
    }

    public function getActors(){
        http_response_code(200);
        echo json_encode($this->actorModel->getAllActors());
    }

    public function getActorById($id){
        $actor=$this->actorModel->getActorById($id);
        if($actor) {
            http_response_code(200);
            echo json_encode($actor);
            return;
        }
        http_response_code(404);
        echo '404 Not Found';
    }

    public function getActorByName($name){
        $actor=$this->actorModel->getActorByName($name);
        if($actor) {
            http_response_code(200);
            echo json_encode($actor);
            return;
        }
        http_response_code(404);
        echo '404 Not Found';
    }
}

?>