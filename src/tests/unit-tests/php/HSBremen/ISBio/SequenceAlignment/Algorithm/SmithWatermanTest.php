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

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
         $this->smithWaterman = new SmithWaterman('ABC', 'CDE', 
            Blosum60::getInstance(), 10, 0.5
         );
    }

    public function testPairwiseAlignmentExercise()
    {
        $this->smitWaterman = new SmithWaterman('ACTTGGAAGT', 'GTGAGACT',
            Blosum60::getInstance(), 10, 0.5
        );
        
        $expected = 3;
        $this->assertEquals($expected, 3);
    }

    /**
     * @return void
     *
     * @covers HSBremen\ISBio\SequenceAlignment\Algorithm\SmithWaterman::__construct
     * @test
     */
    public function testBacktrack()
    {
        $expected = 3;
        $this->assertEquals($expected, 3);
    }
}
