<?php
/**
 * `SequenceSelection.php`
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

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Choice;

/**
 * An object of type {@link SequenceSelectionEntity} stores the selection for
 * the type of sequence to align.
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
 */
class SequenceSelection
{

    /**
     * The type of sequence.
     *
     * @var string
     */
    private $sequenceType;

    /**
     * Adds the constraints for this class.
     *
     * @param ClassMetadata $metadata The constraints on this class.
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraint('sequenceType', new NotBlank);
        $metadata->addGetterConstraint(
            'sequenceType',
            new Choice(
                [
                    'choices' => ['dna', 'rna', 'amino_acid'],
                    'message' => 'Choose a valid sequence type',
                ]
            )
        );
    }

    /**
     * Returns the type of the sequence.
     *
     * @return string The type of the sequence.
     */
    public function getSequenceType()
    {
        return $this->sequenceType;
    }

    /**
     * Sets the type of the sequence.
     *
     * @param string $sequenceType The type of the sequence.
     *
     * @return void
     */
    public function setSequenceType($sequenceType)
    {
        $this->sequenceType = $sequenceType;
    }

    /**
     * Returns an associative array of the sequence types to select.
     *
     * Each key of the array is the value of the selection and each value of the
     * array is the label of the selection.
     *
     * @return array The selectable sequence types.
     */
    public static function getSequenceTypes()
    {
        return [
            'dna' => 'DNA (Deoxyribonucleic acid)',
            'rna' => 'RNA (Ribonucleic acid)',
            'amino_acid' => 'Amino acid'
        ];
    }

}
