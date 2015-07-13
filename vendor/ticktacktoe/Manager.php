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


	public function __construct(SessionSection $settings)
	{
		$this->settings = $settings;
		$this->board	= new Board($settings);
		$this->judge	= new Judge($this->board);
	}


	public function getPlayBoard()
	{
		return $this->board->getBoard();
	}
}