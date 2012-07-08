<?php
/**
 * `Alignment.php`
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
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Model;

use HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\SubstitutionMatrixAbstract;

/**
 * Holds the output of a pairwise sequences alignment.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 */
class Alignment
{

	/**
	 * The character to use for a gap.
     *
     * @var string
	 */
	const GAP = '-';

    /**
     * The first input sequence.
     *
     * @var string
     */
    private $firstSeq;

    /**
     * The second input sequence.
     *
     * @var array
     */
    private $secondSeq;

	/**
	 * The scoring matrix to use for this Alignment.
     *
     * @var SubstitutionMatrixAbstract
	 */
	private $scoringMatrix;

	/**
	 * The costs for opening a gap in this Alignment.
     *
     * @var float
	 */
	private $gapOpenCosts;

	/**
	 * The costs for extending a gap in this Alignment.
     *
     * @var float
	 */
	private $gapExtendCosts;

	/**
	 * The score of this Alignment.
     *
     * @var float
	 */
	private $score;

    /**
     * Constructs a new Alignment with the specified two sequences, the
     * specified scoring matrix, the specified costs for opening a gap and the
     * specified costs for extending a gap.
     *
     * @param string                $firstSeq       The first sequence to align.
     * @param string                $secondSeq      The second sequence to
     *                                              align.
     * @param ScoringMatrixAbstract $scoringMatrix  The scoring matrix to use.
     * @param float                 $gapOpenCosts   The costs for opening a gap
     *                                              in the alignment.
     * @param float                 $gapExtendCosts The costs for extending a
     *                                              gap in the alignment.
     * @todo Implement input validation.
     */
    public function __construct(
        $firstSeq, $secondSeq, SubstitutionMatrixAbstract $scoringMatrix,
        $gapOpenCosts = 10, $gapExtendCosts = 0.5
    ) {
        $this->firstSeq = \str_split($firstSeq);
        $this->secondSeq = \str_split($secondSeq);
        $this->scoringMatrix = $scoringMatrix->getScores();
        $this->gapOpen = $gapOpenCosts;
        $this->gapExtend = $gapExtendCosts;
    }

	/**
	 * Calculates the score of this Alignment.
	 *
	 * @return float The calculated score.
     * @todo Algorithm could be refactored into a class.
	 */
	public function calculateScore()
    {
        // The calculated score.
		$result = 0;

        // Signals that in the previous step there was a gap in the first
        // sequence.
		$gapInFirstSeq = false;

        // Signals that in the previous step there was a gap in the second
        // sequence.
		$gapInSecondSeq = false;

		for ($i = 0, $n = \count($this->sequence1); $i < $n; ++$i) {
			$currentCharFromFirstSeq = $this->sequence1[$i];
			$currentCharFromSecondSeq = $this->sequence2[$i];

			if (self::GAP === $currentCharFromFirstSeq) {
                // The next character in the first sequence is a gap.
                $result -= $this->calculateCostsForPrevious($gapInFirstSeq);

				$gapInFirstSeq = true;
				$gapInSecondSeq = false;
			} else if (self::GAP === $currentCharFromSecondSeq) {
                // The next character in the second sequence is a gap.
                $result -= $this->calculateCostsForPrevious($gapInSecondSeq);

                $gapInFirstSeq = false;
				$gapInSecondSeq = true;
			} else {
                // The next characters in boths sequences are not gaps.
				$result += $this->scoringMatrix->getScore(
                    $currentCharFromFirstSeq, $currentCharFromSecondSeq
                );
				$gapInFirstSeq = false;
				$gapInSecondSeq = false;
			}
		}

		return $result;
	}

    /**
     * Calculates the costs for the previous step in this Alignment.
     *
     * @param boolean $previousGap Whether the previous has been a gap.
     *
     * @return float The costs for the previous step.
     */
    private function calculateCostsForPrevious($previousGap)
    {
        return (true === $previousGap)
            ? $this->gapExtendCosts
            : $this->gapOpenCosts;
    }

	/**
	 * Checks if the calculated score matches the field score.
	 *
	 * @return boolean `true` if equal; `false` otherwise.
	 */
	public function checkScore()
    {
		return ($this->calculateScore() === $this->score);
	}

}
