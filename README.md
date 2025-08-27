# Game of Life

### Definition

The universe of the Game of Life is an infinite two-dimensional orthogonal grid of square cells, each of
which is in one of two possible states, alive or dead. Every cell interacts with its eight neighbors, which
are the cells that are horizontally, vertically, or diagonally adjacent.

This is an implementation of the **Game of Life** written in PHP. It supports both **command-line** and **web** execution, using ASCII output for visualization. We use the ‘Glider’ pattern placed in the middle of the 25x25 cell universe for demonstration.


## Requirements

- PHP 7.4+ (works with PHP 8.x as well)
- No external libraries required


## Project Structure
        Project-Root/
        ├── src/
        │   └── GameOfLife.php # Core class implementation
        ├── bin/
        │   └── run.php # CLI runner
        ├── public/
        │   └── index.php # Web interface
        └── README.md

---

## Running from Command Line
- Run the simulation in the terminal:
    ```
    php bin/run.php
    ```

- Options
  You can pass arguments with --key=value:

        --width (default 25) → grid width
        --height (default 25) → grid height
        --generations (default 30) → number of generations to simulate
        --sleep (default 150) → delay (milliseconds) between frames

  - Example:
    ```
    php bin/run.php --width=25 --height=25 --generations=50 --sleep=200
    ```
---

## Running in Browser

- Open the project in a local server (use terminal):
    ```
    php -S localhost:8000 -t public
    ```

- Then visit:
        http://localhost:8000/index.php


- URL Parameters
        You can control the simulation by query parameters:

        width → grid width
        height → grid height
        generations → number of generations to display

  - Example:
    
        http://localhost:8000/index.php?width=25&height=25&generations=50
