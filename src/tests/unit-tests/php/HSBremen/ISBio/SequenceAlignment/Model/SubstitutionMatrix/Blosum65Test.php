<?php
/**
 * `Blosum65Test.php`
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
 * @package    Alignment
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix;

/**
 * Test class for {@link Blosum65}.
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 *
 * @covers     HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\Blosum65
 */
class Blosum65Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Blosum65
     */
    private $matrix;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->matrix = Blosum65::getInstance();
    }

    /**
     * @return void
     *
     * @covers HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\Blosum65::__construct
     * @test
     */
    public function testScores()
    {
        $expected = [
            [  4],
            [ -1,  6],
            [ -2,  0,  6],
            [ -2, -2,  1,  6],
            [  0, -4, -3, -4,  9],
            [ -1,  1,  0,  0, -3,  6],
            [ -1,  0,  0,  2, -4,  2,  5],
            [  0, -2, -1, -1, -3, -2, -2,  6],
            [ -2,  0,  1, -1, -3,  1,  0, -2,  8],
            [ -1, -3, -3, -3, -1, -3, -3, -4, -3,  4],
            [ -2, -2, -4, -4, -1, -2, -3, -4, -3,  2,  4],
            [ -1,  2,  0, -1, -3,  1,  1, -2, -1, -3, -3,  5],
            [ -1, -2, -2, -3, -2,  0, -2, -3, -2,  1,  2, -2,  6],
            [ -2, -3, -3, -4, -2, -3, -3, -3, -1,  0,  0, -3,  0,  6],
            [ -1, -2, -2, -2, -3, -1, -1, -2, -2, -3, -3, -1, -3, -4,  8],
            [  1, -1,  1,  0, -1,  0,  0,  0, -1, -2, -3,  0, -2, -2, -1,  4],
            [  0, -1,  0, -1, -1, -1, -1, -2, -2, -1, -1, -1, -1, -2, -1,  1,  5],
            [ -3, -3, -4, -5, -2, -2, -3, -3, -2, -2, -2, -3, -2,  1, -4, -3, -3, 10],
            [ -2, -2, -2, -3, -2, -2, -2, -3,  2, -1, -1, -2, -1,  3, -3, -2, -2,  2,  7],
            [  0, -3, -3, -3, -1, -2, -3, -3, -3,  3,  1, -2,  1, -1, -2, -2,  0, -3, -1,  4]
        ];

        $this->assertEquals($expected, $this->matrix->getScores());
    }

}