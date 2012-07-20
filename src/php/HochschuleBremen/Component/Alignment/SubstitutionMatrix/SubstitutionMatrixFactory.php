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

use FlorianWolters\Component\Util\Singleton\SingletonTrait;

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
     * @param SubstitutionMatrixTypeEnum $type The type of the substitution
     *                                         matrix to create.
     *
     * @return SubstitutionMatrixAbstract The substitution matrix.
     * @throws InvalidArgumentException If the specified substitution matrix
     *                                  type is not supported.
     */
    public function create(SubstitutionMatrixTypeEnum $type = null)
    {
        if (null === $type) {
            $type = AminoAcidSubstitutionMatrixTypeEnum::BLOSUM62();
        }

        /* @var $result SubstitutionMatrixAbstract */
        $result = null;

        if ($type instanceof AminoAcidSubstitutionMatrixTypeEnum) {
            $result = $this->createAminoAcidSubstitutionMatrix($type);
        } else if ($type instanceof NucleotideSubstitutionMatrixTypeEnum) {
            $result = $this->createNucleotideSubstitutionMatrix($type);
        } else {
             throw new \InvalidArgumentException(
                'The substitution matrix type '
                 . $type . ' is not supported.'
            );
        }

        return $result;
    }

    /**
     * Constructs and returns the amino acid substitution matrix for the
     * specified type of substitution matrix.
     *
     * @param SubstitutionMatrixTypeEnum $type The type of the amino acid
     *                                         substitution matrix to create.
     *
     * @return SubstitutionMatrixAbstract The amino acid substitution matrix.
     * @throws InvalidArgumentException If the specified amino acid substitution
     *                                  matrix type is not supported.
     */
    public function createAminoAcidSubstitutionMatrix(
        SubstitutionMatrixTypeEnum $type
    ) {
        /* @var $result SubstitutionMatrixAbstract */
        $result = null;

        switch ($type) {
            case AminoAcidSubstitutionMatrixTypeEnum::BLOSUM60():
                $result = AminoAcid\Blosum60::getInstance();
                break;
            case AminoAcidSubstitutionMatrixTypeEnum::BLOSUM62():
                $result = AminoAcid\Blosum62::getInstance();
                break;
            case AminoAcidSubstitutionMatrixTypeEnum::BLOSUM65():
                $result = AminoAcid\Blosum65::getInstance();
                break;
            default:
                throw new \InvalidArgumentException(
                    'The amino acid substitution matrix of type '
                    . $type . ' is not supported.'
                );
                break;

        }

        return $result;
    }

    /**
     * Constructs and returns the nucleotide substitution matrix for the
     * specified type of substitution matrix.
     *
     * @param SubstitutionMatrixTypeEnum $type The type of the nucleotide
     *                                         substitution matrix to create.
     *
     * @return SubstitutionMatrixAbstract The nucleotide substitution matrix.
     * @throws InvalidArgumentException If the specified nucleotide substitution
     *                                  matrix type is not supported.
     */
    public function createNucleotideSubstitutionMatrix(
        SubstitutionMatrixTypeEnum $type
    ) {
        /* @var $result SubstitutionMatrixAbstract */
        $result = null;

        switch ($type) {
            case NucleotideSubstitutionMatrixTypeEnum::NUCFOURFOUR():
                $result = Nucleotide\NucFourFour::getInstance();
                break;
            case NucleotideSubstitutionMatrixTypeEnum::NUCFOURTWO():
                $result = Nucleotide\NucFourTwo::getInstance();
                break;
            default:
                throw new \InvalidArgumentException(
                    'The nucleotide substitution matrix of type '
                    . $type . ' is not supported.'
                );
                break;
        }

        return $result;
    }

}
