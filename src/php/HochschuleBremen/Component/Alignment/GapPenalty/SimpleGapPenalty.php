<?php
/**
 * `SimpleGapPenalty.php`
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
 * Implements a data structure for the gap penalties used during a sequence
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
class SimpleGapPenalty implements GapPenaltyInterface
{

    /**
     * The penalty given when a deletion or insertion gap first opens.
     *
     * @var float
     */
    private $openPenalty;

    /**
     * The penalty given when an already open gap elongates by a single element.
     *
     * @var float
     */
    private $extensionPenalty;

    /**
     * Creates a new set of gap penalties.
     *
     * @param float $openPenalty      The gap open penalty.
     * @param float $extensionPenalty The gap extension penalty.
     */
    public function __construct($openPenalty = 10, $extensionPenalty = 0.5)
    {
        $this->setOpenPenalty($openPenalty);
        $this->setExtensionPenalty($extensionPenalty);
    }

    /**
     * Sets the penalty given when a deletion or insertion gap first opens.
     *
     * @param float $openPenalty The gap open penalty.
     *
     * @return void
     */
    protected function setOpenPenalty($openPenalty)
    {
        $this->openPenalty = $openPenalty;
    }

    /**
     * Sets the penalty given when an already open gap elongates by a single
     * element.
     *
     * @param float $extensionPenalty The gap extension penalty.
     *
     * @return void
     */
    protected function setExtensionPenalty($extensionPenalty)
    {
        $this->extensionPenalty = $extensionPenalty;
    }

    /**
     * Returns the penalty given when a deletion or insertion gap first opens.
     *
     * @return float The gap open penalty.
     */
    public function getOpenPenalty()
    {
        return $this->openPenalty;
    }

    /**
     * Returns the penalty given when an already open gap elongates by a single
     * element.
     *
     * @return float The gap extension penalty.
     */
    public function getExtensionPenalty()
    {
        return $this->extensionPenalty;
    }

}
