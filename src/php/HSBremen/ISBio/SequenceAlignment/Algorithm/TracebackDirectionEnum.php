<?php
/**
 * `TracebackDirectionEnum.php`
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
 * @subpackage Algorithm
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Algorithm;

use \FlorianWolters\Component\Core\Enum\EnumAbstract;

/**
 * Enumerates all traceback directions.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Algorithm
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
final class TracebackDirectionEnum
{

    /**
	 * The traceback direction stop.
     *
     * @return TracebackDirectionEnum The traceback direction stop.
	 */
	final public static function STOP()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

    /**
	 * The traceback direction left.
     *
     * @return TracebackDirectionEnum The traceback direction left.
	 */
	final public static function LEFT()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

    /**
	 * The traceback direction diagonal.
     *
     * @return TracebackDirectionEnum The traceback direction diagonal.
	 */
	final public static function DIAGONAL()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

    /**
	 * The traceback direction up.
     *
     * @return TracebackDirectionEnum The traceback direction up.
	 */
	final public static function UP()
    {
        return self::getConstant(__CLASS__, __FUNCTION__);
    }

}
