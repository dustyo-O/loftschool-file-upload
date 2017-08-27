<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$uploaddir = 'u/';
$hash_folder = '';
while(is_dir($uploaddir)) {
    $hash_folder = generateRandomString();
    $uploaddir = 'u/' . $hash_folder . '/';
}
mkdir($uploaddir);
$file_name = basename($_FILES['file']['name']);
$uploadfile = $uploaddir . $file_name;

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    $index_json = [
        'filename' => $file_name,
        'title' => $file_name
    ];
    file_put_contents($uploaddir . 'index.json', 
        json_encode($index_json, JSON_UNESCAPED_UNICODE));
        
    echo json_encode([
        'folder' => $hash_folder
    ], JSON_UNESCAPED_UNICODE);
} else {
    header('HTTP/1.1 404 Not Found');
    echo "Possible file upload attack!\n";
}
