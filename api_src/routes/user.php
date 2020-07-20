<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    $return = [];
    $return['status'] = 0;

    $app->get('/check_device/{device_id}', function (Request $request, Response $response, array $args) {
        global $db, $return;
        $device_id = @$args['device_id'];

        try {
            $query = $db->prepare('SELECT * FROM user_details WHERE device_id = ?');
            $query->execute([$device_id]);

            if ($query->rowCount()) {
                $return['status'] = 1;
                $return['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            }

            $response->getBody()->write(json_encode($return));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (PDOException $e) {
            $response->getBody()->write(json_encode($e));
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }
    });

?>