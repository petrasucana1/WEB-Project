<?php

class NomineesController{
    private $nomineeModel;

    public function __construct(){
        $this->nomineeModel= new Nominee();
    }

    public function getNominees(){
        http_response_code(200);
        echo json_encode($this->nomineeModel->getAllNominees());
    }

    public function getNominee($id){
        $nominee=$this->nomineeModel->getNomineeById($id);
        if($nominee) {
            http_response_code(200);
            echo json_encode($nominee);
            return;
        }
        http_response_code(404);
        echo '404 Not Found';
    }

    public function getNomineesByYear($year){
        http_response_code(200);
        $nominees = $this->nomineeModel->getNomineesByYear($year);
        ob_start();
         include BASE_PATH . '/views/NomineesView.php';
         $nomineesHTML = ob_get_clean();
          echo json_encode(array(
             'nomineesHTML' => $nomineesHTML
         ));
    }

    public function createNominee(){
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['Last Name', 'First Name', 'Category', 'Project','Year','Show','Award'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $newNomineeId = $this->nomineeModel->addNominee($data);
    
        http_response_code(201);
        header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $newNomineeId);
        echo json_encode(['message' => 'Nominee created successfully']);
    }

    public function updateNominee($id){
          $json_data = file_get_contents('php://input');
          $data = json_decode($json_data, true);
      
          if ($data === null) {
              http_response_code(400);
              echo json_encode(['error' => 'Invalid JSON data']);
              return;
          }

        $required_fields = ['Last Name', 'First Name', 'Category', 'Project','Year','Show','Award'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $result = $this->nomineeModel->editNominee($data['Id'],$data['Last Name'],$data['First Name'],$data['Category'],$data['Project'],$data['Year'],$data['Show'],$data['Award']);
        if($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Nominee updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Nominee not found']);
        }
    }

    public function deleteNominee($id){
        $success= $this->nomineeModel->deleteNominee($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'Nominee deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Nominee not found']);
        }
    }
}

?>