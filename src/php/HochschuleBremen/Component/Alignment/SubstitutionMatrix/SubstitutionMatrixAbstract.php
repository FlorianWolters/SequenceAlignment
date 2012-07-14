<?php
/**
 * `SubstitutionMatrixAbstract.php`
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
 * @subpackage SubstitutionMatrix
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Alignment\SubstitutionMatrix;

use \FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * An object of class SubstitutionMatrixAbstract wraps a substitution matrix
 * into an object.
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage SubstitutionMatrix
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
abstract class SubstitutionMatrixAbstract
{

    /**
     * This class implements the *Singleton* creational design pattern.
     */
    use SingletonTrait;

    /**
     * The scores of this substitution matrix.
     *
     * @var array
     */
    private $matrix;

    /**
     * The name of this substitution matrix.
     *
     * @var string
     */
    private $name;

    /**
     * Constructs a new substitution matrix with the specified scores and the
     * optionally specified identifier.
     *
     * @param array  $scores The scores of the substitution matrix.
     * @param string $name   The name of the substitution matrix.
     */
    protected function __construct(array $scores, $name = null)
    {
        $this->setMatrix($scores);
        $this->setName($name);
    }

    /**
     * Sets the scores of this substitution matrix.
     *
     * @param array $scores The scores to set.
     *
     * @return void
     */
    private function setMatrix(array $scores)
    {
        if (false === is_array($scores)) {
            throw new \InvalidArgumentException;
        }

        $this->matrix = $scores;
    }

    /**
     * Sets the name of this substitution matrix.
     *
     * @param string $name The name.
     *
     * @return void
     */
    private function setName($name)
    {
        if (null === $name) {
            $fullClassName = \get_called_class();
            $pos = \strrpos($fullClassName, '\\', 0);
            $className = \substr($fullClassName, $pos + 1);
            $name = \strtoupper($className);
        }

        $this->name = $name;
    }

    /**
     * Returns the entire substitution matrix.
     *
     * @return array The matrix.
     */
    public function getMatrix()
    {
        return $this->matrix;
    }

    /**
     * Returns the name of this substitution matrix.
     *
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value in this substitution matrix for conversion from the
     * first specified compound to the second specified compound.
     *
     * @param string $from The original compound.
     * @param string $to   The replacement compound.
     *
     * @return integer The value in this substitution matrix for conversion from
     *                 the first compund to the second compound.
     *
     * @throws OutOfBoundsException If the specified original compound does not
     *                              exist in this substitution matrix.
     * @throws OutOfBoundsException If the specified replacement compound does
     *                              not exist in this substitution matrix.
     */
    public function getValue($from, $to)
    {
        $row = $this->returnRowForOriginalCompound($from);
        $column = $this->returnColumnForReplacementCompound($to);

        return $this->matrix[$row][$column];
    }

    /**
     * Returns the row index of the specified original compound from this
     * substitution matrix.
     *
     * @param string $compound The original compound.
     *
     * @return integer The row index.
     *
     * @throws OutOfBoundsException If the specified original compound does not
     *                              exist in this substitution matrix.
     */
    private function returnRowForOriginalCompound($compound)
    {
        $result = \array_search($compound, $this->matrix[0], true);
        if (false === $result) {
            throw new \OutOfBoundsException(
                'The original compound ' . $compound
                    . ' does not exist in the substitution matrix.'
            );
        }

        return $result;
    }

    /**
     * Returns the column index of the specified replacement compound from this
     * substitution matrix.
     *
     * @param string $compound The replacement compound.
     *
     * @return integer The column index.
     *
     * @throws OutOfBoundsException If the specified replacement compound does
     *                              not exist in this substitution matrix.
     */
    private function returnColumnForReplacementCompound($compound)
    {
        $result = false;

        for ($i = 0; $i < count($this->matrix); ++$i) {
            if ($compound === $this->matrix[$i][0]) {
                $result = $i;
                break;
            }
        }

        if (false === $result) {
            throw new \OutOfBoundsException(
                'The replacement compound ' . $compound
                    . ' does not exist in the substitution matrix.'
            );
        }

        return $result;
    }

}
