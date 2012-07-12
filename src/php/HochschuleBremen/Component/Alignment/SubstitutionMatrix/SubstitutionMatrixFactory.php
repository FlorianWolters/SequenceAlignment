<?php
/**
 * `SubstitutionMatrixFactory.php`
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
 * Constructs instances of substitution matrices.
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
class SubstitutionMatrixFactory
{

    /**
     * This class implements the *Singleton* creational design pattern.
     */
    use SingletonTrait;

    /**
     * Constructs and returns the substitution matrix for the specified type of
     * substitution matrix.
     *
     * @param SubstitutionMatrixEnum $type The type of the substitution matrix
     *                                     to create.
     *
     * @return SubstitutionMatrixAbstract The substitution matrix.
     * @throws InvalidArgumentException If the specified substitution matrix
     *                                  type is not supported.
     */
    public function create(SubstitutionMatrixEnum $type = null)
    {
        if (null === $type) {
            $type = AminoAcidSubstitutionMatrixEnum::BLOSUM62();
        }

        $enumClassName = \get_class($type);
        $namespace = \str_replace('SubstitutionMatrixEnum', '', $enumClassName);
        $matrixName = \ucwords(\strtolower($type->getName()));
        $className = $namespace . '\\' . $matrixName;

        if (false === \class_exists($className)) {
            throw new \InvalidArgumentException(
                "The substitution matrix of type {$type} is not supported."
            );
        }

        /* @var $result SubstitutionMatrixAbstract */
        $result = $className::getInstance();

        return $result;
    }

}
