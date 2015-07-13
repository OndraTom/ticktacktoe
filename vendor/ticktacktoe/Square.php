<?php

namespace TickTackToe;

/**
 * @author Ondřej Tom
 */
class Square
{
	const SHAPE_CIRCLE	= 'circle';
	const SHAPE_CROSS	= 'cross';


	private $x;


	private $y;


	private $shape;


	private $isCrossed;


	public function __construct($x, $y, $shape = '', $isCrossed = false)
	{
		$this->x			= $x;
		$this->y			= $y;
		$this->shape		= $shape;
		$this->isCrossed	= $isCrossed;
	}


	public function getX()
	{
		return $this->x;
	}


	public function getY()
	{
		return $this->y;
	}


	public function isBlank()
	{
		return $this->shape != self::SHAPE_CIRCLE && $this->shape != self::SHAPE_CROSS;
	}


	public function getShape()
	{
		return $this->shape;
	}


	public function isCrossed()
	{
		return $this->isCrossed;
	}
}