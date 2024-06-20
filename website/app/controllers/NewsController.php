<?php

class NewsController{
    private $newsModel;

    public function __construct(){
        $this->newsModel= new News();
    }

    public function getNews(){
        http_response_code(200);
        echo json_encode($this->newsModel->getAllNews());
    }


    public function createNews(){
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['Title', 'Date', 'Link'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $newNewsId = $this->newsModel->addNews($data);
    
        http_response_code(201);
        header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $newNewsId);
        echo json_encode(['message' => 'News created successfully']);
    }

    public function updateNews($id){
          $json_data = file_get_contents('php://input');
          $data = json_decode($json_data, true);

          if ($data === null) {
              http_response_code(400);
              echo json_encode(['error' => 'Invalid JSON data']);
              return;
          }

          $required_fields = ['Title', 'Date', 'Link'];
            
          foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;
                }
          }  

        $result = $this->newsModel->editNews($data['Id'],$data['Title'],$data['Date'], $data['Link']);

        if($result) {
            http_response_code(200);
            echo json_encode(['message' => 'News updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'News not found']);
        }
    }

    public function deleteNews($id){
        $success= $this->newsModel->deleteNews($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'News deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'News not found']);
        }
    }
}

?>