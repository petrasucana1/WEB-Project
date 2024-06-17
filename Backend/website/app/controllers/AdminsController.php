<?php

class AdminsController{
    private $adminModel;

    public function __construct(){
        $this->adminModel= new Admin();
    }

    public function getNominees(){
        http_response_code(200);
        echo json_encode($this->adminModel->getAdmins());
    }


    public function createNominee(){
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['Email', 'Password'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $newAdminId = $this->adminModel->addAdmin($data);
    
        http_response_code(201);
        header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $newAdminId);
        echo json_encode(['message' => 'Admin created successfully']);
    }

    public function updateAdmin($id){
          $json_data = file_get_contents('php://input');
          $data = json_decode($json_data, true);

          if ($data === null) {
              http_response_code(400);
              echo json_encode(['error' => 'Invalid JSON data']);
              return;
          }

          $required_fields = ['Email', 'Password'];
            
          foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;
                }
          }  

        $result = $this->adminModel->editAdmin($data['Id'],$data['Email'],$data['Password']);

        if($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Admin updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Admin not found']);
        }
    }

    public function deleteAdmin($id){
        $success= $this->adminModel->deleteAdmin($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'Admin deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Admin not found']);
        }
    }
}

?>