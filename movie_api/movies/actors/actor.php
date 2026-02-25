<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

require_method("GET");

$pdo = db();

$movieId = isset($_GET["movieid"]) ? (int)$_GET["movieid"] : null;

if (!$movieId) {
    //List  
    $stmt = $pdo->query("SELECT * FROM movies");
    $movies = $stmt->fetchAll();

    json_response($movies);
}

// SINGLE (med relations)
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$movieid]);
$movie = $stmt->fetch();

if (!$movie) {
  json_response(["error" => "Movie not found"], 404);
}

// actors
$stmt = $pdo->prepare("
  SELECT p.actor_id, p.firstname, p.lastname, p.birth, p.nationality
  FROM movieactor ma
  JOIN people p ON p.actor_id = ma.actor_id
  WHERE ma.movieid = ?
  ORDER BY p.lastname, p.firstname
");
$stmt->execute([$movieId]);
$movie["actors"] = $stmt->fetchAll();