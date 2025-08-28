<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\GameOfLife;

require __DIR__ . '/../src/GameOfLife.php';

final class GameOfLifeTest extends TestCase
{
    public function testBlockStillLife(): void
    {
        $game = new GameOfLife(25, 25);
        // Block at top-left
        $game->set(1,1,1);
        $game->set(2,1,1);
        $game->set(1,2,1);
        $game->set(2,2,1);

        $before = $game->grid();
        $game->step();
        $this->assertEquals($before, $game->grid(), "Block should remain unchanged");
    }

    public function testBlinkerOscillator(): void
    {
        $game = new GameOfLife(25, 25);
        // Vertical line
        $game->set(2,1,1);
        $game->set(2,2,1);
        $game->set(2,3,1);

        $game->step();
        $after = $game->grid();

        // Expect horizontal line after one step
        $expected = (new GameOfLife(25,25))->grid();
        $expected[2][1] = 1;
        $expected[2][2] = 1;
        $expected[2][3] = 1;

        $this->assertEquals($expected, $after, "Blinker should flip orientation");
    }

    public function testGliderMoves(): void
    {
        $game = new GameOfLife(25, 25);
        $game->seedGliderInMiddle();
        $initial = $game->render();

        // Step 4 generations (glider should have shifted)
        for ($i=0;$i<4;$i++) $game->step();
        $later = $game->render();

        $this->assertNotEquals($initial, $later, "Glider should move across the grid");
    }
}
