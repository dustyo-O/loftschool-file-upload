<?php
    foreach($_POST as $hash => $title) {
        $json_file = 'u/' . $hash . '/index.json';

        $json = file_get_contents($json_file);
        $data = json_decode($json, true);
        $data['title'] = $title;
        file_put_contents($json_file, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    echo '{"status": "ok"}';