<?php

namespace TickTackToe;

use Nette\Http\SessionSection;

/**
 * Physical representation of the playboard.
 *
 * @author Ondřej Tom
 */
class Board
{
	const BOARD_SIZE = 50;


	/**
	 * Playboard.
	 *
	 * @var Square[]
	 */
	private $board;


	/**
	 * @param \Nette\Http\SessionSection $settings
	 */
	public function __construct(SessionSection $settings)
	{
		if (false === isset($settings->board))
		{
			$this->reset();
		}
		else
		{
			$this->board = $settings->board;
		}
	}


	/**
	 * Resets the board.
	 */
	public function reset()
	{
		$this->board = $this->createCleanBoard();
	}


	/**
	 * Creates array of empty squares.
	 *
	 * @return \TickTackToe\Square[]
	 */
	private function createCleanBoard()
	{
		$board = [];

		for ($i = 0; $i < self::BOARD_SIZE; $i++)
		{
			for ($j = 0; $j < self::BOARD_SIZE; $j++)
			{
				$board[$i][$j] = new Square($i, $j);
			}
		}

		return $board;
	}


	/**
	 * Returns the board.
	 *
	 * @return Square[]
	 */
	public function getBoard()
	{
		return $this->board;
	}


	/**
	 * Checks if the concrete square is empty.
	 *
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	public function isSquareEmpty($x, $y)
	{
		return $this->board[$x][$y]->isBlank();
	}


	/**
	 * Checks if coordinatess are valid.
	 *
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	public function areValidCoordinates($x, $y)
	{
		return isset($this->board[$x][$y]);
	}


	/**
	 * Making the move (physical layer).
	 *
	 * @param int $x
	 * @param int $y
	 * @param string $shape
	 */
	public function makeMove($x, $y, $shape)
	{
		$this->board[$x][$y]->setShape($shape);
	}


	/**
	 * Gets square on given coordinates.
	 *
	 * @param	int		$x
	 * @param	int		$y
	 * @return	Square
	 * @throws	\Exception
	 */
	public function getSquare($x, $y)
	{
		if (false === $this->areValidCoordinates($x, $y))
		{
			throw new \Exception('Getting shape: invalid coordinates ' . $x . ', ' . $y);
		}

		return $this->board[$x][$y];
	}
}