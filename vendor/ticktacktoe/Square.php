<?php

namespace TickTackToe;

/**
 * Square on the board.
 *
 * @author Ondřej Tom
 */
class Square
{
	const SHAPE_CIRCLE	= 'circle';
	const SHAPE_CROSS	= 'cross';


	/**
	 * X coordination.
	 *
	 * @var int
	 */
	private $x;


	/**
	 * Y coordination.
	 *
	 * @var int
	 */
	private $y;


	/**
	 * Shape on square.
	 *
	 * @var string
	 */
	private $shape;


	/**
	 * If square is crossed -> TRUE.
	 *
	 * @var bool
	 */
	private $isCrossed;


	/**
	 * @param int		$x
	 * @param int		$y
	 * @param string	$shape
	 * @param boool		$isCrossed
	 */
	public function __construct($x, $y, $shape = '', $isCrossed = false)
	{
		$this->x			= $x;
		$this->y			= $y;
		$this->shape		= $shape;
		$this->isCrossed	= $isCrossed;
	}


	/**
	 * Get x.
	 *
	 * @return int
	 */
	public function getX()
	{
		return $this->x;
	}


	/**
	 * Get y.
	 *
	 * @return int
	 */
	public function getY()
	{
		return $this->y;
	}


	/**
	 * Checks if is blank.
	 *
	 * @return bool
	 */
	public function isBlank()
	{
		return $this->shape != self::SHAPE_CIRCLE && $this->shape != self::SHAPE_CROSS;
	}


	/**
	 * Gets the shape of square.
	 *
	 * @return string
	 */
	public function getShape()
	{
		return $this->shape;
	}


	/**
	 * Sets the square's shape.
	 *
	 * @param string $shape
	 * @throws \Exception
	 */
	public function setShape($shape)
	{
		if ($shape != self::SHAPE_CIRCLE && $shape != self::SHAPE_CROSS)
		{
			throw new \Exception('Shape has to be "circle" or "cross".');
		}

		$this->shape = $shape;
	}


	/**
	 * Checks if is the square crossed.
	 *
	 * @return bool
	 */
	public function isCrossed()
	{
		return $this->isCrossed;
	}
}