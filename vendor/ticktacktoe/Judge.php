<?php

namespace TickTackToe;

/**
 * Representation of game rules.
 *
 * @author Ondřej Tom
 */
class Judge
{
	/**
	 * Playboard.
	 *
	 * @var Board
	 */
	private $board;


	/**
	 * @param \TickTackToe\Board $board
	 */
	public function __construct(Board $board)
	{
		$this->board = $board;
	}


	/**
	 * Checks if the move is valid.
	 *
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	public function isMoveValid($x, $y)
	{
		return $this->board->areValidCoordinates($x, $y)
			&& $this->board->isSquareEmpty($x, $y);
	}
}