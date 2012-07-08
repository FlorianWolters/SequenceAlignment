<?php
/**
 * `SmithWatermanType.php`
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
 * @package    SequenceAlignment
 * @subpackage Form
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The {@link SmithWatermanType} class houses the logic for building the form
 * for class {@link SmithWatermanEntity}.
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
class SmithWatermanType extends AbstractType
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
            'firstSequence', 'text', array(
                'label' => 'First sequence (horizontal):'
            )
        )->add(
            'secondSequence', 'text', array(
                'label' => 'Second sequence (vertical):'
            )
        );
    }

    /**
     * Returns the default options for this form.
     *
     * @param array $options The options for this form.
     *
     * @return array The default options.
     */
    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'HSBremen\ISBio\SequenceAlignment\Entity\SmithWatermanEntity',
            'display_custom_field' => false,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => $this->getName()
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
        return 'smithwaterman';
    }

}
