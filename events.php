<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// ---- DATABASE CONNECTION ----
$conn = new mysqli(
    "sql303.infinityfree.com",
    "if0_39530845",
    "hjg12345678",
    "if0_39530845_qr_tokens"
);

$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "Database connection failed"
    ]);
    exit;
}

// ---- FETCH ALL UPCOMING EVENTS ----
$sql = "
    SELECT id, title, venue, image, event_date
    FROM events
    WHERE status = 'published'
      AND (event_date IS NULL OR event_date >= CURDATE())
    ORDER BY event_date ASC
";

$result = $conn->query($sql);

$allEvents = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $allEvents[] = [
            "id" => (int)$row["id"],
            "title" => $row["title"],
            "venue" => $row["venue"],
            "image" => $row["image"],
            "eventDate" => $row["event_date"]
        ];
    }
}

// ---- SPOTLIGHT = FIRST 5 ONLY ----
$spotlight = array_slice($allEvents, 0, 5);

// ---- UPCOMING = ALL EVENTS ----
$upcoming = $allEvents;

// ---- RESPONSE ----
http_response_code(200);
echo json_encode([
    "spotlight" => $spotlight,
    "upcoming"  => $upcoming
]);
exit;
