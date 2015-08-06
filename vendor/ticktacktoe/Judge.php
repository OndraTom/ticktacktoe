<?php

namespace TickTackToe;

/**
 * Representation of game rules.
 *
 * @author Ondřej Tom
 */
class Judge
{
	const DEFAULT_WINNING_COUNT = 5;


	/**
	 * Playboard.
	 *
	 * @var Board
	 */
	private $board;


	/**
	 * Count of square in row that player needs to achieve for winning.
	 *
	 * @var int
	 */
	private $winningCount;


	/**
	 * @param Board	$board
	 * @param int	$winningCount
	 */
	public function __construct(Board $board, $winningCount = self::DEFAULT_WINNING_COUNT)
	{
		$this->board		= $board;
		$this->winningCount = $winningCount;
	}


	/**
	 * Checks if the move is valid.
	 *
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	public function isMoveValid($x, $y)
	{
		return $this->board->areValidCoordinates($x, $y)
			&& $this->board->isSquareEmpty($x, $y);
	}


	/**
	 * Check if the move is valid.
	 *
	 * Throws exception if not.
	 *
	 * @param int $x
	 * @param int $y
	 * @throws \Exception
	 */
	public function checkMoveValidity($x, $y)
	{
		if (false === $this->isMoveValid($x, $y))
		{
			throw new \Exception('Move is not valid!');
		}
	}


	/**
	 * Checks if the given shape is valid shape.
	 *
	 * @param string $shape
	 * @return bool
	 */
	public function isValidShape($shape)
	{
		return $shape == Square::SHAPE_CIRCLE || $shape == Square::SHAPE_CROSS;
	}


	/**
	 * Checks if the given shape is valid shape.
	 *
	 * Throws exception if not valid.
	 *
	 * @param string $shape
	 * @throws \Exception
	 */
	public function checkShapeValidity($shape)
	{
		if (false === $this->isValidShape($shape))
		{
			throw new \Exception('Given shape "' . $shape . '" is not valid.');
		}
	}


	/**
	 * Checks shape square.
	 *
	 * @param	string	$shape
	 * @param	int		$x
	 * @param	int		$y
	 * @return	bool
	 * @throws	\Exception
	 */
	private function isShapeSquare($shape, $x, $y)
	{
		return $this->board->getSquare($x, $y)->getShape() == $shape;
	}


	/**
	 * Checks if given count is winning count.
	 *
	 * @param int $count
	 * @return bool
	 */
	private function isWinningCount($count)
	{
		return $count == self::DEFAULT_WINNING_COUNT;
	}


	/**
	 * Iterates row in one way and checks count of shapes in it.
	 *
	 * Returns true if the winning count is satisfied.
	 *
	 * @param	string	$shape
	 * @param	array	$coords
	 * @param	array	$additions
	 * @param	int		$inRowCount
	 * @return	boolean
	 */
	private function isWinningRow($shape, array $coords, array $additions, &$inRowCount)
	{
		while ($this->board->areValidCoordinates($coords[0], $coords[1])
				&& $this->isShapeSquare($shape, $coords[0], $coords[1]))
		{
			if ($this->isWinningCount(++$inRowCount))
			{
				return true;
			}

			// Iterating step.
			$coords = array_map(function($a, $b) {

				return $a + $b;

			}, $coords, $additions);
		}

		return false;
	}


	/**
	 * Checks orthogonal direction.
	 *
	 * @param	string	$shape
	 * @param	int		$x
	 * @param	int		$y
	 * @return	boolean
	 */
	private function hasOrthogonalSuccess($shape, $x, $y)
	{
		// Left Right.
		$inRowCount = 1;

		if ($this->isWinningRow($shape, [$x - 1, $y], [-1, 0], $inRowCount)
				|| $this->isWinningRow($shape, [$x + 1, $y], [1, 0], $inRowCount))
		{
			return true;
		}


		// Up down.
		$inRowCount = 1;

		if ($this->isWinningRow($shape, [$x, $y - 1], [0, -1], $inRowCount)
				|| $this->isWinningRow($shape, [$x, $y + 1], [0, 1], $inRowCount))
		{
			return true;
		}


		return false;
	}


	/**
	 * Checks diagonal direction.
	 *
	 * @param	string	$shape
	 * @param	int		$x
	 * @param	int		$y
	 * @return	boolean
	 */
	private function hasDiagonalSuccess($shape, $x, $y)
	{
		// Left right.
		$inRowCount = 1;

		if ($this->isWinningRow($shape, [$x - 1, $y + 1], [-1, 1], $inRowCount)
				|| $this->isWinningRow($shape, [$x + 1, $y - 1], [1, -1], $inRowCount))
		{
			return true;
		}


		// Right left.
		$inRowCount = 1;

		if ($this->isWinningRow($shape, [$x + 1, $y + 1], [1, 1], $inRowCount)
				|| $this->isWinningRow($shape, [$x - 1, $y - 1], [-1, -1], $inRowCount))
		{
			return true;
		}


		return false;
	}


	/**
	 * Checks if the last move is winning move.
	 *
	 * @param	string	$shape
	 * @param	int		$x
	 * @param	int		$y
	 * @return	boolean
	 * @throws	\Exception
	 */
	public function isWinner($shape, $x, $y)
	{
		// Check shape validity first.
		$this->checkShapeValidity($shape);

		// Check success.
		return $this->hasDiagonalSuccess($shape, $x, $y)
				|| $this->hasOrthogonalSuccess($shape, $x, $y);
	}
}