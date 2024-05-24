<?php
/*
header("Content-Type: application/json");

include_once 'database.php'; // Asigură-te că calea este corectă

$database = new Database();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($requestMethod) {
    case 'GET':
        if ($endpoint == 'nominees') {
            if ($id) {
                getNomineeById($database, $id);
            } else {
                getAllNominees($database);
            }
        } else {
            echo json_encode(["message" => "Invalid endpoint"]);
        }
        break;

    case 'POST':
        if ($endpoint == 'nominees') {
            $data = json_decode(file_get_contents("php://input"), true);
            createNominee($database, $data);
        } elseif ($endpoint == 'import') {
            $file = 'csvDB/Nominees.csv';
            $tableName = 'nominees';
            $fields = 'Last Name, First Name, Category, Project, Year, Show, Award';
            $database->importCSV($file, $tableName, $fields);
        } else {
            echo json_encode(["message" => "Invalid endpoint"]);
        }
        break;

    case 'PUT':
        if ($endpoint == 'nominees' && $id) {
            $data = json_decode(file_get_contents("php://input"), true);
            updateNominee($database, $id, $data);
        } else {
            echo json_encode(["message" => "Invalid endpoint or ID missing"]);
        }
        break;

    case 'DELETE':
        if ($endpoint == 'nominees' && $id) {
            deleteNominee($database, $id);
        } else {
            echo json_encode(["message" => "Invalid endpoint or ID missing"]);
        }
        break;

    default:
        echo json_encode(["message" => "Request method not supported"]);
        break;
}

function getAllNominees($database) {
    $nominees = $database->getAllNominees();
    echo json_encode($nominees);
}

function getNomineeById($database, $id) {
    $nominee = $database->getNomineeById($id);
    echo json_encode($nominee);
}

function createNominee($database, $data) {
    $result = $database->createNominee($data);
    if ($result) {
        echo json_encode(["message" => "Nominee created successfully"]);
    } else {
       // http_response_code(400);
        echo json_encode(["message" => "Error creating nominee"]);
    }
}

function updateNominee($database, $id, $data) {
    $result = $database->updateNominee($id, $data);
    if ($result) {
        echo json_encode(["message" => "Nominee updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating nominee"]);
    }
}

function deleteNominee($database, $id) {
    $result = $database->deleteNominee($id);
    if ($result) {
        echo json_encode(["message" => "Nominee deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting nominee"]);
    }
}*/
?>
