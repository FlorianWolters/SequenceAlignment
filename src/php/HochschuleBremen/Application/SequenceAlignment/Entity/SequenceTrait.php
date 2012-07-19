<?php
/**
 * `SequenceTrait.php`
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

use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Implements default behavior for {@link DnaSequence}, {@link RnaSequence} and
 * {@link ProteinSequence}.
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
trait SequenceTrait
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
        $metadata->addGetterConstraint('sequenceStr', new NotBlank);
        $metadata->addGetterConstraint('sequenceStr', new Type('string'));
        $metadata->addConstraint(
            new Callback(
                ['methods' => ['isSequenceStrValid']]
            )
        );
    }

    /**
     * Checks whether the sequence string of this sequence is valid.
     *
     * @param ExecutionContext $context The execution context.
     */
    public function isSequenceStrValid(ExecutionContext $context)
    {
        $sequenceStr = $this->getSequenceStr();
        if (false === $this->validateSequenceStr($sequenceStr)) {
            $context->addViolation('The sequence string is invalid.');
        }
    }

    /**
     * Sets the sequence string of this sequence.
     *
     * @param string $sequenceStr The sequence string.
     */
    public function setSequenceStr($sequenceStr)
    {
        parent::setSequenceStr($sequenceStr);
    }

}
