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
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   Release: @package_version@
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     Class available since Release 0.1.0
 */
class SmithWaterman
{

    /**
     * @var integer
     */
    const INITIAL_SCORE = 0;

    /**
     * @var string
     */
    const GAP_CHARACTER = '-';

    /**
     * @var SequenceInterface
     */
    private $query;

    /**
     * @var SequenceInterface
     */
    private $target;

    /**
     * @var GapPenaltyInterface
     */
    private $gapPenalty;

    /**
     * @var SubstitutionMatrixAbstract
     */
    private $substitutionMatrix;

    /**
     * @var integer
     */
    private $score = 0;

    /**
     * @var integer
     */
    private $minScore = self::INITIAL_SCORE;

    /**
     * @var integer
     */
    private $maxScore;

    /**
     * @var array
     */
    private $scoreMatrix;

    /**
     * @Cell
     */
    private $scoreCell;

    /**
     * @var integer
     */
    private $scoreMatrixWidth;

    /**
     * @var integer
     */
    private $scoreMatrixHeight;

    /**
     * @var array
     */
    private $pair;

    /**
     * Prepares for a pairwise local sequence alignment.
     *
     * @param SequenceInterface          $query      The first sequence of the
     *                                               pair to align.
     * @param SequenceInterface          $target     The second sequence of the
     *                                               pair to align.
     * @param GapPenaltyInterface        $gapPenalty The gap penalties used
     *                                               during alignment.
     * @param SubstitutionMatrixAbstract $subMatrix  The set of substitution
     *                                               scores used during
     *                                               alignment.
     */
    public function __construct(
        SequenceInterface $query, SequenceInterface $target,
        GapPenaltyInterface $gapPenalty, SubstitutionMatrixAbstract $subMatrix
    ) {
        $this->query = $query;
        $this->target = $target;
        $this->gapPenalty = $gapPenalty;
        $this->substitutionMatrix = $subMatrix;

        $maxq = 0;
        $maxt = 0;

        for ($i = 0; $i < $query->getLength(); ++$i) {
            $compound = \substr($query, $i, 1);
            $maxq += $this->substitutionMatrix->getValue($compound, $compound);
        }

        for ($i = 0; $i < $target->getLength(); ++$i) {
            $compound = \substr($target, $i, 1);
            $maxt += $this->substitutionMatrix->getValue($compound, $compound);
        }

        $this->maxScore = \max([$maxq, $maxt]);
        $this->scoreMatrixWidth = (\strlen($query) + 1);
        $this->scoreMatrixHeight = (\strlen($target) + 1);
        $this->initializeScoreMatrix();
        $this->calculateScoreMatrix();
        $this->traceback();
    }

    /**
     * Initializes all Cells of the score matrix.
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
    }

    /**
     * Calculates all Cells of the score matrix.
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

        if ($currentCell->getScore() > $this->score) {
            $this->score = $currentCell->getScore();
            $this->scoreCell = $currentCell;
        }
    }

    private function returnCompoundFromTarget(Cell $currentCell)
    {
        return \substr($this->target, ($currentCell->getRow() - 1), 1);
    }

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
     * Runs the traceback.
     *
     * @return void
     */
    private function traceback()
    {
        $alignedQuery = '';
        $alignedTarget = '';

        // Start at the Cell with the highest score.
        $currentCell = $this->scoreCell;

        $alignedQuery = $this->returnCompoundFromQuery($currentCell)
            . $alignedQuery;
        $alignedTarget = $this->returnCompoundFromTarget($currentCell)
            . $alignedTarget;
        $oldCell = $currentCell;
        $currentCell = $currentCell->getPreviousCell();

        while (true === $this->isTracebackNotDone($currentCell)) {

            $rowDiff = ($oldCell->getRow() - $currentCell->getRow());
            if (1 === $rowDiff) {
                $alignedTarget = $this->returnCompoundFromTarget($currentCell)
                    . $alignedTarget;
            } else {
                $alignedTarget = '-' . $alignedTarget;
            }

            $columnDiff = ($oldCell->getColumn() - $currentCell->getColumn());
            if (1 === $columnDiff) {
                $alignedQuery = $this->returnCompoundFromQuery($currentCell)
                    . $alignedQuery;
            } else {
                $alignedQuery = '-' . $alignedQuery;
            }

            $oldCell = $currentCell;
            $currentCell = $currentCell->getPreviousCell();
        }

        $this->pair = [$alignedQuery, $alignedTarget];
    }

    /**
     * Checks whether the traceback is *not* done.
     *
     * @param Cell $currentCell The current Cell in the score table.
     *
     * @return boolean `true`if the traceback is *not* done; `false` otherwise.
     */
    private function isTracebackNotDone(Cell $currentCell)
    {
        return self::INITIAL_SCORE !== $currentCell->getScore();
    }

    // Getter

    /**
     * @return SequenceInterface
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return SequenceInterface
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return GapPenaltyInterface
     */
    public function getGapPenalty()
    {
        return $this->gapPenalty;
    }

    /**
     * @return SubstitutionMatrixAbstract
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
     * Returns the score matrix resulting from the algorithm.
     *
     * @return array The score matrix resulting from the algorithm.
     */
    public function getScoreMatrix()
    {
        return $this->scoreMatrix;
    }


    public function getScoreMatrixAsArray()
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
     * Returns a score as a similarity between 0.0 and the specified scale
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
     * Returns a string representation of this algorithm.
     *
     * @return string The string representation.
     */
    public function __toString()
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
     * @return string
     * @todo Create class SequencePair.
     */
    public function formatAlignment()
    {
        $lengthQuery = \strlen($this->pair[0]);
        $lengthTarget = \strlen($this->pair[1]);

//        $result = '1 ' . $this->pair[0] . ' ' . $lengthQuery . \PHP_EOL;
        $result = $this->pair[0] . \PHP_EOL;
//        $result .= '  ';

        $min = \min([$lengthQuery, $lengthTarget]);

        for ($i = 0; $i < $min; ++$i) {
            if (\substr($this->pair[0], $i, 1) === substr($this->pair[1], $i, 1)) {
                $result .= '|';
            } else {
                $result .= ' ';
            }
        }

        $result .= \PHP_EOL;
        $result .= $this->pair[1] . \PHP_EOL;
//        $result .= '1 ' . $this->pair[1] . ' ' . $lengthTarget . \PHP_EOL;

        return $result;
    }

}

//require __DIR__ . '/../../../../../vendor/autoload.php';
//
//use HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory;
//use HochschuleBremen\Component\Alignment\SubstitutionMatrix\NucleotideSubstitutionMatrixEnum;
//use HochschuleBremen\Component\Sequence\DnaSequence;
//use HochschuleBremen\Component\Alignment\GapPenalty\SimpleGapPenalty;
//
//$query = new DnaSequence('ACTGGCAGT');
//$target = new DnaSequence('CACTGAT');
//$substitutionMatrix = SubstitutionMatrixFactory::getInstance()
//    ->create(NucleotideSubstitutionMatrixEnum::NUCFOURTWO());
//
//$aligner = new SmithWaterman(
//    $query,
//    $target,
//    new SimpleGapPenalty,
//    $substitutionMatrix
//);
//
//echo $aligner;
