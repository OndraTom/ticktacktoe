<?php

namespace TickTackToe;

use Nette\Application\UI\Control,
	Nette\Http\SessionSection,
	Nette\Utils\Strings;

/**
 * The main component of application.
 *
 * @author Ondřej Tom
 */
class TickTackToe extends Control
{
	const BOARD_SNIPPET		= 'board';
	const MESSAGE_SNIPPET	= 'message';


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
	 * Get winner announcement.
	 *
	 * @param	string $winner
	 * @return	string
	 */
	private function getMessageForWinner($winner)
	{
		return Strings::capitalize($winner) . ' is the winner! Congratulations!';
	}


	/**
	 * Rendering component.
	 */
	public function render()
	{
		// Check game initialization.
		$this->checkInitialization();

		// Set the playboard.
		$this->template->board = $this->manager->getPlayBoard();

		// Set the winner.
		if ($this->manager->hasWinner())
		{
			$this->template->hasWinner	= true;
			$this->template->message	= $this->getMessageForWinner($this->manager->getWinner());
		}
		else
		{
			$this->template->hasWinner	= false;
		}

		// Set the template file.
		$this->template->setFile(__DIR__ . '/tickTackToe.latte');

		// Draw the content.
		$this->template->render();
	}


	/**
	 * Redraws snippet with the board.
	 */
	private function redrawBoard()
	{
		if ($this->getPresenter()->isAjax())
		{
			$this->redrawControl(self::BOARD_SNIPPET);
		}
	}


	/**
	 * Redraws snippet with the message.
	 */
	private function redrawMessage()
	{
		if ($this->getPresenter()->isAjax())
		{
			$this->redrawControl(self::MESSAGE_SNIPPET);
		}
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

		if ($this->manager->hasWinner())
		{
			$this->template->message = $this->getMessageForWinner($this->manager->getWinner());

			$this->redrawMessage();
		}
	}


	/**
	 * Handeling new game subrequest.
	 */
	public function handleNewGame()
	{
		$this->manager->newGame();

		$this->redrawBoard();
		$this->redrawMessage();
	}
}