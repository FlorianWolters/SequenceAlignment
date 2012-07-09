<?php
/**
 * `DynamicProgramming.php`
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
 * TODO
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
abstract class DynamicProgramming
{

    /**
     * @var string
     */
    protected $firstSequence;

    /**
     * @var string
     */
    protected $secondSequence;

    /**
     * @var integer
     */
    protected $firstSequenceLength;

    /**
     * @var integer
     */
    protected $secondSequenceLength;

    /**
     * @var array
     */
    protected $scoreTable = [[]];

    /**
     * @var boolean
     */
    protected $tableIsFilledIn = false;

    /**
     * @var boolean
     */
    protected $isInitialized = false;

    /**
     * @param string $firstSequence
     * @param string $secondSequence
     */
    public function __construct($firstSequence, $secondSequence)
    {
        $this->firstSequence = $firstSequence;
        $this->secondSequence = $secondSequence;
        $this->firstSequenceLength = \strlen($this->firstSequence);
        $this->secondSequenceLength = \strlen($this->secondSequence);
        $this->initialize();
    }

    /**
     * @return array
     */
    public function getScoreTable()
    {
        $this->ensureTableIsFilledIn();

        $m = $this->firstSequenceLength + 1;
        $n = $this->secondSequenceLength + 1;

        $matrix = [];
        for ($i = 0; $i < $this->firstSequenceLength; ++$i) {
            for ($j = 0; $j < $this->secondSequenceLength; ++$j) {
                $matrix[$i][$j] = $this->scoreTable[$i][$j]->getScore();
            }
        }

        return $matrix;
    }

    /**
     * @return void
     */
    protected function initializeScores()
    {
        for ($i = 0; $i < $this->firstSequenceLength; ++$i) {
            for ($j = 0; $j < $this->secondSequenceLength; ++$j) {
                $this->scoreTable[$i][$j]->setScore($this->getInitialScore($i, $j));
            }
        }
    }

    /**
     * @return void
     */
    protected function initializePointers()
    {
        for ($i = 0; $i < $this->firstSequenceLength; ++$i) {
            for ($j = 0; $j < $this->secondSequenceLength; ++$j) {
                $this->scoreTable[$i][$j]->setPreviousCell(
                    $this->getInitialPointer($i, $j)
                );
            }
        }
    }

    /**
     * @return void
     */
    protected function initialize()
    {
        for ($i = 0; $i < $this->firstSequenceLength; ++$i) {
            for ($j = 0; $j < $this->secondSequenceLength; ++$j) {
                $this->scoreTable[$i][$j] = new Cell($i, $j);
            }
        }

        $this->initializeScores();
        $this->initializePointers();

        $this->isInitialized = true;
    }

    protected abstract function getInitialPointer($row, $col);

    protected abstract function getInitialScore($row, $col);

    protected abstract function fillInCell(
        Cell $currentCell, Cell $cellAbove,
        Cell $cellToLeft, Cell $cellAboveLeft
    );

    protected function fillIn()
    {
        for ($row = 1; $row < $this->firstSequenceLength; ++$row) {
            for ($col = 1; $col < count($this->scoreTable[$row]); ++$col) {
                $currentCell = $this->scoreTable[$row][$col];
                $cellAbove = $this->scoreTable[$row - 1][$col];
                $cellToLeft = $this->scoreTable[$row][$col - 1];
                $cellAboveLeft = $this->scoreTable[$row - 1][$col - 1];
                $this->fillInCell(
                    $currentCell, $cellAbove, $cellToLeft, $cellAboveLeft
                );
            }
        }

        $this->tableIsFilledIn = true;
    }

    /**
     * @return array
     */
    abstract protected function getTraceback();

    /**
     * @return void
     */
    protected function ensureTableIsFilledIn()
    {
        if (false === $this->isInitialized) {
            $this->initialize();
        }

        if (false === $this->tableIsFilledIn) {
            $this->fillIn();
        }
    }

}
