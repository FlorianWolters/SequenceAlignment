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
 * PHP version 5.4
 *
 * @category  Biology
 * @package   Alignment
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @author    Olav Hoffmann <olavhoffmann@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   GIT: $Id$
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Alignment;

use HochschuleBremen\Component\Alignment\GapPenalty\GapPenaltyInterface;
use HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixAbstract;
use HochschuleBremen\Component\Sequence\SequenceInterface;

/**
 * Smith and Waterman defined an algorithm for pairwise local sequence
 * alignments (best match of sections from each sequence).
 *
 * This class performs such local sequence comparisons efficiently by dynamic
 * programming.
 *
 * @category  Biology
 * @package   Alignment
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @author    Olav Hoffmann <olavhoffmann@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   Release: @package_version@
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     Class available since Release 0.1.0
 */
class SmithWaterman
{

    /**
     * The initial score of each Cell in the score matrix.
     *
     * @var integer
     */
    const INITIAL_SCORE = 0;

    /**
     * The gap character.
     *
     * @var string
     */
    const GAP_CHARACTER = '-';

    /**
     * The first sequence of the pair to align.
     *
     * @var SequenceInterface
     */
    private $query;

    /**
     * The second sequence of the pair to align.
     *
     * @var SequenceInterface
     */
    private $target;

    /**
     * The gap penalties used during alignment.
     *
     * @var GapPenaltyInterface
     */
    private $gapPenalty;

    /**
     * The set of substitution scores used during alignment.
     *
     * @var SubstitutionMatrixAbstract
     */
    private $substitutionMatrix;

    /**
     * The Cell holding the score resulting from the algorithm.
     *
     * @var Cell
     */
    private $scoreCell;

    /**
     * The entire score matrix built during alignment.
     *
     * @var array
     */
    private $scoreMatrix;

    /**
     * Returns the minimum possible score.
     *
     * @var integer
     */
    private $minScore = self::INITIAL_SCORE;

    /**
     * Returns the maximum possible score.
     *
     * @var integer
     */
    private $maxScore;

    /**
     * The width of the score matrix.
     *
     * @var integer
     */
    private $scoreMatrixWidth;

    /**
     * The height of the score matrix.
     *
     * @var integer
     */
    private $scoreMatrixHeight;

    /**
     * The sequence alignment pair.
     *
     * @var array
     */
    private $pair;

    /**
     * Prepares for a pairwise local sequence alignment.
     *
     * @param SequenceInterface          $query              The first sequence
     *                                                       of the pair to
     *                                                       align.
     * @param SequenceInterface          $target             The second sequence
     *                                                       of the pair to
     *                                                       align.
     * @param GapPenaltyInterface        $gapPenalty         The gap penalties
     *                                                       used during
     *                                                       alignment.
     * @param SubstitutionMatrixAbstract $substitutionMatrix The set of
     *                                                       substitution scores
     *                                                       used during
     *                                                       alignment.
     */
    public function __construct(
        SequenceInterface $query,
        SequenceInterface $target,
        GapPenaltyInterface $gapPenalty,
        SubstitutionMatrixAbstract $substitutionMatrix
    ) {
        $this->query = $query;
        $this->target = $target;
        $this->gapPenalty = $gapPenalty;
        $this->substitutionMatrix = $substitutionMatrix;
        $this->maxScore = $this->calculateMaximumScore();
        $this->scoreMatrixWidth = (\strlen($query) + 1);
        $this->scoreMatrixHeight = (\strlen($target) + 1);
        $this->initializeScoreMatrix();
        $this->calculateScoreMatrix();
        $this->traceback();
    }

    /**
     * Calculates the maximum possible score.
     *
     * @return integer The maximum possible score.
     */
    private function calculateMaximumScore()
    {
        $maxQuery = 0;
        $maxTarget = 0;

        for ($i = 0; $i < $this->query->getLength(); ++$i) {
            $compound = \substr($this->query, $i, 1);
            $maxQuery += $this->substitutionMatrix->getValue(
                $compound, $compound
            );
        }

        for ($i = 0; $i < $this->target->getLength(); ++$i) {
            $compound = \substr($this->target, $i, 1);
            $maxTarget += $this->substitutionMatrix->getValue(
                $compound, $compound
            );
        }

        return \max([$maxQuery, $maxTarget]);
    }

    /**
     * Initializes the score matrix with Cell objects that are initialized with
     * the correct row, the correct column and the initial score.
     *
     * @return void
     */
    private function initializeScoreMatrix()
    {
        for ($i = 0; $i < $this->scoreMatrixHeight; ++$i) {
            for ($j = 0; $j < $this->scoreMatrixWidth; ++$j) {
                $this->scoreMatrix[$i][$j] = new Cell(
                    $i, $j, self::INITIAL_SCORE
                );
            }
        }

        $this->scoreCell = $this->scoreMatrix[0][0];
    }

