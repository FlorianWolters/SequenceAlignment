<?php
/**
 * `AlignmentType.php`
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
 * @subpackage Form
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Application\SequenceAlignment\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The {@link AlignmentType} class houses the logic for building the form for
 * class {@link Alignment}.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Form
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
class AlignmentType extends AbstractType
{

    /**
     * Builds this form.
     *
     * @param FormBuilderInterface $builder The form builder.
     * @param array                $options The options for this form.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sequenceType = $options['sequence_type'];
        $sequenceTypeName = $sequenceType->getName();

        $builder->add(
            'query', $sequenceType, [
                'label' => "First {$sequenceTypeName} sequence (source):"
            ]
        )->add(
            'target', $sequenceType, [
                'label' => "Second {$sequenceTypeName} sequence (target):"
            ]
        )->add(
            'substitutionMatrixName', 'choice', [
                'label' => 'Substitution matrix:',
                'choices' => \array_combine(
                    $options['matrices'], $options['matrices']
                ), 'preferred_choices' => [$options['matrix_choice']]
            ]
        )->add(
            'gap_penalty', new GapPenaltyType, ['label' => 'Gap penalties:']
        );
    }

    /**
     * @return array
     */
    public function getDefaultOptions()
    {
        return [
            // Nice Symfony guys, just change that cascaded validation
            // behaviour... Cost me about an hour...
            // Ensure that the children forms of this form are validated to.
            'cascade_validation' => true,
            'sequence_type' => null,
            'matrices' => [],
            'matrix_choice' => '',
            'allowed_compounds' => []
        ];
    }

    /**
     * Returns the name of this form.
     *
     * This method returns a unique identifier for this form "type".
     *
     * @return string The name.
     */
    public function getName()
    {
        return 'alignment';
    }

}
