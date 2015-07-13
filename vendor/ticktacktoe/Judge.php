<?php

namespace TickTackToe;

/**
 * @author Ondřej Tom
 */
class Judge
{
	private $board;


	public function __construct(Board $board)
	{
		$this->board = $board;
	}
}