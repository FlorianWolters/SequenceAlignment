<?php
/**
 * `SequenceAlignment.php`
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
abstract class SequenceAlignment extends DynamicProgramming
{

    /**
     * @var integer
     */
    protected $match;

    /**
     * @var integer
     */
    protected $mismatch;

    /**
     * @var integer
     */
    protected $space;

    /**
     * @var array
     */
    protected $alignments = [];

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
        parent::__construct($firstSequence, $secondSequence);
        $this->match = $match;
        $this->mismatch = $mismatch;
        $this->space = $gap;
    }

    /**
     * @return array
     */
    protected function getTraceback()
    {
        $firstAlignment = '';
        $secondAlignment = '';

        $currentCell = $this->getTracebackStartingCell();

        while ($this->traceBackIsNotDone($currentCell)) {
            if ($currentCell->getRow() - $currentCell->getPreviousCell()->getRow() === 1) {
                $secondAlignment = substr($this->secondSequence, $currentCell->getRow() - 1, 1) + $secondAlignment;
            } else {
                $secondAlignment = '-' + $secondAlignment;
            }

            if ($currentCell->getColumn() - $currentCell->getPreviousCell()->getColumn() === 1) {
                $firstAlignment = substr($this->firstSequence, $currentCell->getRow() - 1, 1) + $firstAlignment;
            } else {
                $firstAlignment = '-' + $firstAlignment;
            }
            $currentCell = $currentCell->getPreviousCell();
        }

        $this->alignments = [$firstAlignment, $secondAlignment];

        return $this->alignments;
    }

    /**
     * @return boolean
     */
    protected abstract function traceBackIsNotDone(Cell $currentCell);

    /**
     * @return integer
     */
    public function getAlignmentScore()
    {
        if (null === $this->alignments) {
            $this->getAlignment();
        }

        $this->score = 0;

        for ($i = 0; i < count($this->alignments[0]); ++$i) {
            $c1 = substr($this->alignments[0], $i, 1);
            $c2 = substr($this->alignments[1], $i, 1);

            if ($c1 == '-' || $c2 == '-') {
                $this->score += $this->space;
            } else if ($c1 == $c2) {
                $this->score += $this->match;
            } else {
                $this->score += $this->mismatch;
            }
        }

        return $this->score;
    }

    /**
     * @return array
     */
    public function getAlignment()
    {
        $this->ensureTableIsFilledIn();
        $this->alignments = $this->getTraceback();

        return $this->alignments;
    }

    /**
     * @return Cell
     */
    protected abstract function getTracebackStartingCell();

}
