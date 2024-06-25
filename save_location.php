<?php
session_start();

$data = file_get_contents('php://input');

$pos = json_decode($data, true);

if (isset($pos['lat']) && isset($pos['lng'])) {
    $_SESSION['location'] = $pos;

    echo json_encode(['status' => 'success', 'message' => 'Location saved']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
