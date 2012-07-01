<?php
/**
 * `ScoringMatrixFactoryTest.php`
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

declare(encoding = 'UTF-8');

namespace HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix;

/**
 * Test class for {@link ScoringMatrixFactory}.
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
 */
class ScoringMatrixFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The object under test.
     *
     * @var ScoringMatrixFactory
     */
    protected $object;

    /**
     * Sets up the fixture, for example.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp() {
        $this->object = ScoringMatrixFactory::getInstance();
    }

    /**
     * @return void
     */
    public function testClassImplementsSingleton() {
        $reflectedClass = new \ReflectionClass(
            __NAMESPACE__ . '\ScoringMatrixFactory'
        );
        $this->assertFalse($reflectedClass->isInstantiable());
        $this->assertTrue($reflectedClass->hasMethod('getInstance'));
    }

    /**
     * @return void
     *
     * @covers HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix\ScoringMatrixFactory::create
     */
    public function testCreateReturnsCorrectInstance() {
        $expected = 'HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix\ScoringMatrixAbstract';
        $this->assertInstanceOf($expected, $this->object->create());
    }

    /**
     * @return void
     *
     * @covers HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix\ScoringMatrixFactory::create
     */
    public function testCreateReturnsBlosum62AsDefault() {
        $expected = 'HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix\Blosum62';
        $this->assertInstanceOf($expected, $this->object->create());
    }

}
