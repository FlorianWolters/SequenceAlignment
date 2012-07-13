<?php
/**
 * `DynamicProgrammingAbstract.php`
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
 * TODO
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
abstract class DynamicProgrammingAbstract
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
    protected $scoreTableHeight;

    /**
     * @var integer
     */
    protected $scoreTableWidth;

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
        $this->scoreTableHeight = \strlen($this->secondSequence) + 1;
        $this->scoreTableWidth = \strlen($this->firstSequence) + 1;
        $this->initialize();
    }

    /**
     * @return array
     */
    public function getScoreTable()
    {
        $this->ensureTableIsFilledIn();

        $matrix = [];
        for ($i = 0; $i < $this->scoreTableHeight; ++$i) {
            for ($j = 0; $j < $this->scoreTableWidth; ++$j) {
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
        for ($i = 0; $i < $this->scoreTableHeight; ++$i) {
            for ($j = 0; $j < $this->scoreTableWidth; ++$j) {
                $this->scoreTable[$i][$j]->setScore(
                    $this->getInitialScore($i, $j)
                );
            }
        }
    }

    /**
     * @return void
     */
    protected function initializePointers()
    {
        for ($i = 0; $i < $this->scoreTableHeight; ++$i) {
            for ($j = 0; $j < $this->scoreTableWidth; ++$j) {
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
        for ($i = 0; $i < $this->scoreTableHeight; ++$i) {
            for ($j = 0; $j < $this->scoreTableWidth; ++$j) {
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
        for ($row = 1; $row < $this->scoreTableHeight; ++$row) {
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