<?php
declare(strict_types=1);

require_once (__DIR__ . "/db.php");
require_once (__DIR__ . "/helpers.php");

require_method("GET");

// genres
$stmt = $pdo->prepare("
  SELECT g.genreid, g.genrename
  FROM moviegenres mg
  JOIN genres g ON g.genreid = mg.genreid
  WHERE mg.movieid = ?
  ORDER BY g.genrename
");
$stmt->execute([$movieid]);
$movie["genres"] = $stmt->fetchAll();

json_response($movie);