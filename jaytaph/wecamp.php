<?php

$input = 'My brain is a beautiful thing, and I intend to use it at WeCamp!';

$wecamp = new WeCamp($input, 35);
$wecamp->camp(250);
exit();


class WeCamp
{
    /** @var array */
    protected $words;
    /** @var int */
    protected $boardSize;
    /** @var array */
    protected $board;
    /** @var array */
    protected $offsets = array();

    const LEFTRIGHT = 0;
    const TOPBOTTOM = 1;
    const MAXDIRECTIONS = 2;

    /**
     * Create a happy campers camping field
     *
     * @param string $input
     * @param int $boardSize
     */
    public function __construct($input, $boardSize = 35)
    {
        $this->words = preg_split('/\s+/', $input);
        array_walk($this->words, function (&$e) {
            $e = preg_replace("/[^a-z]/", "", strtolower($e));
        });

        $this->boardSize = $boardSize;
        $this->board = str_repeat('.', $this->boardSize * $this->boardSize);
    }

    /**
     * camp all the things!
     *
     * @param int $iterations how many campers
     */
    public function camp($iterations = 250)
    {
        $it = new LimitIterator(new InfiniteIterator(new ArrayIterator($this->words)), 0, $iterations);
        foreach ($it as $word) {
            $this->scrabble($word);
        }
        $this->printBoard();
    }

    /**
     * Finds a spot for the given word on the board, and lays the word there. Might be possible due to randomness
     * that no spot can be found for the given word. It will try a few attempts and fails silently.
     *
     * @param string $word
     */
    protected function scrabble($word)
    {
        // Shuffle offset, so we start checking different letters each time
        shuffle($this->offsets);

        foreach ($this->offsets as $offset) {
            $ch = $this->board[$offset];

            /* Instead of simple strpos, we actually fetch ALL occurrences and select a
               random element. This creates a nicer board I guess */
            $idxs = array();
            $off = -1;
            while (true) {
                $off = strpos($word, $ch, $off + 1);
                if ($off === false) {
                    break;
                }
                $idxs[] = $off;
            }
            if (count($idxs) == 0) {
                continue;
            }
            shuffle($idxs);
            $idx = array_pop($idxs);


            $y = floor($offset / $this->boardSize);
            $x = ($offset % $this->boardSize);


            // Try and place the word left-right
            if ($this->isPlacementPossible($word, $x - $idx, $y, self::LEFTRIGHT)) {
                $this->placeWord($word, $x - $idx, $y, self::LEFTRIGHT);
                return;

            // Try and place the word vertical
            } elseif ($this->isPlacementPossible($word, $x, $y - $idx, self::TOPBOTTOM)) {
                $this->placeWord($word, $x, $y - $idx, self::TOPBOTTOM);
                return;
            }
        }

        // Can't place the word into the current setup, or it's the first word. Just place it randomly on the board.
        $attempts = 0;
        do {
            $x = rand(0, $this->boardSize);
            $y = rand(0, $this->boardSize);
            $d = rand(0, self::MAXDIRECTIONS - 1);

            $attempts++;
            if ($attempts > 10) {
                return;
            }
        } while (! $this->isPlacementPossible($word, $x, $y, $d));

        $this->placeWord($word, $x, $y, $d);
    }

    /**
     * Places a word onto the board. Does not do boundaries check!
     *
     * @param string $word
     * @param int $x
     * @param int $y
     * @param int $direction
     */
    protected function placeWord($word, $x, $y, $direction)
    {
        for ($i=0; $i!=strlen($word); $i++) {
            $offset = (int)(($y * $this->boardSize) + $x);

            $this->board[$offset] = $word[$i];
            $this->offsets[] = $offset;

            if ($direction == self::LEFTRIGHT) {
                $x++;
            } elseif ($direction == self::TOPBOTTOM) {
                $y++;
            }
        }
    }

