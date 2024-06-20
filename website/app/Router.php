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
                        $controller->getNominee($segments[1]);
                    } elseif (isset($_GET['year'])) {
                        $year = $_GET['year'];
                        if (is_numeric($year) && intval($year) > 0) {
                            $controller->getNomineesByYear($year);
                        } else {
                            http_response_code(400); 
                            echo '400 Bad Request: Invalid year parameter';
                            exit;
                        }
                    } else {
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
                }elseif($controllerName === 'NewsController'){
                    $controller->getNews();
                    
                }else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'PUT':
                if ($controllerName === 'NomineesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    $controller->updateNominee($segments[1]);
                }elseif($controllerName === 'ActorsController' && !empty($segments[1]) && is_numeric($segments[1])){
                    $controller->updateActor($segments[1]);
                }elseif($controllerName === 'MoviesController' && !empty($segments[1]) && is_numeric($segments[1])){
                    $controller->updateMovie($segments[1]);
                }elseif($controllerName === 'NewsController' && !empty($segments[1]) && is_numeric($segments[1])){
                    $controller->updateNews($segments[1]);
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'POST':
                if ($controllerName === 'NomineesController' && empty($segments[1])) {
                    $controller->createNominee();
                }elseif ($controllerName === 'ActorsController' && empty($segments[1])) {
                    $controller->createActor();
                }elseif ($controllerName === 'MoviesController' && empty($segments[1])) {
                    $controller->createMovie();
                }elseif ($controllerName === 'NewsController' && empty($segments[1])) {
                    $controller->createNews();
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'NomineesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    $controller->deleteNominee($segments[1]);
                }elseif ($controllerName === 'ActorsController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    $controller->deleteActor($segments[1]);
                }elseif ($controllerName === 'MoviesController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    $controller->deleteMovie($segments[1]);
                }elseif ($controllerName === 'NewsController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    $controller->deleteNews($segments[1]);
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            default:
                http_response_code(405);
                echo '405 Method Not Allowed';
                exit;
        }
    }
}

?>