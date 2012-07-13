<?php
/**
 * `GapPenaltyType.php`
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
 * The {@link GapPenaltyType} class houses the logic for building the form for
 * class {@link GapPenalty}.
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
class GapPenaltyType extends AbstractType
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
        $openPenaltyValues = [100, 50, 25, 20, 15, 10, 5, 1];
        $openPenaltyChoices = \array_combine(
            $openPenaltyValues, $openPenaltyValues
        );
        $gapPenaltyValues = [
            '0.0005', '0.01', '0.05', '0.1', '0.2', '0.4',
            '0.5', '0.6', '0.8', '1.0', '5.0', '10.0'
        ];
        $gapPenaltyChoices = \array_combine(
            $gapPenaltyValues, $gapPenaltyValues
        );

        $builder->add(
            'openPenalty', 'choice', [
                'label' => 'Gap open penalty:',
                'choices' => $openPenaltyChoices,
                'preferred_choices' => [10]
            ]
        )->add(
            'extensionPenalty', 'choice', [
                'label' => 'Gap extend penalty:',
                'choices' => $gapPenaltyChoices,
                'preferred_choices' => ['0.5']
            ]
        );
    }

    /**
     * @return array
     */
    public function getDefaultOptions()
    {
        return [
            'data_class' =>
            'HochschuleBremen\Application\SequenceAlignment\Entity\GapPenalty'
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
        return 'gap_penalty';
    }

}