    /**
     * Calculates the score matrix.
     *
     * @return void
     */
    private function calculateScoreMatrix()
    {
        for ($row = 1; $row < $this->scoreMatrixHeight; ++$row) {
            for ($col = 1; $col < $this->scoreMatrixWidth; ++$col) {
                $currentCell = $this->scoreMatrix[$row][$col];
                $cellAbove = $this->scoreMatrix[$row - 1][$col];
                $cellToLeft = $this->scoreMatrix[$row][$col - 1];
                $cellAboveLeft = $this->scoreMatrix[$row - 1][$col - 1];
                $this->calculateCell(
                    $currentCell, $cellAbove, $cellToLeft, $cellAboveLeft
                );
            }
        }
    }

    /**
     * Calculates the current Cell in the score matrix.
     *
     * @param Cell $currentCell   The current Cell.
     * @param Cell $cellAbove     The Cell above the current Cell.
     * @param Cell $cellToLeft    The Cell to the left of the current Cell.
     * @param Cell $cellAboveLeft The cell to above and to the left of the
     *                            current Cell.
     *
     * @return void
     */
    private function calculateCell(
        Cell $currentCell, Cell $cellAbove,
        Cell $cellToLeft, Cell $cellAboveLeft
    ) {
        $a = $this->returnCompoundFromQuery($currentCell);
        $b = $this->returnCompoundFromTarget($currentCell);

        // Calculate the weight.
        $weight = $this->weight($a, $b);

        // Match/Mismatch
        $cellAboveLeftScore = $cellAboveLeft->getScore() + $weight;
        // Deletion
        $cellAboveScore = $cellAbove->getScore() + $weight;
        // Insertion
        $cellToLeftScore = $cellToLeft->getScore() + $weight;

        if ($cellAboveScore >= $cellToLeftScore) {
            if ($cellAboveLeftScore >= $cellAboveScore) {
                if ($cellAboveLeftScore > self::INITIAL_SCORE) {
                    $currentCell->setScore($cellAboveLeftScore);
                    $currentCell->setPreviousCell($cellAboveLeft);
                }
            } else {
                if ($cellAboveScore > self::INITIAL_SCORE) {
                    $currentCell->setScore($cellAboveScore);
                    $currentCell->setPreviousCell($cellAbove);
                }
            }
        } else {
            if ($cellAboveLeftScore >= $cellToLeftScore) {
                if ($cellAboveLeftScore > self::INITIAL_SCORE) {
                    $currentCell->setScore($cellAboveLeftScore);
                    $currentCell->setPreviousCell($cellAboveLeft);
                }
            } else {
                if ($cellToLeftScore > self::INITIAL_SCORE) {
                    $currentCell->setScore($cellToLeftScore);
                    $currentCell->setPreviousCell($cellToLeft);
                }
            }
        }

        if ($currentCell->getScore() > $this->scoreCell->getScore()) {
            $this->scoreCell = $currentCell;
        }
    }

    /**
     * Returns the compound for the specified current Cell from the second
     * sequence.
     *
     * @param Cell $currentCell The current Cell.
     *
     * @return string The compound from the second sequence.
     */
    private function returnCompoundFromTarget(Cell $currentCell)
    {
        return \substr($this->target, ($currentCell->getRow() - 1), 1);
    }

    /**
     * Returns the compound for the specified current Cell from the first
     * sequence.
     *
     * @param Cell $currentCell The current Cell.
     *
     * @return string The compound from the first sequence.
     */
    private function returnCompoundFromQuery(Cell $currentCell)
    {
        return \substr($this->query, ($currentCell->getColumn() - 1), 1);
    }

    /**
     * Calculates the gap-scoring scheme.
     *
     * @param string $x The first compound to compare.
     * @param string $y The second compund to compare.
     *
     * @return integer The score to add.
     */
    private function weight($x, $y) {
        return $this->substitutionMatrix->getValue($x, $y);
    }

    /**
     * Calculates the sequence alignment pair.
     *
     * @return void
     * @todo Fix confusing source code
     */
    private function traceback()
    {
        // Start at the Cell with the score.
        $alignedQuery = $this->returnCompoundFromQuery($this->scoreCell);
        $alignedTarget = $this->returnCompoundFromTarget($this->scoreCell);
        $previousCell = $this->scoreCell;
        $currentCell = $this->scoreCell->getPreviousCell();

        while (true === $this->isTracebackNotDone($currentCell)) {
            $rowDiff = ($previousCell->getRow() - $currentCell->getRow());
            if (1 === $rowDiff) {
                $alignedTarget = $this->returnCompoundFromTarget($currentCell)
                    . $alignedTarget;
            } else {
                $alignedTarget = '-' . $alignedTarget;
            }

            $columnDiff = ($previousCell->getColumn()
                - $currentCell->getColumn());
            if (1 === $columnDiff) {
                $alignedQuery = $this->returnCompoundFromQuery($currentCell)
                    . $alignedQuery;
            } else {
                $alignedQuery = '-' . $alignedQuery;
            }

            $previousCell = $currentCell;
            $currentCell = $currentCell->getPreviousCell();
        }

        $this->pair = [$alignedQuery, $alignedTarget];
    }

