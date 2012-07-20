<?php
/**
 * `Cell.php`
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see http://gnu.org/licenses/lgpl.txt.
 *
 * PHP version 5.4
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage Algorithm
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Alignment;

/**
 * This class models a cell in a score matrix, to hold row, column, score and
 * the previous cell.
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage Algorithm
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
class Cell
{

    /**
     * The previous cell of this Cell.
     *
     * @var Cell
     */
    private $previousCell;

    /**
     * The row of this Cell.
     *
     * @var integer
     */
    private $row;

    /**
     * The column of this Cell.
     *
     * @var integer
     */
    private $column;

    /**
     * The score of this Cell.
     *
     * @var integer
     */
    private $score;

    /**
     * Constructs a new Cell with a specified row, a specified column and a
     * specified score.
     *
     * @param integer $row    The row of the Cell.
     * @param integer $column The column of the Cell.
     * @param integer $score  The score of the Cell.
     */
    public function __construct($row, $column, $score = 0)
    {
        $this->row = $row;
        $this->column = $column;
        $this->setScore($score);
        $this->setPreviousCell();
    }

    /**
     * Sets the score of this Cell.
     *
     * @param integer $score The score to set.
     *
     * @return void
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * Sets the previous Cell of this Cell.
     *
     * @param Cell|null $previousCell The previous Cell to set.
     *
     * @return void
     */
    public function setPreviousCell(Cell $previousCell = null)
    {
        $this->previousCell = $previousCell;
    }

    /**
     * Returns the score of this Cell as a string.
     *
     * @return string The score of this cell as a string.
     */
    public function __toString()
    {
        return (string) $this->score;
    }

    /**
     * Returns the previous Cell of this Cell.
     *
     * @return Cell The previous Cell.
     */
    public function getPreviousCell()
    {
       return $this->previousCell;
    }

    /**
     * Returns the column of this Cell.
     *
     * @return integer The column.
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Returns the row of this Cell.
     *
     * @return integer The row.
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Returns the score of this Cell.
     *
     * @return The score.
     */
    public function getScore()
    {
        return $this->score;
    }

}
