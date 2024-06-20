<?php

class Router {
    public function dispatch() {

        $method = $_SERVER['REQUEST_METHOD'];

        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

        $segments = explode('/', $url);

        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DefaultController';

        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            http_response_code(404);
            echo '404 Not Found';
            exit;
        }
        $controller = new $controllerName();
 
        switch ($method) {
            case 'GET':
                if ($controllerName === 'NomineesController') {
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        //GET /nominees/{id}
                        $controller->getNominee($segments[1]);
                    } elseif (isset($_GET['year'])) {
                        $year = $_GET['year'];
                        if (is_numeric($year) && intval($year) > 0) {
                            // GET /nominees?year={year}
                            $controller->getNomineesByYear($year);
                        } else {
                            http_response_code(400); // Bad Request
                            echo '400 Bad Request: Invalid year parameter';
                            exit;
                        }
                    } else {
                        // GET /nominees
                        $controller->getNominees();
                    }
                }elseif($controllerName === 'ActorsController'){
                    // GET /actors/{id}
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                          $controller->getActorById($segments[1]);
                    } elseif (isset($_GET['name'])) {
                        
                        $name = urldecode($_GET['name']);
                        echo $name;
                        // GET /actors?name={name}
                        $controller->getActorByName($name);
                    } else {
                        // GET /actors
                        $controller->getActors();
                    }
                }elseif($controllerName === 'MoviesController'){
                    // GET /movies/{id}
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        $controller->getMoviesByActorId($segments[1]);
                    } else {
                        // GET /movies
                        $controller->getMovies();
                    }
                }elseif($controllerName === 'NewsController'){
                    // GET /news
                    $controller->getNews();
                    
                }else {
                    // Handle 405 Method Not Allowed for other controllers
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'PUT':
                if ($controllerName === 'NomineesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // PUT /nominees/{id}
                    $controller->updateNominee($segments[1]);
                }elseif($controllerName === 'ActorsController' && !empty($segments[1]) && is_numeric($segments[1])){
                    // PUT /actors/{id}
                    $controller->updateActor($segments[1]);
                }elseif($controllerName === 'MoviesController' && !empty($segments[1]) && is_numeric($segments[1])){
                    // PUT /movies/{id}
                    $controller->updateMovie($segments[1]);
                }elseif($controllerName === 'NewsController' && !empty($segments[1]) && is_numeric($segments[1])){
                    // PUT /news/{id}
                    $controller->updateNews($segments[1]);
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'POST':
                if ($controllerName === 'NomineesController' && empty($segments[1])) {
                    //POST /nominees
                    $controller->createNominee();
                }elseif ($controllerName === 'ActorsController' && empty($segments[1])) {
                    //POST /actors
                    $controller->createActor();
                }elseif ($controllerName === 'MoviesController' && empty($segments[1])) {
                    //POST /movies
                    $controller->createMovie();
                }elseif ($controllerName === 'NewsController' && empty($segments[1])) {
                    //POST /news
                    $controller->createNews();
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'NomineesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // DELETE /nominees/{id}
                    $controller->deleteNominee($segments[1]);
                }elseif ($controllerName === 'ActorsController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // DELETE /actors/{id}
                    $controller->deleteActor($segments[1]);
                }elseif ($controllerName === 'MoviesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // DELETE /movies/{id}
                    $controller->deleteMovie($segments[1]);
                }elseif ($controllerName === 'NewsController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // DELETE /news/{id}
                    $controller->deleteNews($segments[1]);
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