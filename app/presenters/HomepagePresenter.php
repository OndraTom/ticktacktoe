<?php

namespace App\Presenters;

use TickTackToe;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	/**
	 * Creates the game component.
	 *
	 * @return \TickTackToe\TickTackToe
	 */
	protected function createComponentTickTackToe()
	{
		$control = new TickTackToe\TickTackToe;

		$control->initialize($this->getSession('gameSettings'));

		return $control;
	}
}