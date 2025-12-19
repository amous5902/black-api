<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$url = "https://api.infiniaentertainment.in/api/db-events.php";

$context = stream_context_create([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
        "allow_self_signed" => true
    ]
]);

$response = file_get_contents($url, false, $context);

if ($response === false) {
    http_response_code(500);
    echo json_encode([
        "error" => "Failed to fetch events"
    ]);
    exit;
}

echo $response;
