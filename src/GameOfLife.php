<?php

declare(strict_types=1);

namespace App;

final class GameOfLife
{
    private int $width;
    private int $height;
    private array $grid;


    /**
     * Constructor - initializes the Game of Life universe.
     *
     * @param int $width  Number of columns
     * @param int $height Number of rows
     * @param int[][]|null $initial Optional initial state
     */
    public function __construct(int $width = 25, int $height = 25, ?array $initial = null)
    {
        $this->width = $width;
        $this->height = $height;
        $this->grid = $initial ?? $this->deadGrid();
    }


    /**
     * Get the current grid state.
     *
     * @return int[][] 2D array representing the universe
     */
    public function grid(): array
    {
        return $this->grid;
    }


    /**
     * Set the state of a specific cell.
     *
     * @param int $x Column index
     * @param int $y Row index
     * @param int $state 1 = live, 0 = dead
     */
    public function set(int $x, int $y, int $state): void
    {
        if ($x < 0 || $x >= $this->width || $y < 0 || $y >= $this->height) return;
        $this->grid[$y][$x] = $state ? 1 : 0;
    }


    /**
     * Advance the universe by one generation using the rules for the game of life.
     */
    public function step(): void
    {
        $next = $this->deadGrid();
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $live = $this->grid[$y][$x] === 1;
                $n = $this->liveNeighborCount($x, $y);

                if ($live && ($n < 2 || $n > 3)) $next[$y][$x] = 0;
                elseif ($live && ($n === 2 || $n === 3)) $next[$y][$x] = 1;
                elseif (!$live && $n === 3) $next[$y][$x] = 1;
            }
        }
        $this->grid = $next;
    }


    /**
     * Seed the grid with "Glider" pattern placed in the middle.
     */
    public function seedGliderInMiddle(): void
    {
        $this->grid = $this->deadGrid();
        $cx = intdiv($this->width, 2);
        $cy = intdiv($this->height, 2);
        $coords = [[1, 0], [2, 1], [0, 2], [1, 2], [2, 2]];
        foreach ($coords as [$dx, $dy]) $this->set($cx + $dx - 1, $cy + $dy - 1, 1);
    }


    /**
     * Render the grid as ASCII characters. Default: "█" for live cells and "·" for dead cells.
     */
    public function render(string $live = "█", string $dead = "·"): string
    {
        $lines = [];
        for ($y = 0; $y < $this->height; $y++) {
            $row = "";
            for ($x = 0; $x < $this->width; $x++) $row .= $this->grid[$y][$x] ? $live : $dead;
            $lines[] = $row;
        }
        return implode(PHP_EOL, $lines);
    }


    /**
     * Count the number of live neighbors for a given cell.
     */
    private function liveNeighborCount(int $x, int $y): int
    {
        $c = 0;
        for ($dy = -1; $dy <= 1; $dy++) {
            for ($dx = -1; $dx <= 1; $dx++) {
                if ($dx === 0 && $dy === 0) continue;
                $nx = $x + $dx;
                $ny = $y + $dy;
                if ($nx >= 0 && $nx < $this->width && $ny >= 0 && $ny < $this->height)
                    $c += $this->grid[$ny][$nx];
            }
        }
        return $c;
    }
    

      /**
     * Create a new empty grid filled with dead cells.
     *
     * @return int[][] 2D array of all 0s
     */
    private function deadGrid(): array
    {
        return array_fill(0, $this->height, array_fill(0, $this->width, 0));
    }
}
