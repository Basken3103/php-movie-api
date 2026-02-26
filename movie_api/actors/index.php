<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

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