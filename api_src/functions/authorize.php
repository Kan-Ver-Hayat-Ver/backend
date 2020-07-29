<?php

    $key = @getallheaders()['api_key_secret'];

    $query = $db->prepare("SELECT * FROM settings WHERE setting = 'api_key' AND val = ?");
    $query->execute([$key]);

    if (!$query->rowCount()) {
        echo json_encode([
            'status' => 0,
            'msg' => 'API authentication failed.'
        ]);
        exit;
    }

?>