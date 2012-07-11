<?php
/**
 * `Blosum60Test.php`
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

namespace HochschuleBremen\Application\SequenceAlignment\Model\SubstitutionMatrix;

/**
 * Test class for {@link Blosum60}.
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
 * @covers     HochschuleBremen\Application\SequenceAlignment\Model\SubstitutionMatrix\Blosum60
 */
class Blosum60Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Blosum60
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
        $this->matrix = Blosum60::getInstance();
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Application\SequenceAlignment\Model\SubstitutionMatrix\Blosum60::__construct
     * @test
     */
    public function testScores()
    {
        $expected = [
            [  4],
            [ -1,  5],
            [ -1,  0,  6],
            [ -2, -1,  1,  6],
            [  0, -3, -2, -3,  9],
            [ -1,  1,  0,  0, -3,  5],
            [ -1,  0,  0,  2, -3,  2,  5],
            [  0, -2,  0, -1, -2, -2, -2,  6],
            [ -2,  0,  1, -1, -3,  1,  0, -2,  7],
            [ -1, -3, -3, -3, -1, -3, -3, -3, -3,  4],
            [ -1, -2, -3, -3, -1, -2, -3, -4, -3,  2,  4],
            [ -1,  2,  0, -1, -3,  1,  1, -1, -1, -3, -2,  4],
            [ -1, -1, -2, -3, -1,  0, -2, -2, -1,  1,  2, -1,  5],
            [ -2, -3, -3, -3, -2, -3, -3, -3, -1,  0,  0, -3,  0,  6],
            [ -1, -2, -2, -1, -3, -1, -1, -2, -2, -3, -3, -1, -2, -4,  7],
            [  1, -1,  1,  0, -1,  0,  0,  0, -1, -2, -2,  0, -1, -2, -1,  4],
            [  0, -1,  0, -1, -1, -1, -1, -2, -2, -1, -1, -1, -1, -2, -1,  1,  4],
            [ -3, -3, -4, -4, -2, -2, -3, -2, -2, -2, -2, -3, -1,  1, -4, -3, -2, 10],
            [ -2, -2, -2, -3, -2, -1, -2, -3,  2, -1, -1, -2, -1,  3, -3, -2, -2,  2,  6],
            [  0, -2, -3, -3, -1, -2, -2, -3, -3,  3,  1, -2,  1, -1, -2, -2,  0, -3, -1,  4]
        ];

        $this->assertEquals($expected, $this->matrix->getScores());
    }

}
