<?php
// Include the init.php file to initialize the application
require_once __DIR__ . '/../init.php';

//require __DIR__ . '/../mash-rest/TMDBInserter.php';



// Instantiate the router and dispatch the request
$router = new Router();
$router->dispatch();



//require __DIR__ . '/../views/Nom.php';



?>