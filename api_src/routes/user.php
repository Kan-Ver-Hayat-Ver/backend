<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

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
    $app->post('/register/{device_id}', function (Request $request, Response $response, array $args) {
    global $db, $return;
    $req_data = $request->getParsedBody();

    try {
        $query = $db->prepare('SELECT id FROM user_details WHERE device_id = ?');
        $query->execute([@$args['device_id']]);

        if (!$query->rowCount()) {
            $query = $db->prepare('INSERT INTO users SET identity_number = ?, `name` = ?, surname = ?, phone_number = ?, reg_ip = ?, reg_date = ?');
            $insert = $query->execute([
                @$req_data['identity_number'],
                @$req_data['name'],
                @$req_data['surname'],
                @$req_data['phone_number'],
                @$req_data['reg_ip'],
                @$req_data['reg_date']
            ]);
            $user_id = $db->lastInsertId();

            if ($insert) {
                $query = $db->prepare('INSERT INTO user_details SET user_id = ?, device_id = ?');
                $insert = $query->execute([$user_id, @$args['device_id']]);
            } else {
                $return['msg'] = 'Failed create user';
            }

            if ($insert) {
                $return['status'] = 1;
                $return['msg'] = 'User created';
            } else {
                $return['msg'] = 'Failed create user';
            }

        } else {
            $return['msg'] = 'User already exists';
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
    $app->post('/register_details/{device_id}', function (Request $request, Response $response, array $args) {
    global $db, $return;
    $req_data = $request->getParsedBody();

    try {
        $query = $db->prepare('SELECT id FROM user_details WHERE device_id = ?');
        $query->execute([@$args['device_id']]);

        if ($query->rowCount()) {
            $query = $db->prepare('UPDATE user_details SET province = ?, district = ?, neighborhood = ?, latitude = ?, longitude = ? WHERE device_id = ?');
            $update = $query->execute([
                @$req_data['province'],
                @$req_data['district'],
                @$req_data['neighborhood'],
                @$req_data['latitude'],
                @$req_data['longitude'],
                $args['device_id']
            ]);

            if ($update) {
                $return['status'] = 1;
                $return['msg'] = 'Update sucessful';
            } else {
                $return['msg'] = 'Update failed';
            }
        } else {
            $return['msg'] = 'User not exists';
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