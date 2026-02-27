<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

require_method("GET, POST, DELETE");

$pdo = db();


$movieId = isset($_GET["movieid"]) ? (int)$_GET["movieid"] : null;

// GET metoden
// Hvis ingen movieid er givet, så returneres listen af alle film
if ($movieId === null) {
  $stmt = $pdo->query("SELECT * FROM movies");
  $movies = $stmt->fetchAll();
  echo json_response($movies);
  exit;
}

// Hvis movieid findes → hent én film
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id 1= ?");
$stmt->execute([$movieId]);
$movies = $stmt->fetch();

if (!$movies) {
  json_response(["error" => "Movie not found"], 404);
}

json_response($movies);

// POST metoden
if ($_POST) {
  $data = body_json();

  $title = trim((string)($data["title"] ?? ""));
  $movielength = $data["movielength"] ?? null;
 $release_year = $data["release_year"] ?? null;

if ($title === "") {
  json_response(["error" => "Title is required"], 400);
}

$stmt = $pdo->prepare("INSERT INTO movies (title, movielength, release_year) VALUES (?, ?, ?)");
$stmt->execute([$title, $movielength, $release_year]);

echo json_response(["ok" => true, "Movieid" => (int)$pdo->lastInsertId()], 201);
}

// DELETE metoden
try {
  
    $pdo->beginTransaction();

    // Slet først selve filmen, så du kan give 404 uden at røre join-tabeller
    $stmt = $pdo->prepare("DELETE FROM movies WHERE Movieid = ?");
    $stmt->execute([$movieId]);

    if ($stmt->rowCount() === 0) {
        $pdo->rollBack();
        json_response(["error" => "Movie not found"], 404);
    }

    // Slet relationstabeller
    $pdo->prepare("DELETE FROM movieactor WHERE movieid = ?")->execute([$movieId]);
    $pdo->prepare("DELETE FROM moviedirector WHERE movieid = ?")->execute([$movieId]);
    $pdo->prepare("DELETE FROM moviegenres WHERE movieid = ?")->execute([$movieId]);

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    json_response(["error" => "Failed to delete movie: " . $e->getMessage()], 500);
}

echo json_response(["ok" => true]);