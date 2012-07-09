<?php
/**
 * `SmithWatermanTest.php`
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
 * PHP version 5.4.4
 *
 * @category   Biology
 * @package    SmithWaterman
 * @subpackage Algorithm
 * @author     Steffen Schuette <steffen.schuette@web.de>
 * @copyright  2012 Steffen Schuette
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Algorithm;

use HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\Blosum60;

/**
 * Test class for {@link SmithWaterman}.
 *
 * @category   Biology
 * @package    SmithWaterman
 * @subpackage Algorithm
 * @author     Steffen Schuette <steffen.schuette@web.de>
 * @copyright  2012 Steffen Schuette
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 *
 * @covers     HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\Blosum60
 */
class SmithWatermanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SmithWaterman
     */
    private $smithWaterman;

    /*
     * Generel method calling method helperGetAligmentScore for each test case
     */
    public function testAlignmentScores()
    {
        // 01 Test scenario
        $this->helperGetAlignmentScore('ACACACTA', 'AGCACACA', 5); 
        
        // 02 Test scenario
        $this->helperGetAlignmentScore('ACTTGGAAGT', 'GTGAGACT', 3); 
    }
    
    /**
     * Generel method calling method helperGetScoreTable for each test case
     */
    public function testScoreTables()
    {
        // 01 Test scenario
        // Source: http://en.wikipedia.org/wiki/Smith-Waterman_algorithm (score matrix self calculated)
        // Sequence1: ACACACTA
        // Sequence2: AGCACACA
        // Match:    +1
        // Mismatch: -1
        $result = [
            [ 0, 0, 0, 0, 0, 0, 0, 0, 0], 
            [ 0, 1, 0, 1, 0, 1, 0, 0, 1],
            [ 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [ 0, 0, 1, 0, 1, 0, 1, 0, 0],
            [ 0, 1, 0, 2, 1, 2, 1, 0, 1],
            [ 0, 0, 2, 1, 3, 2, 3, 2, 1],
            [ 0, 1, 1, 3, 2, 4, 3, 2, 3],
            [ 0, 0, 2, 2, 4, 3, 5, 4, 3],
            [ 0, 1, 1, 3, 3, 5, 4, 4, 5] 
        ];
        $this->helperGetScoreTable('ACACACTA', 'AGCACACA', $result);
         
        // 02 Test scenario
        // Source: Exercise: Pairwise Alignment and BLAST
        // Sequence1: ACTTGGAAGT
        // Sequence2: GTGAGACT
        // Match:    +1
        // Mismatch: -1
        $result = [
            [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
            [ 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0],
            [ 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 2],
            [ 0, 0, 0, 0, 0, 2, 1, 0, 0, 1, 1],
            [ 0, 1, 0, 0, 0, 1, 1, 2, 1, 0, 0],
            [ 0, 0, 0, 0, 0, 1, 2, 1, 1, 2, 0],
            [ 0, 1, 0, 0, 0, 0, 1, 3, 2, 1, 1],
            [ 0, 0, 2, 1, 0, 0, 0, 2, 2, 1, 0],
            [ 0, 0, 1, 3, 2, 1, 0, 1, 1, 1, 2] 
        ];
        $this->helperGetScoreTable('ACTTGGAAGT', 'GTGAGACT', 3);
    }
    
    /*
     * Method calling the SmithWaterman method getAligmentScore.
     */
    private function helperGetAlignmentScore($firstSequence, $secondSequence, $result)
    {
        $this->smithWaterman = new SmithWaterman($firstSequence, $secondSequence);
        $expected = $result;
        $this->assertEquals($expected, $this->smithWaterman->getAlignmentScore());
    }
        
    /*
     * Method calling the SmithWaterman method getScoreTable.
     */
    private function helperGetScoreTable($firstSequence, $secondSequence, $result)
    {
        $this->smithWaterman = new SmithWaterman($firstSequence, $secondSequence);
        $expected = $result;
        $this->assertEquals($expected, $this->smithWaterman->getScoreTable());
    }
}
