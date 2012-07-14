<?php
/**
 * `GapPenaltyInterface.php`
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
 * @subpackage GapPenalty
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Alignment\GapPenalty;

/**
 * Defines a data structure for the gap penalties used during a sequence
 * alignment routine.
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage GapPenalty
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Interface available since Release 0.1.0
 */
interface GapPenaltyInterface
{

    /**
     * Returns the penalty given when a deletion or insertion gap first opens.
     *
     * @return integer The gap open penalty.
     */
    public function getOpenPenalty();

    /**
     * Returns the penalty given when an already open gap elongates by a single
     * element.
     *
     * @return integer The gap extension penalty.
     */
    public function getExtensionPenalty();

}
