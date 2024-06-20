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

    public function createActor(){
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['name', 'gender', 'popularity', 'profile_path', 'known_for_departament', 'biography', 'place_of_birth', 'birthday'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $newActorId = $this->actorModel->addActor($data);
    
        http_response_code(201);
        header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $newActorId);
        echo json_encode(['message' => 'Actor created successfully']);
    }

    public function updateActor($id){
          $json_data = file_get_contents('php://input');
          $data = json_decode($json_data, true);

          if ($data === null) {
              http_response_code(400);
              echo json_encode(['error' => 'Invalid JSON data']);
              return;
          }

          $required_fields = ['name', 'gender', 'popularity', 'profile_path', 'known_for_departament', 'biography', 'place_of_birth', 'birthday'];
            
          foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;
                }
          }  

        $result = $this->actorModel->editActor($data['id'],$data['name'],$data['gender'], $data['popularity'], $data['profile_path'], $data['known_for_departament'], $data['biography'], $data['place_of_birth'], $data['birthday']);

        if($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Actor updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Actor not found']);
        }
    }

    public function deleteActor($id){
        $success= $this->actorModel->deleteActor($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'Actor deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Actor not found']);
        }
    }

    
}

?>