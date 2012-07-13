<?php
/**
 * `GapPenaltyTest.php`
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
 * @package    SequenceAlignment
 * @subpackage Entity
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Application\SequenceAlignment\Entity;

use Symfony\Component\Validator\ValidatorFactory;

/**
 * Test class for GapPenalty.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Entity
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 *
 * @covers     HochschuleBremen\Application\SequenceAlignment\Entity\GapPenalty
 */
class GapPenaltyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The object under test.
     *
     * @var GapPenalty
     */
    private $object;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object = new GapPenalty;
    }

    /**
     * @return array
     */
    public static function providerTestValidation()
    {
        return [
            [0, new GapPenalty], // default values
            [0, new GapPenalty(1, 0.005)], // minimum values
            [0, new GapPenalty(100, 10.0)], // maximum values
            [1, new GapPenalty(null, 0.1)], // gap open penalty invalid
            [1, new GapPenalty(10, null)], // gap extend penalty invalid
            [2, new GapPenalty(null, null)], // both invalid
            [2, new GapPenalty(0, 0)],
            [2, new GapPenalty(-1, -1)],
            [6, new GapPenalty('foo', 'bar')]
        ];
    }

    /**
     * @return void
     *
     * @dataProvider providerTestValidation
     * @test
     */
    public function testValidation($expected, GapPenalty $bbject)
    {
        $validator = ValidatorFactory::buildDefault(
            [], false, 'loadValidatorMetadata'
        )->getValidator();
        $errors = $validator->validate($bbject);
        $actual = count($errors);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Application\SequenceAlignment\Entity\GapPenalty::setExtensionPenalty
     * @test
     */
    public function testSetExtensionPenalty()
    {
        $penalty = 0.75;
        $this->object->setExtensionPenalty($penalty);
        $this->assertEquals($penalty, $this->object->getExtensionPenalty());
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Application\SequenceAlignment\Entity\GapPenalty::setOpenPenalty
     * @test
     */
    public function testSetOpenPenalty()
    {
        $penalty = 13;
        $this->object->setOpenPenalty($penalty);
        $this->assertEquals($penalty, $this->object->getOpenPenalty());
    }

}
