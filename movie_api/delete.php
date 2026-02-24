<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

require_method("DELETE");

$movieId = isset($_GET["movieid"]) ? (int)$_GET["movieid"] : null;
if ($movieId <= 0) json_response(["error" => "movieid is required in query string"], 400);

$pdo = db();

$pdo ->beginTransaction();
try {
  $pdo->prepare("DELETE FROM movieactor WHERE movieid = ?")->execute([$movieId]);
  $pdo->prepare("DELETE FROM moviedirector WHERE movieid = ?")->execute([$movieId]);
  $pdo->prepare("DELETE FROM moviegenres WHERE movieid = ?")->execute([$movieId]);
  
    $stmt = $pdo->prepare("DELETE FROM movies WHERE MovieId = ?");
    $stmt->execute([$movieId]);

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    json_response(["error" => "Failed to delete movie: " . $e->getMessage()], 500);
}

if ($stmt->rowCount() === 0) {
    json_response(["error" => "Movie not found"], 404);
}

json_response(["ok" => true]);

