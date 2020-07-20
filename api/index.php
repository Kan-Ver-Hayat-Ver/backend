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
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $app->setBasePath('/backend/api');

    #Routes
    require __DIR__ . '/../api_src/routes/user.php';

    $app->run();

?>