    /**
     * Checks if placement of the word on given position and direction is possible.
     *
     * @param string $word
     * @param int $x
     * @param int $y
     * @param int $direction
     * @return bool
     */
    protected function isPlacementPossible($word, $x, $y, $direction)
    {
        // Check boundaries: make sure the word completely falls onto the board
        if ($x < 0 || $y < 0) {
            return false;
        }
        if ($direction == self::LEFTRIGHT && $x + strlen($word) >= $this->boardSize) {
            return false;
        }
        if ($direction == self::TOPBOTTOM && $y + strlen($word) >= $this->boardSize) {
            return false;
        }

        // When false, at least we have one cell that has a new letter
        $completeOverlapDetected = true;

        // Check to see if the beginning of the word has some free space so it doesn't touch another word here
        $ok = false;
        if ($direction == self::LEFTRIGHT) {
            $ok = $this->checkSurroundings($x, $y, array(0, 0, 0, 1, 0, 0, 0, 0));
        } elseif ($direction == self::TOPBOTTOM) {
            $ok = $this->checkSurroundings($x, $y, array(0, 1, 0, 0, 0, 0, 0, 0));
        }
        if (! $ok) {
            return false;
        }

        // Iterate each letter of the given word
        for ($i = 0; $i != strlen($word); $i++) {
            $offset = (int)(($y * $this->boardSize) + $x);
            if ($offset >= $this->boardSize * $this->boardSize) {
                return false;
            }

            if ($this->board[$offset] == $word[$i]) {
                // This letter is already here. That's ok, we don't need to do anything
            } elseif ($this->board[$offset] == '.') {
                $completeOverlapDetected = false;

                // We add a new letter, but we must make sure it fits in its surrounding
                $cells = array();
                if ($direction == self::LEFTRIGHT) {
                    $cells = array(0, 1, 0, 0, 0, 0, 1, 0);
                } elseif ($direction == self::TOPBOTTOM) {
                    $cells = array(0, 0, 0, 1, 1, 0, 0, 0);
                }

                if (! $this->checkSurroundings($x, $y, $cells)) {
                    return false;
                }

                // We can store this letter at this position without issues
            } else {
                // Seems another letter is already here.. so we cannot place the word
                return false;
            }

            // Goto the left on dir 0
            if ($direction == self::LEFTRIGHT) {
                $x++;
            }
            // go downwards on dir 1
            if ($direction == self::TOPBOTTOM) {
                $y++;
            }
        }

        // Complete overlap. Theoretically we can "place" the word, but it would not be visible
        if ($completeOverlapDetected) {
            return false;
        }

        // Check to see if the end of the word has some free space so it doesn't touch another word here
        $cells = array();
        if ($direction == self::LEFTRIGHT) {
            $cells = array(0, 1, 0, 0, 1, 0, 1, 0);
            $x--;
        } elseif ($direction == self::TOPBOTTOM) {
            $cells = array(0, 0, 0, 1, 1, 0, 1, 0);
            $y--;
        }
        if (! $this->checkSurroundings($x, $y, $cells)) {
            return false;
        }

        return true;
    }

    /**
     * Checks cells (when set to 1) to see if the surrounding cells are occupied.
     *
     * $cells is a list of 8 ints/booleans. Starting from the top-left corner:
     *
     *  1 2 3
     *  4 x 5
     *  6 7 8
     *
     * @param int $x
     * @param int $y
     * @param array $cells
     * @return bool True when all cells are free. False otherwise.
     */
    protected function checkSurroundings($x, $y, array $cells)
    {
        $offset = (int)(($y * $this->boardSize) + $x);

        $tmp = array(
            0 => $offset - $this->boardSize - 1,
            1 => $offset - $this->boardSize,
            2 => $offset - $this->boardSize + 1,
            3 => $offset - 1,
            4 => $offset + 1,
            5 => $offset + $this->boardSize - 1,
            6 => $offset + $this->boardSize,
            7 => $offset + $this->boardSize + 1,
        );

        while (count($cells) < 8) {
            $cells[] = 0;
        }

        foreach ($cells as $idx => $test) {
            if (! $test) {
                continue;
            }

            $off = $tmp[$idx];
            if (! isset($this->board[$off])) {
                continue;
            }

            $ch = $this->board[$off];
            if ($ch != '.') {
                return false;
            }
        }

        return true;
    }

    /**
     * Prints the board
     */
    protected function printBoard()
    {
        // ANSI clear screen
        print "\033[2J";
        for ($y = 0; $y != $this->boardSize ; $y++) {
            for ($x = 0; $x != $this->boardSize; $x++) {
                $ch = $this->board[$y * $this->boardSize + $x];

                // Add some ANSI coloring to it
                $c = $ch != '.' ? '33;1' : '37';
                print "\033[".$c."m".$ch."\033[0m ";
            }
            print "\n";
        }
    }
}
