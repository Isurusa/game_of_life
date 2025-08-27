<?php

declare(strict_types=1);

require __DIR__ . '/../src/GameOfLife.php';

use App\GameOfLife;

function parseArgs(array $argv): array
{
    $opts = ['width' => 25, 'height' => 25, 'generations' => 30, 'sleep' => 150];

    foreach ($argv as $arg) {
        if (preg_match('/^--(\w+)=(.+)$/', $arg, $m)) {
            $k = $m[1];
            $v = $m[2];
            if (in_array($k, ['width', 'height', 'generations', 'sleep'])) {
                $opts[$k] = (int)$v;
            }
        }
    }
    return $opts;
}

$opts = parseArgs($argv);
$game = new GameOfLife($opts['width'], $opts['height']);
$game->seedGliderInMiddle();

for ($gen = 0; $gen <= $opts['generations']; $gen++) {
    echo "Generation: $gen\n" . $game->render() . "\n\n";
    // echo "Generation: $gen\n" . $game->render("🟩", "⬜") . "\n\n";
    if ($gen < $opts['generations']) {
        $game->step();
        if ($opts['sleep'] > 0) usleep($opts['sleep'] * 1000);
    }
}