    /**
     * Checks whether the traceback is *not* done.
     *
     * @param Cell $currentCell The current Cell in the score table.
     *
     * @return boolean `true` if the traceback is *not* done; `false` otherwise.
     */
    private function isTracebackNotDone(Cell $currentCell)
    {
        return self::INITIAL_SCORE !== $currentCell->getScore();
    }

    // Getter

    /**
     * Returns the first sequence of the pair.
     *
     * @return SequenceInterface The first sequence of the pair.
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Returns the second sequence of the pair.
     *
     * @return SequenceInterface The second sequence of the pair.
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Returns the gap penalties.
     *
     * @return GapPenaltyInterface The gap penalties used during alignment.
     */
    public function getGapPenalty()
    {
        return $this->gapPenalty;
    }

    /**
     * Returns the substitution matrix.
     *
     * @return SubstitutionMatrixAbstract The set of substitution scores used
     *                                    during alignment.
     */
    public function getSubstitutionMatrix()
    {
        return $this->substitutionMatrix;
    }

    /**
     * Returns the sequence alignment pair.
     *
     * @return array The sequence alignment pair.
     */
    public function getPair()
    {
        return $this->pair;
    }

    // Result

    /**
     * Returns the maximum possible score.
     *
     * @return integer The maximum possible score.
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * Returns the minimum possible score.
     *
     * @return integer The minimum possible score.
     */
    public function getMinScore()
    {
        return $this->minScore;
    }

    /**
     * Returns the score resulting from the algorithm.
     *
     * @return integer The score resulting from the algorithm.
     */
    public function getScore()
    {
        return $this->scoreCell->getScore();
    }

    /**
     * Returns the entire score matrix built during alignment.
     *
     * The first dimension has the length of the first (query) sequence + 1; the
     * second has the length of the second (target) sequence + 1.
     *
     * @return array The score matrix.
     */
    public function getScoreMatrix()
    {
        $result = [];

        for ($i = 0; $i < $this->scoreMatrixHeight; ++$i) {
            for ($j = 0; $j < $this->scoreMatrixWidth; ++$j) {
                $result[$i][$j] = $this->scoreMatrix[$i][$j]->getScore();
            }
        }

        return $result;
    }

    /**
     * Returns score as a distance between 0.0 and the specified scale
     * (default: 1.0).
     *
     * @param float $scale The maximum distance.
     *
     * @return float The score as a distance between 0.0 and the specified
     *               scale (default: 1.0).
     */
    public function getDistance($scale = 1.0)
    {
        return $scale * ($this->getMaxScore() - $this->getScore())
            / ($this->getMaxScore() - $this->getMinScore());
    }

    /**
     * Returns score as a similarity between 0.0 and the specified scale
     * (default: 1.0).
     *
     * @param float $scale The maximum similarity.
     *
     * @return float The score as a similarity between 0.0 and the specified
     *               scale (default: 1.0).
     */
    public function getSimilarity($scale = 1.0)
    {
        return $scale * ($this->getScore() - $this->getMinScore())
            / ($this->getMaxScore() - $this->getMinScore());
    }

    /**
     * Returns the string representation of the entire score matrix built during
     * alignment.
     *
     * @return string The score matrix as a string.
     */
    public function scoreMatrixToString()
    {
        $result = "\t" . self::GAP_CHARACTER;

        foreach (\str_split($this->query) as $currentCharOfFirstSequence) {
            $result .= "\t" . $currentCharOfFirstSequence;
        }

        $result .= \PHP_EOL;

        for ($i = 0; $i < $this->target->getLength() + 1; ++$i) {
            if ($i > 0) {
                $result .= \substr($this->target, $i - 1, 1);
            } else {
                $result .= self::GAP_CHARACTER;
            }

            for ($j = 0; $j < $this->query->getLength() + 1; ++$j) {
                $result .= "\t" . $this->scoreMatrix[$i][$j];
            }

            if ($i < $this->target->getLength()) {
                $result .= \PHP_EOL;
            }
        }

        return $result;
    }

    /**
     * Returns the string representation of the sequence alignment pair.
     *
     * @return string The sequence alignment pair as a string.
     */
    public function pairToString()
    {
        $lengthQuery = \strlen($this->pair[0]);
        $lengthTarget = \strlen($this->pair[1]);
        $min = \min([$lengthQuery, $lengthTarget]);

        $result = $this->pair[0] . \PHP_EOL;

        for ($i = 0; $i < $min; ++$i) {
            $queryCompund = \substr($this->pair[0], $i, 1);
            $targetCompund = \substr($this->pair[1], $i, 1);
            if ($queryCompund === $targetCompund) {
                $result .= '|';
            } else {
                $result .= ' ';
            }
        }

        $result .= \PHP_EOL;
        $result .= $this->pair[1] . \PHP_EOL;

        return $result;
    }

}
