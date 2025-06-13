<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['name']) || empty($data['email']) || empty($data['password'])) {
  echo json_encode(["success" => false, "message" => "Missing required fields."]);
  exit;
}

if ($data['password'] !== $data['confirmPassword']) {
  echo json_encode(["success" => false, "message" => "Passwords do not match."]);
  exit;
}

// Save to file (simulate DB)
$line = implode(" | ", [
  $data['name'],
  $data['phone'],
  $data['nationality'],
  $data['email'],
  password_hash($data['password'], PASSWORD_DEFAULT)
]);

file_put_contents("users.txt", $line . "\n", FILE_APPEND);

echo json_encode(["success" => true, "message" => "Signup successful!"]);