<?php
    date_default_timezone_set('Europe/Istanbul');

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    use Slim\Exception\NotFoundException;

    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../api_src/config/db.php';

    $db = new DB();
    $db = $db->connect();

    $app = AppFactory::create();
    $errorMiddleware = $app->addErrorMiddleware(1, 1, 1);
    $app->setBasePath('/backend/api');

    $return = [];
    $return['status'] = 0;

    #Functions
    require __DIR__ . '/../api_src/functions/authorize.php';

    #Routes
    require __DIR__ . '/../api_src/routes/user.php';

    $app->run();

?>