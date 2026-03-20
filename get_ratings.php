<?php
header('Content-Type: application/json');

$dataFile = 'ratings.json';

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true);
    if (is_array($data)) {
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        echo '{}';
    }
} else {
    echo '{}';
}
?>
