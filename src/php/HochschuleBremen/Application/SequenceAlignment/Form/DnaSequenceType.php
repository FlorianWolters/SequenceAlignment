<?php
/**
 * `DnaSequenceType.php`
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

/**
 * The {@link DnaSequenceType} class houses the logic for building the form for
 * class {@link DnaSequence}.
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
class DnaSequenceType extends SequenceTypeAbstract
{

    /**
     * Returns the default options for this type.
     *
     * {@inheritdoc}
     *
     * @return array The default options
     */
    public function getDefaultOptions()
    {
        return [
            'data_class' => 'HochschuleBremen\Application\SequenceAlignment\Entity\DnaSequence'
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
        return 'DNA';
    }

}
