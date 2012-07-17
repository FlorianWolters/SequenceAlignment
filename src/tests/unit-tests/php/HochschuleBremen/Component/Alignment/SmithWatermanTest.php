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
 * @category  Biology
 * @package   Alignment
 * @author    Steffen Schütte <steffen.schuette@web.de>
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012 Steffen Schütte, Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   GIT: $Id$
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     File available since Release 0.1.0
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
     * @var SubstitutionMatrixAbstract
     */
    private $substitutionMatrix;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $substitutionMatrixFactory = SubstitutionMatrixFactory::getInstance();
        $this->substitutionMatrix = $substitutionMatrixFactory->create(
            NucleotideSubstitutionMatrixEnum::NUCFOURTWO()
        );
    }

    /**
     * @return array
     */
    public static function providerGetScoreMatrixForSubstitutionMatrixNucFourTwo()
    {
        return [
            [
                'ACTGGCAGT', // query
                'CACTGAT',   // target
                [
                    [0,  0,  0,  0,  0,  0,  0,  0,  0,  0], // expected
                    [0,  0,  5,  1,  0,  0,  5,  1,  0,  0],
                    [0,  5,  1,  1,  0,  0,  1, 10,  6,  2],
                    [0,  1, 10,  6,  2,  0,  6,  6,  6,  2],
                    [0,  0,  6, 15, 11,  7,  3,  2,  2, 11],
                    [0,  0,  2, 11, 20, 25, 21, 17, 22, 18],
                    [0,  5,  1,  7, 16, 21, 21, 26, 22, 18],
                    [0,  1,  1, 12, 12, 17, 17, 22, 22, 27]
                ]
            ], [
                'CTGA',
                'GTTG',
                [
                    [0,  0,  0,  0,  0],
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
     * @dataProvider providerGetScoreMatrixForSubstitutionMatrixNucFourTwo
     * @test
     */
    public function testGetScoreMatrixForSubstitutionMatrixNucFourTwo(
        $query, $target, $expected
    ) {
        $smithWaterman = new SmithWaterman(
            new DnaSequence($query),
            new DnaSequence($target),
            new SimpleGapPenalty,
            $this->substitutionMatrix
        );

        $actual = $smithWaterman->getScoreMatrixAsArray();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function providerGetPairForSubstitutionMatrixNucFourTwo()
    {
        return [
            [
                'ACTGGCAGT', // query
                'CACTGAT', // target
                ['ACTGGCAGT', 'ACT--G-AT'] // expected
            ], [
                'CTGA',
                'GTTG',
                ['-TG', 'TTG']
            ]
        ];
    }

    /**
     * @return void
     *
     * @dataProvider providerGetPairForSubstitutionMatrixNucFourTwo
     * @test
     */
    public function testGetPairForSubstitutionMatrixNucFourTwo($query, $target, $expected)
    {
        $smithWaterman = new SmithWaterman(
            new DnaSequence($query),
            new DnaSequence($target),
            new SimpleGapPenalty,
            $this->substitutionMatrix
        );

        $actual = $smithWaterman->getPair();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function providerGetScoreForSubstitutionMatrixNucFourTwo()
    {
        return [
            [
                'ACTGGCAGT', // query
                'CACTGAT', // target
                27 // expected
            ], [
                'CTGA',
                'GTTG',
                15
            ]
        ];
    }

    /**
     * @return void
     *
     * @dataProvider providerGetScoreForSubstitutionMatrixNucFourTwo
     * @test
     */
    public function testGetScoreForSubstitutionMatrixNucFourTwo(
        $query, $target, $expected
    ) {
        $smithWaterman = new SmithWaterman(
            new DnaSequence($query),
            new DnaSequence($target),
            new SimpleGapPenalty,
            $this->substitutionMatrix
        );

        $actual = $smithWaterman->getScore();

        $this->assertEquals($expected, $actual);
    }

}
