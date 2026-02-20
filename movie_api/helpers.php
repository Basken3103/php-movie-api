<?php
declare(strict_types=1);

function json_response($data, int $status = 200): void {
  http_response_code($status);
  header("Content-Type: application/json; charset=utf-8");
  header("Access-Control-Allow-Origin: *");
  echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  exit;
}

function require_method(string ...$methods): void {
  if (!in_array($_SERVER['REQUEST_METHOD'], $methods)) {
    http_response_code(405);
    header("Allow: " . implode(", ", $methods));
    exit;
  }
}

function body_json(): array {
  $input = file_get_contents("php://input");
  $data = json_decode($input, true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo "Invalid JSON";
    exit;
  }
  return $data;
}
