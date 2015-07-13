<?php

namespace TickTackToe;

use Nette\Application\UI\Control,
	Nette\Http\SessionSection;

/**
 * The main component of application.
 *
 * @author Ondřej Tom
 */
class TickTackToe extends Control
{
	const BOARD_SNIPPET = 'board';


	/**
	 * Manager of the game.
	 *
	 * @var Manager
	 */
	private $manager;


	/**
	 * Flag of the game initialization.
	 *
	 * The game has to be initialized before render.
	 *
	 * @var bool
	 */
	private $initialized = false;


	/**
	 * Sets the game data (from session).
	 *
	 * @param \Nette\Http\SessionSection $settings
	 */
	public function initialize(SessionSection $settings)
	{
		$this->manager = new Manager($settings);

		$this->initialized = true;
	}


	/**
	 * Checks the game initialization.
	 *
	 * Throws exception if settings hasn't been provided.
	 *
	 * @throws Exception
	 */
	private function checkInitialization()
	{
		if (false === $this->initialized)
		{
			throw new Exception('Game is not initialized.');
		}
	}


	/**
	 * Rendering component.
	 */
	public function render()
	{
		// Check game initialization.
		$this->checkInitialization();

		// Get the template.
		$template = $this->template;

		$template->board = $this->manager->getPlayBoard();

		// Set the template file.
		$template->setFile(__DIR__ . '/tickTackToe.latte');

		// Draw the content.
		$template->render();
	}


	/**
	 * Redraws snippet with the board.
	 */
	private function redrawBoard()
	{
		$this->redrawControl(self::BOARD_SNIPPET);
	}


	/**
	 * Handeling make move subrequest.
	 *
	 * @param int $x
	 * @param int $y
	 */
	public function handleMakeMove($x, $y)
	{
		$this->manager->makeMove($x, $y);

		$this->redrawBoard();
	}


	/**
	 * Handeling new game subrequest.
	 */
	public function handleNewGame()
	{
		$this->manager->newGame();

		$this->redrawBoard();
	}
}