<?php

namespace TickTackToe;

use Nette\Http\SessionSection;

/**
 * Manager of the game.
 *
 * @author Ondřej Tom
 */
class Manager
{
	/**
	 * Session object with settings of the game.
	 *
	 * @var Nette\Http\SessionSection
	 */
	private $settings;


	/**
	 * Playboard.
	 *
	 * @var Board
	 */
	private $board;


	/**
	 * Judge defines rules of the game.
	 *
	 * @var Judge
	 */
	private $judge;


	/**
	 * @param \Nette\Http\SessionSection $settings
	 */
	public function __construct(SessionSection $settings)
	{
		$this->settings = $settings;
		$this->board	= new Board($settings);
		$this->judge	= new Judge($this->board);
	}


	/**
	 * Returns the board.
	 *
	 * @return Board
	 */
	public function getPlayBoard()
	{
		return $this->board->getBoard();
	}


	/**
	 * Saves board to the session.
	 */
	private function savePlayBoard()
	{
		$this->settings->board = $this->getPlayBoard();
	}


	/**
	 * Making the move (click on the square).
	 *
	 * @param int $x
	 * @param int $y
	 * @throws \Exception
	 */
	public function makeMove($x, $y)
	{
		// Check move validity.
		if (false === $this->judge->isMoveValid($x, $y))
		{
			throw new \Exception('Move is not valid!');
		}

		// Change the square setting.
		$this->board->makeMove($x, $y, 'circle');

		$this->savePlayBoard();
	}


	/**
	 * Resetting the game.
	 */
	public function newGame()
	{
		// Reset the board.
		$this->board->reset();

		$this->savePlayBoard();
	}
}