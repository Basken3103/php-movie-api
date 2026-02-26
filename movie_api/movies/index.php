<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

require_method("GET");

$pdo = db();

$movieId = isset($_GET["movieid"]) ? (int)$_GET["movieid"] : null;

//TODO Lav GET metoden i en if statement

//TODO Lav POST metoden bagefter  

//TODO Lav DELETE metoden til allersidst

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

if ($_SERVER["REQUEST_METHOD"] === "DELETE") { 
  http_response_code(405);
  echo "METHOD NOT ALLOWED";
  exit();
 }
