<?php
/**
 * `SequenceSelectionType.php`
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

use HochschuleBremen\Application\SequenceAlignment\Entity\SequenceSelection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The {@link SequenceSelectionType} class houses the logic for building the
 * form for class {@link SequenceSelectionEntity}.
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
class SequenceSelectionType extends AbstractType
{

    /**
     * Builds this form.
     *
     * @param FormBuilderInterface $builder The form builder.
     * @param array                $options The options for this form.
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'sequenceType', 'choice', [
                'label' => 'Type of sequences to align:',
                'empty_value' => 'Choose a type',
                'choices' => SequenceSelection::getSequenceTypes(),
            ]
        );
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
        return 'sequence_selection';
    }

}
