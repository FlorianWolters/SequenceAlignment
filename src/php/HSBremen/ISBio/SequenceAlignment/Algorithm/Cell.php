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
 * @package    SequenceAlignment
 * @subpackage Algorithm
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

declare(encoding = 'UTF-8');

namespace HSBremen\ISBio\SequenceAlignment\Algorithm;

/**
 * TODO: Add short class comment.
 *
 * TODO: Add long class comment.
 *
 * @category   Biology
 * @package    SequenceAlignment
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
     * The previous {@link Cell} relative to this {@link Cell}.
     *
     * @var Cell
     */
    private $previousCell = null;

    /**
     * The score of this {@link Cell}.
     *
     * @var integer
     */
    private $score = 0;

    /**
     * The row of this {@link Cell}.
     *
     * @var integer
     */
    private $row;

    /**
     * The column of this {@link Cell}.
     *
     * @var integer
     */
    private $column;

    /**
     * Constructs a new {@link Cell} with a specified row and a specified
     * column.
     *
     * @param integer $row    The row of the {@link Cell}.
     * @param integer $column The column of the {@link Cell}.
     */
    public function __construct($row, $column)
    {
        $this->row = $row;
        $this->column = $column;
    }

    /**
     * Sets the score of this {@link Cell}.
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
     * Returns the score of this {@link Cell}.
     *
     * @return The score.
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param Cell $previousCell The {@link Cell}. to set.
     *
     * @return void
     */
    public function setPreviousCell(Cell $previousCell)
    {
        $this->previousCell = $previousCell;
    }

    /**
     * Returns the row of this {@link Cell}.
     *
     * @return integer The row.
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Returns the column of this {@link Cell}.
     *
     * @return integer The column.
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @return Cell The previous Cell.
     */
    public function getPreviousCell()
    {
        return $this->previousCell;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return 'Cell(' . $this->row . ', ' . $this->column . '): score='
            . $this->score . ', prevCell=' . $this->previousCell . ']';
    }

}
