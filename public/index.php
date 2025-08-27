<?php

declare(strict_types=1);

require __DIR__ . '/../src/GameOfLife.php';

use App\GameOfLife;

$w = $_GET['width'] ?? 25;
$h = $_GET['height'] ?? 25;
$gen = $_GET['generations'] ?? 30;

$game = new GameOfLife((int)$w, (int)$h);
$game->seedGliderInMiddle();
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Game of Life</title>
</head>

<body>
    <h1>Game of Life</h1>
    <?php for ($i = 0; $i <= $gen; $i++): ?>
        <div><b>Generation: <?= $i ?></b>
            <pre><?= htmlspecialchars($game->render()) ?></pre>
            <!-- <pre><?//= htmlspecialchars($game->render("🟩", "⬜")) ?></pre> -->
        </div>
    <?php $game->step();
    endfor; ?>
</body>

</html>