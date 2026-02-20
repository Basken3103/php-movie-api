<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

require_method("POST");

$pdo = db();
$data = body_json();

$title = trim((string)($data["title"] ?? ""));
$movielength = $data["movielength"] ?? null;
$release_year = $data["release_year"] ?? null;

if ($title === "") {
  json_response(["error" => "Title is required"], 400);
}

$stmt = $pdo->prepare("INSERT INTO movies (title, movielength, release_year) VALUES (?, ?, ?)");
$stmt->execute([$title, $movielength, $release_year]);

json_response(["ok" => true, "MovieId" => (int)$pdo->lastInsertId()], 201);