<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

require_method("GET, POST, DELETE");

$pdo = db();


$movieId = isset($_GET["movieid"]) ? (int)$_GET["movieid"] : null;

//TODO Lav GET metoden i en if statement

//TODO Lav POST metoden bagefter  

//TODO Lav DELETE metoden til allersidst


// GET metoden
// Hvis ingen movieid er givet, så returner listen af alle film
if ($_GET) 
   if ($movieId === null) {
    $stmt = $pdo->query("SELECT * FROM movies");
    $movies = $stmt->fetchAll();
    json_response($movies);
}

// Hvis movieid findes → hent én film
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$movieId]);
$movies = $stmt->fetch();

if (!$movies) {
  json_response(["error" => "Movie not found"], 404);
}

echo json_response($movies);

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

json_response(["ok" => true, "MovieId" => (int)$pdo->lastInsertId()], 201);
}

// DELETE metoden
if ($_SERVER["REQUEST_METHOD"] === "DELETE") { 
  http_response_code(405);
  echo "METHOD NOT ALLOWED";
  exit();
}
