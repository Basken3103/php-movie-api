<?php
declare(strict_types=1);

require_once __DIR__ . "/db.php";
require_once __DIR__ . "/helpers.php";

require_method("DELETE");

$movieIdRaw = $_GET["movieid"] ?? null;
$movieId = is_numeric($movieIdRaw) ? (int)$movieIdRaw : null;

if ($movieId === null || $movieId <= 0) {
    json_response(["error" => "movieid is required in query string"], 400);
}

$pdo = db();

try {
    $pdo->beginTransaction();

    // Slet først selve filmen, så du kan give 404 uden at røre join-tabeller
    $stmt = $pdo->prepare("DELETE FROM movies WHERE MovieId = ?");
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

json_response(["ok" => true]);
