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
	 * @param \Nette\Http\SessionSection $settings
	 */
	public function __construct(SessionSection $settings)
	{
		$this->settings = $settings;
		$this->board	= new Board($settings);
		$this->judge	= new Judge($this->board);

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
		if (false === $this->judge->isValidShape($shape))
		{
			throw new \Exception('Given shape "' . $shape . '" is not valid.');
		}

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

		// Change the board.
		$this->board->makeMove($x, $y, $this->currentShape);
		$this->savePlayBoard();

		// Switch the shape (active player).
		$this->switchShape();
		$this->saveCurrentShape();
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