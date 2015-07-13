<?php

namespace TickTackToe;

use Nette\Http\SessionSection;

/**
 * @author Ondřej Tom
 */
class Board
{
	const BOARD_SIZE = 50;


	/**
	 * Playboard.
	 *
	 * @var array
	 */
	private $board;


	public function __construct(SessionSection $settings)
	{
		if (false === isset($settings->board))
		{
			$this->board = $this->createCleanBoard();
		}
		else
		{
			$this->board = $this->createBoard($settings->board);
		}
	}


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


	private function createBoard(array $board)
	{

	}


	public function getBoard()
	{
		return $this->board;
	}
}