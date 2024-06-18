<?php

class Router {
    public function dispatch() {

        // Get the request method
        $method = $_SERVER['REQUEST_METHOD'];


        // Get the request URL
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

        // Split the URL into segments
        $segments = explode('/', $url);

        // Extract the controller and method from the URL
        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DefaultController';
        //$methodName = !empty($segments[1]) ? $segments[1] : 'index';

        // Extract parameters from URL segments
        //$params = array_slice($segments, 2);

        // Include the controller file
        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            http_response_code(404);
            echo '404 Not Found';
            exit;
        }

        // Instantiate the controller and call the method
        $controller = new $controllerName();
       
       
        // Call the appropriate method based on HTTP method
        switch ($method) {
            case 'GET':
                if ($controllerName === 'NomineesController') {
                    // Handle GET /nominee and GET /nominee/{id}
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        // GET /nominee/{id}
                        $controller->getNominee($segments[1]);
                    } elseif (isset($_GET['year'])) {
                        // Check if year parameter is present
                        $year = $_GET['year'];
                        
                        // Validate the year parameter
                        if (is_numeric($year) && intval($year) > 0) {
                            // GET /nominees?year={year}
                            $controller->getNomineesByYear($year);
                        } else {
                            // Handle invalid year parameter
                            http_response_code(400); // Bad Request
                            echo '400 Bad Request: Invalid year parameter';
                            exit;
                        }
                    } else {
                        // GET /nominees
                        $controller->getNominees();
                    }
                }elseif($controllerName === 'ActorsController'){
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                          $controller->getActorById($segments[1]);
                    } elseif (isset($_GET['name'])) {
                        
                        $name = urldecode($_GET['name']);
                        echo $name;
                        $controller->getActorByName($name);
                    } else {
                        $controller->getActors();
                    }
                }elseif($controllerName === 'MoviesController'){
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        $controller->getMoviesByActorId($segments[1]);
                    } else {
                        $controller->getMovies();
                    }
                }else {
                    // Handle 405 Method Not Allowed for other controllers
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'PUT':
                if ($controllerName === 'NomineesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // Handle PUT /nominee/{id}
                    $controller->updateNominee($segments[1]);
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'POST':
                if ($controllerName === 'NomineesController' && empty($segments[1])) {
                    // Handle POST /nominees
                    $controller->createNominee();
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'NomineesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // Handle DELETE /nominees/{id}
                    $controller->deleteNominee($segments[1]);
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            default:
                // Handle other HTTP methods
                http_response_code(405);
                echo '405 Method Not Allowed';
                exit;
        }
    }
}

?>