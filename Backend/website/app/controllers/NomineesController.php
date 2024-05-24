<?php

class NomineesController{
    private $nomineeModel;

    public function __construct(){
        $this->nomineeModel= new Nominee();
    }

    public function getNominees(){
        // Send response with status code 200
        http_response_code(200);
        echo json_encode($this->nomineeModel->getAllNominees());
    }

    public function getNominee($id){
        $nominee=$this->nomineeModel->getNomineeById($id);
        if($nominee) {
            // Send response with status code 200
            http_response_code(200);
            echo json_encode($nominee);
            return;
        }
        // Send response with status code 404 if user not found
        http_response_code(404);
        echo '404 Not Found';
    }

    public function createNominee(){
        // Get the JSON data from the request body
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        // Check if JSON data is valid
        if ($data === null) {
            // Send response with status code 400 for invalid JSON
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
    
        // Define the required fields
        $required_fields = ['Last Name', 'First Name', 'Category', 'Project','Year','Show','Award'];

        // Check if all required fields are present in the JSON data
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                // Send response with status code 400 for missing fields
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $newNomineeId = $this->nomineeModel->addNominee($data);
    
        // Send response with status code 201 and location header
        http_response_code(201);
        header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $newNomineeId);
        echo json_encode(['message' => 'Nominee created successfully']);
    }

    public function updateNominee($id){
          // Get the JSON data from the request body
          $json_data = file_get_contents('php://input');
          $data = json_decode($json_data, true);
      
          // Check if JSON data is valid
          if ($data === null) {
              // Send response with status code 400 for invalid JSON
              http_response_code(400);
              echo json_encode(['error' => 'Invalid JSON data']);
              return;
          }

          // Define the required fields
        $required_fields = ['Last Name', 'First Name', 'Category', 'Project','Year','Show','Award'];

        // Check if all required fields are present in the JSON data
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                // Send response with status code 400 for missing fields
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $result = $this->nomineeModel->editNominee($data['Id'],$data['Last Name'],$data['First Name'],$data['Category'],$data['Project'],$data['Year'],$data['Show'],$data['Award']);

        //You can be more thorough with error codes for example and include the 204 no content
        if($result) {
            // Send response with status code 200 if nominee was updated
            http_response_code(200);
            echo json_encode(['message' => 'Nominee updated succesfully']);
        } else {
            // Send response with status code 404 if nominee not found
            http_response_code(404);
            echo json_encode(['error' => 'Nominee not found']);
        }
    }

    public function deleteNominee($id){
        $success= $this->nomineeModel->deleteNominee($id);

        if ($success) {
            // Remove the nominee from the nominees array

            // Send response with status code 200
            http_response_code(200);
            echo json_encode(['message' => 'Nominee deleted successfully']);
        } else {
            // Send response with status code 404 if nominee not found
            http_response_code(404);
            echo json_encode(['error' => 'Nominee not found']);
        }
    }
}

?>