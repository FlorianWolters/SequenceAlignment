<?php
/**
 * `SubstitutionMatrixEnum.php`
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
 * @package    Alignment
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix;

use \FlorianWolters\Component\Core\Enum\EnumAbstract;

/**
 * Enumerates substitution matrices.
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
class SubstitutionMatrixEnum extends EnumAbstract
{

    /**
     * The BLOcks of Amino Acid SUbstitution Matrix number 60 (BLOSUM62).
     *
     * @return SubstitutionMatrixEnum The BLOSUM60.
     */
    final public static function BLOSUM60()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

    /**
     * The BLOcks of Amino Acid SUbstitution Matrix number 62 (BLOSUM62).
     *
     * @return SubstitutionMatrixEnum The BLOSUM62.
     */
    final public static function BLOSUM62()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

    /**
     * The BLOcks of Amino Acid SUbstitution Matrix number 65 (BLOSUM65).
     *
     * @return SubstitutionMatrixEnum The BLOSUM65.
     */
    final public static function BLOSUM65()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

}
