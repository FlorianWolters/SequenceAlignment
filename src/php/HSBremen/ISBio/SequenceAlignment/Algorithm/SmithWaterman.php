<?php
/**
 * `SmithWaterman.php`
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
 * PHP version 5.3
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

namespace HSBremen\ISBio\SequenceAlignment\Algorithm;

/**
 * An implementation of the Smith-Waterman algorithm for biological local
 * pairwise sequence alignment.
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
class SmithWaterman extends SequenceAlignment
{

    /**
     * @var Cell
     */
    private $highScoreCell;

    /**
     * @param string  $firstSequence
     * @param string  $secondSequence
     * @param integer $match
     * @param integer $mismatch
     * @param integer $gap
     */
    public function __construct(
        $firstSequence, $secondSequence, $match = 1, $mismatch = -1, $gap = -1
    ) {
        parent::__construct(
            $firstSequence, $secondSequence, $match, $mismatch, $gap
        );

        $this->highScoreCell = $this->scoreTable[0][0];
    }

    /**
     * @return void
     */
    protected function fillInCell(
        Cell $currentCell, Cell $cellAbove,
        Cell $cellToLeft, Cell $cellAboveLeft
    ) {
        $rowSpaceScore = $cellAbove->getScore() + $this->space;
        $colSpaceScore = $cellToLeft->getScore() + $this->space;
        $matchOrMismatchScore = $cellAboveLeft->getScore();

        if (substr($this->secondSequence, ($currentCell->getRow() - 1), 1) === substr($this->firstSequence, ($currentCell->getColumn() - 1), 1)) {
            $matchOrMismatchScore += $this->match;
        } else {
            $matchOrMismatchScore += $this->mismatch;
        }

        if ($rowSpaceScore >= $colSpaceScore) {
            if ($matchOrMismatchScore >= $rowSpaceScore) {
                if ($matchOrMismatchScore > 0) {
                    $currentCell->setScore($matchOrMismatchScore);
                    $currentCell->setPreviousCell($cellAboveLeft);
                }
            } else {
                if ($rowSpaceScore > 0) {
                    $currentCell->setScore($rowSpaceScore);
                    $currentCell->setPreviousCell($cellAbove);
                }
            }
        } else {
            if ($matchOrMismatchScore >= $colSpaceScore) {
                if ($matchOrMismatchScore > 0) {
                    $currentCell->setScore($matchOrMismatchScore);
                    $currentCell->setPrevCell($cellAboveLeft);
                }
            } else {
                if ($colSpaceScore > 0) {
                    $currentCell->setScore($colSpaceScore);
                    $currentCell->setPrevCell($cellToLeft);
                }
            }
        }

        if ($currentCell->getScore() > $this->highScoreCell->getScore()) {
            $this->highScoreCell = $currentCell;
        }
    }

    /**
     * @return boolean
     */
    public function __toString()
    {
        return "[SmithWaterman: sequence1=" - $this->firstSequence + ", sequence2="
            . $this->secondSequence . "]";
    }

    /**
     * @return boolean
     */
    protected function traceBackIsNotDone(Cell $currentCell)
    {
        return 0 !== $currentCell->getScore();
    }

    /**
     * return Cell
     */
    protected function getTracebackStartingCell()
    {
        return highScoreCell;
    }

    /**
     * return Cell
     */
    protected function getInitialPointer($row, $col)
    {
        return null;
    }

    /**
     * return integer
     */
    protected function getInitialScore($row, $col)
    {
        return 0;
    }

}
