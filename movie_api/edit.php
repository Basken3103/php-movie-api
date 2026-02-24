<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

$method = $_SERVER['REQUEST_METHOD'];
if (!in_array($method, ["PUT", "PATCH"], true)) {
    json_response(["error" => "Method not allowed. Use PUT or PATCH."], 405);
}

$movieId = isset($_GET["movieid"]) ? (int)$_GET["movieid"] : null;
if ($movieId <= 0) json_response(["error" => "movieid is required in query string"], 400);

$data = body_json();
$pdo = db();

$fields = [];
$params = [];

if (array_key_exists("title", $data)) {
    $fields[] = "title = ?";
    $params[] = trim((string)$data["title"]);
}

if (array_key_exists("movielength", $data)) {
  $fields[] = "movielength = ?";
  $params[] = $data["movielength"];
}

if (array_key_exists("release_year", $data)) {
  $fields[] = "release_year = ?";
  $params[] = $data["release_year"];
}

if (!$fields) json_response(["error" => "No fields to update"], 400);

$params[] = $movieId;

$sql = "UPDATE movies SET " . implode(", ", $fields) . " WHERE MovieId = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if ($stmt->rowCount() === 0) {
    json_response(["error" => "Movie not found or no changes made"], 404);
}

json_response(["ok" => true]);