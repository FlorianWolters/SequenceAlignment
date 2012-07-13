<?php
/**
 * `GapPenalty.php`
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
 * @subpackage Entity
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Application\SequenceAlignment\Entity;

use HochschuleBremen\Component\Alignment\GapPenalty\SimpleGapPenalty;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Min;
use Symfony\Component\Validator\Constraints\Max;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * An object of class GapPenalty represents and stores the data for the gap
 * penalties used during alignment.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Entity
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
class GapPenalty extends SimpleGapPenalty
{

    /**
     * Adds the constraints for this class.
     *
     * @param ClassMetadata $metadata The constraints on this class.
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraint('openPenalty', new NotBlank);
        $metadata->addGetterConstraint('openPenalty', new Min(1));
        $metadata->addGetterConstraint('openPenalty', new Max(100));
        $metadata->addGetterConstraint('openPenalty', new Type('integer'));
        $metadata->addGetterConstraint('extensionPenalty', new NotBlank);
        $metadata->addGetterConstraint('extensionPenalty', new Type('numeric'));
        $metadata->addGetterConstraint('extensionPenalty', new Min(0.0005));
        $metadata->addGetterConstraint('extensionPenalty', new Max(10.0));
    }

    /**
     * Sets the penalty given when a deletion or insertion gap first opens.
     *
     * @param float $openPenalty The gap open penalty.
     *
     * @return void
     */
    public function setOpenPenalty($openPenalty)
    {
        parent::setOpenPenalty($openPenalty);
    }

    /**
     * Sets the penalty given when an already open gap elongates by a single
     * element.
     *
     * @param float $extensionPenalty The gap extension penalty.
     *
     * @return void
     */
    public function setExtensionPenalty($extensionPenalty)
    {
        parent::setExtensionPenalty($extensionPenalty);
    }

}
