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
 * PHP version 5.4
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage Algorithm
 * @author     Steffen Schütte <steffen.schuette@web.de>
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Steffen Schütte, Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Alignment;

use HochschuleBremen\Component\Sequence\DnaSequence;
use HochschuleBremen\Component\Alignment\GapPenalty\SimpleGapPenalty;
use HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory;
use HochschuleBremen\Component\Alignment\SubstitutionMatrix\NucleotideSubstitutionMatrixEnum;

/**
 * Test class for {@link SmithWaterman}.
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage Algorithm
 * @author     Steffen Schütte <steffen.schuette@web.de>
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Steffen Schütte, Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 *
 * @covers     HochschuleBremen\Component\Alignment\SmithWaterman
 */
class SmithWatermanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public static function providerNucleotideGetScoreTable()
    {
        return [
            [
                'ACTGGCAGT', // firstSequence
                'CACTGAT',   // secondSequence
                [
                    [0,  0,  0,  0,  0,  0,  0,  0,  0,  0], // expected
                    [0,  0,  5,  1,  0,  0,  5,  1,  0,  0],
                    [0,  5,  1,  1,  0,  0,  1, 10,  6,  2],
                    [0,  1, 10,  6,  2,  0,  6,  6,  6,  2],                    
                    [0,  0,  6, 15, 11,  7,  3,  2,  2, 11],
                    [0,  0,  2, 11, 20, 25, 21, 17, 22, 18],
                    [0,  5,  1,  7, 16, 21, 21, 26, 22, 18],
                    [0,  1,  1, 12, 12, 17, 17, 22, 22, 27],
                ]
            ],            [
                'CTGA', // firstSequence
                'GTTG',   // secondSequence
                [
                    [0,  0,  0,  0,  0], // expected
                    [0,  0,  0,  5,  1],
                    [0,  0,  5,  1,  1],
                    [0,  0, 10,  6,  2],
                    [0,  0,  6, 15, 11]
                ]
            ]
        ];
    }

    /**
     * @return void
     *
     * @dataProvider providerGetScoreTable
     * @test
     */
    public function testNucleotideGetScoreTable(
        $firstSequence, $secondSequence, $expected
    ) {

        $substitutionMatrix = SubstitutionMatrix\SubstitutionMatrixFactory::getInstance();
        
        $smithWaterman = new SmithWaterman(
                new DnaSequence($firstSequence),
                    new DnaSequence($secondSequence), 
                        new SimpleGapPenalty,
                            $substitutionMatrix->create(NucleotideSubstitutionMatrixEnum::NUCFOURTWO()));
        
        $actual = $smithWaterman->getScoreMatrixAsArray();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function providerNucleotideGetAlignment()
    {
        return [
            // firstSequence, secondSequence, expected
            // First test
            ['ACTGGCAGT', 'CACTGAT', ['ACTGGCAGT', 'ACT--G-AT']],
            ['CTGA', 'GTTG', ['-TG', 'TTG']]
        ];
    }

    /**
     * @return void
     *
     * @dataProvider providerGetAlignment
     * @test
     */
    public function testNucleotideGetAlignment($firstSequence, $secondSequence, $expected)
    {  
        $substitutionMatrix = SubstitutionMatrixFactory::getInstance();
        
        $smithWaterman = new SmithWaterman(
                new DnaSequence($firstSequence),
                    new DnaSequence($secondSequence), 
                        new SimpleGapPenalty, 
                            $substitutionMatrix->create(NucleotideSubstitutionMatrixEnum::NUCFOURTWO()));
        
        $actual = $smithWaterman->getPair();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function providerNucleotideGetAlignmentScore()
    {
        return [
            // firstSequence, secondSequence, expected
            ['ACTGGCAGT', 'CACTGAT', 27],
            ['CTGA', 'GTTG', 15]
        ];
    }

    /**
     * @return void
     *
     * @dataProvider providerGetAlignmentScore
     * @test
     */
    public function testNucleotideGetAlignmentScore(
        $firstSequence, $secondSequence, $expected
    ) {
        $substitutionMatrix = SubstitutionMatrixFactory::getInstance();
        
        $smithWaterman = new SmithWaterman(
                new DnaSequence($firstSequence),
                    new DnaSequence($secondSequence), 
                        new SimpleGapPenalty, 
                            $substitutionMatrix->create(NucleotideSubstitutionMatrixEnum::NUCFOURTWO()));
        
        $actual = $smithWaterman->getScore();

        $this->assertEquals($expected, $actual);
    }
}
