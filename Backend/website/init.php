<?php
define('BASE_PATH', dirname(__DIR__)."/website");

require_once(BASE_PATH . '/app/config/config.php');

spl_autoload_register(function ($class) {
    $directories = [
        BASE_PATH . '/app/',
        BASE_PATH . '/app/controllers/',
        BASE_PATH . '/app/models/',
        BASE_PATH . '/views/',
        BASE_PATH . '/views/styles',
        BASE_PATH . '/views/photos',
        BASE_PATH . '/views/components',
        BASE_PATH . '/public/',
       //BASE_PATH . '/mash-rest/'
    ];

    foreach ($directories as $directory) {
        $file = $directory . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return; 
        }
    }
});



?>