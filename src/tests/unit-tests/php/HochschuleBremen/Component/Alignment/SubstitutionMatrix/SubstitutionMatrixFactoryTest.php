<?php
/**
 * `SubstitutionMatrixFactoryTest.php`
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
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Alignment\SubstitutionMatrix;

/**
 * Test class for {@link SubstitutionMatrixFactory}.
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
 * @covers     HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory
 */
class SubstitutionMatrixFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The object under test.
     *
     * @var SubstitutionMatrixFactory
     */
    private $factory;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp() {
        $this->factory = SubstitutionMatrixFactory::getInstance();
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory::create
     */
    public function testCreateReturnsCorrectInstance() {
        $expected = 'HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixAbstract';
        $this->assertInstanceOf($expected, $this->factory->create());
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory::create
     */
    public function testCreateReturnsBlosum62AsDefault() {
        $expected = 'HochschuleBremen\Component\Alignment\SubstitutionMatrix\AminoAcid\Blosum62';
        $this->assertInstanceOf($expected, $this->factory->create());
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory::create
     * @expectedException InvalidArgumentException
     */
    public function testCreateThrowsInvalidArgumentException() {
        $this->factory->create(SubstitutionMatrixEnumMock::UNKNOWN());
    }

    /**
     * @return void
     *
     * @covers HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory::getInstance
     */
    public function testGetInstance()
    {
        $reflectedClass = new \ReflectionClass(
            __NAMESPACE__ . '\SubstitutionMatrixFactory'
        );
        $this->assertFalse($reflectedClass->isInstantiable());

        $this->assertEquals(
            $this->factory, SubstitutionMatrixFactory::getInstance()
        );
    }

}
