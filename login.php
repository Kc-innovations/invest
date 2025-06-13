<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['email']) || empty($data['password'])) {
  echo json_encode(["success" => false, "message" => "Email and password required."]);
  exit;
}

// Search in users.txt
$users = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$found = false;

foreach ($users as $user) {
  list($name, $phone, $nationality, $email, $hash) = explode(" | ", $user);
  if (trim($email) === $data['email'] && password_verify($data['password'], $hash)) {
    $found = true;
    break;
  }
}

if ($found) {
  echo json_encode(["success" => true, "message" => "Login successful."]);
} else {
  echo json_encode(["success" => false, "message" => "Invalid credentials."]);
}