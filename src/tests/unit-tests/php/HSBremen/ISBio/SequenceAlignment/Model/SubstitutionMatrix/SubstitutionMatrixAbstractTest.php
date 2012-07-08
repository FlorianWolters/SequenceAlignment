<?php
/**
 * `SubstitutionMatrixAbstractTest.php`
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
 * Test class for {@link SubstitutionMatrixAbstract}.
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
 * @covers     HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\SubstitutionMatrixAbstract
 */
class SubstitutionMatrixAbstractTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The object under test.
     *
     * @var SubstitutionMatrixAbstract
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
        // TODO
        // Invalid callback Mock_SubstitutionMatrixAbstract_5e885b47::__wakeup,
        // cannot access private method
        // Mock_SubstitutionMatrixAbstract_5e885b47::__wakeup()
        $this->markTestSkipped(
            'Bug in PHPUnit, since it does not set a private/protected method __wakup accessible.'
        );

        $className = __NAMESPACE__ . '\SubstitutionMatrixAbstract';
        $reflectedMethod = new \ReflectionMethod($className, '__wakeup');
        $reflectedMethod->setAccessible(true);

        $this->matrix = $this->getMockForAbstractClass(
            $className, [], '', false, false, true, ['getId', 'getScores']
        );
    }

    /**
     * @return void
     *
     * @covers HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\SubstitutionMatrixAbstract::getScores
     * @test
     */
    public function testGetScores()
    {
        $expected = [13];

        $this->matrix->expects($this->any())
             ->method('getScores')
             ->will($this->returnValue($expected));

        $actual = $this->matrix->getScores();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @covers HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\SubstitutionMatrixAbstract::getId
     * @test
     */
    public function testGetId()
    {
        $expected = 'BLOSUM62';

        $this->matrix->expects($this->any())
             ->method('getId')
             ->will($this->returnValue($expected));

        $actual = $this->matrix->getId();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @covers HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix\SubstitutionMatrixAbstract::getInstance
     * @test
     * @todo Implement comparison of getInstance().
     */
    public function testGetInstance()
    {
        $reflectedClass = new \ReflectionClass(
            __NAMESPACE__ . '\SubstitutionMatrixAbstract'
        );
        $this->assertFalse($reflectedClass->isInstantiable());
    }

}
