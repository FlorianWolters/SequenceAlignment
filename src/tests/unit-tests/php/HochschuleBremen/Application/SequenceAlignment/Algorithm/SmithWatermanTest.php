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
 * @author     Steffen Schütte <steffen.schuette@web.de>
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Steffen Schütte, Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Application\SequenceAlignment\Algorithm;

/**
 * Test class for {@link SmithWaterman}.
 *
 * @category   Biology
 * @package    SmithWaterman
 * @subpackage Algorithm
 * @author     Steffen Schütte <steffen.schuette@web.de>
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Steffen Schütte, Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 *
 * @covers     HochschuleBremen\Application\SequenceAlignment\Algorithm\SmithWaterman
 */
class SmithWatermanTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return array
     */
    public static function providerGetScoreTable()
    {
        return [
            [
                'ACACACTA', // firstSequence
                'AGCACACA', // secondSequence
                [
                    [0, 0, 0, 0, 0, 0, 0, 0, 0], // expected
                    [0, 1, 0, 1, 0, 1, 0, 0, 1],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 1, 0, 1, 0, 1, 0, 0],
                    [0, 1, 0, 2, 1, 2, 1, 0, 1],
                    [0, 0, 2, 1, 3, 2, 3, 2, 1],
                    [0, 1, 1, 3, 2, 4, 3, 2, 3],
                    [0, 0, 2, 2, 4, 3, 5, 4, 3],
                    [0, 1, 1, 3, 3, 5, 4, 4, 5]
                ]
            ], [
                'ACTTGGAAGT',
                'GTGAGACT',
                [
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0],
                    [0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 2],
                    [0, 0, 0, 0, 0, 2, 1, 0, 0, 1, 1],
                    [0, 1, 0, 0, 0, 1, 1, 2, 1, 0, 0],
                    [0, 0, 0, 0, 0, 1, 2, 1, 1, 2, 1],
                    [0, 1, 0, 0, 0, 0, 1, 3, 2, 1, 1],
                    [0, 0, 2, 1, 0, 0, 0, 2, 2, 1, 0],
                    [0, 0, 1, 3, 2, 1, 0, 1, 1, 1, 2]
                ]
            ]
        ];
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Application\SequenceAlignment\Algorithm\SmithWaterman::getScoreTable
     * @dataProvider providerGetScoreTable
     * @test
     */
    public function testGetScoreTable(
        $firstSequence, $secondSequence, $expected
    ) {
        $smithWaterman = new SmithWaterman($firstSequence, $secondSequence);
        $actual = $smithWaterman->getScoreTable();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function providerGetAlignment()
    {
        return [
            // firstSequence, secondSequence, expected
            ['ACACACTA', 'AGCACACA', ['CACAC', 'CACAC']],
            ['ACTTGGAAGT', 'GTGAGACT', ['TG-GA', 'TGAGA']]
        ];
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Application\SequenceAlignment\Algorithm\SequenceAlignment::getAlignment
     * @dataProvider providerGetAlignment
     * @test
     */
    public function testGetAlignment($firstSequence, $secondSequence, $expected)
    {
        $smithWaterman = new SmithWaterman($firstSequence, $secondSequence);
        $actual = $smithWaterman->getAlignment();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function providerGetAlignmentScore()
    {
        return [
            // firstSequence, secondSequence, expected
            ['ACACACTA', 'AGCACACA', 5],
            ['ACTTGGAAGT', 'GTGAGACT', 3]
        ];
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Application\SequenceAlignment\Algorithm\SmithWaterman::getAlignmentScore
     * @dataProvider providerGetAlignmentScore
     * @test
     */
    public function testGetAlignmentScore(
        $firstSequence, $secondSequence, $expected
    ) {
        $smithWaterman = new SmithWaterman($firstSequence, $secondSequence);
        $actual = $smithWaterman->getAlignmentScore();

        $this->assertEquals($expected, $actual);
    }

}
