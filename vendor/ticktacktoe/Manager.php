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
	 * Current shape (active player).
	 *
	 * @var string
	 */
	private $currentShape = Square::SHAPE_CIRCLE;


	/**
	 * Winner shape.
	 *
	 * @var string
	 */
	private $winner;


	/**
	 * @param \Nette\Http\SessionSection $settings
	 */
	public function __construct(SessionSection $settings)
	{
		$this->settings = $settings;
		$this->board	= new Board($settings);
		$this->judge	= new Judge($this->board);

		if (isset($settings->winner) && $this->judge->isValidShape($settings->winner))
		{
			$this->winner = $settings->winner;
		}

		if (isset($settings->currentShape))
		{
			$this->setCurrentShape($settings->currentShape);
		}
	}


	/**
	 * Sets the current shape (active player).
	 *
	 * @param string $shape
	 * @throws \Exception
	 */
	private function setCurrentShape($shape)
	{
		$this->judge->checkShapeValidity($shape);

		$this->currentShape = $shape;
	}


	/**
	 * Switching of the current shape (active player).
	 */
	private function switchShape()
	{
		if ($this->currentShape == Square::SHAPE_CIRCLE)
		{
			$this->currentShape = Square::SHAPE_CROSS;
		}
		else
		{
			$this->currentShape = Square::SHAPE_CIRCLE;
		}
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
	 * Saves current shape to the session.
	 */
	private function saveCurrentShape()
	{
		$this->settings->currentShape = $this->currentShape;
	}


	/**
	 * Sets the winner shape.
	 *
	 * @param string $shape
	 */
	private function setWinner($shape)
	{
		$this->settings->winner = $shape;

		$this->winner = $shape;
	}


	/**
	 * Returns the winner shape.
	 *
	 * @return string
	 */
	public function getWinner()
	{
		return $this->winner;
	}


	/**
	 * Checks if game has the winner.
	 *
	 * @return boolean
	 */
	public function hasWinner()
	{
		return isset($this->winner);
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
		$this->judge->checkMoveValidity($x, $y);

		// Change the board.
		$this->board->makeMove($x, $y, $this->currentShape);
		$this->savePlayBoard();

		// Check and set the winner.
		if ($this->judge->isWinner($this->currentShape, $x, $y))
		{
			$this->setWinner($this->currentShape);
		}

		// Switch the shape (active player).
		else
		{
			$this->switchShape();
			$this->saveCurrentShape();
		}
	}


	/**
	 * Resetting the game.
	 */
	public function newGame()
	{
		// Reset the board.
		$this->board->reset();
		$this->savePlayBoard();

		// Unset the winner.
		unset($this->winner);
		unset($this->settings->winner);
	}
}