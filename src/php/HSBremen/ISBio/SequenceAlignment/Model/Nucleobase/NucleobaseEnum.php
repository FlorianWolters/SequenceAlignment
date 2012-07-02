<?php
/**
 * `NucleobaseEnum.php`
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
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Model\Nucleobase;

use \FlorianWolters\Component\Core\Enum\EnumAbstract;

/**
 * Enumerates all primary nucleobases that are common to DNA and RNA.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
class NucleobaseEnum extends EnumAbstract
{

    /**
     * The primary nucleobase *cytosine* (C).
     *
     * @return NucleobaseEnum The primary nucleobase *cytosine* (C).
     */
    final public static function CYTOSINE()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

    /**
     * The primary nucleobase *guanine* (G).
     *
     * @return NucleobaseEnum The primary nucleobase *guanine* (G).
     */
    final public static function GUANINE()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

    /**
     * The primary nucleobase *adenine* (A).
     *
     * @return NucleobaseEnum The primary nucleobase *adenine* (A).
     */
    final public static function ADENINE()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

}
