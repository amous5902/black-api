<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// Proxy InfinityFree DB API
$url = "https://api.infiniaentertainment.in/api/db-events.php";

$response = file_get_contents($url);

if ($response === false) {
    http_response_code(500);
    echo json_encode([
        "error" => "Failed to fetch events"
    ]);
    exit;
}

echo $response;
