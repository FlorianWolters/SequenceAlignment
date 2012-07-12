<?php
/**
 * `Alignment.php`
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
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * An object of type {@link Alignment} represents and stores the data for
 * a pairwise sequence alignment with amino acid sequences.
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
class Alignment
{

    /**
     * The first sequence of the pair to align.
     *
     * @var string
     */
    private $query;

    /**
     * The second sequence of the pair to align.
     *
     * @var string
     */
    private $target;

	/**
	 * The gap penalties used during alignment.
     *
     * @var GapPenalty
	 */
    private $gapPenalty;

	/**
     * The name of the substitution matrix to use during alignment.
     *
     * @var string
	 */
    private $substitutionMatrixName;

    /**
     * Adds the constraints for this class.
     *
     * @param ClassMetadata $metadata The constraints on this class.
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        self::addGetterConstraintsToSequences($metadata, 'query');
        self::addGetterConstraintsToSequences($metadata, 'target');
        $metadata->addConstraint(
            new Callback(
                ['methods' => ['isQueryValid', 'isTargetValid']]
            )
        );
    }

    /**
     * @param ClassMetadata $metadata The constraints on this class.
     * @param string        $name
     *
     * @return void
     */
    private static function addGetterConstraintsToSequences(
        ClassMetadata $metadata, $name
    ) {
        $metadata->addGetterConstraint($name, new NotBlank);
        $metadata->addGetterConstraint($name, new Type('string'));
    }

    // TODO Validate input in dependency of the chosed sequence type.

    public function isQueryValid(ExecutionContext $context)
    {
        $query = $this->getQuery();
        if (1 !== \preg_match('/^[arndcqeghilkmfpstwyv]+$/i', $query)) {
            $context->addViolation('The first sequence is invalid.');
        }
    }

    public function isTargetValid(ExecutionContext $context)
    {
        $query = $this->getTarget();
        if (1 !== \preg_match('/^[arndcqeghilkmfpstwyv]+$/i', $query)) {
            $context->addViolation('The second sequence is invalid.');
        }
    }

    /**
     * Constructs a new Alignment.
     */
    public function __construct(GapPenalty $gapPenalty = null)
    {
        $this->gapPenalty = (null === $gapPenalty)
            ? new GapPenalty
            : $gapPenalty;
    }

    /**
     * Returns the query sequence.
     *
     * @return string The first sequence of the pair to align.
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Sets the query sequence.
     *
     * @param string $query The first sequence of the pair to align.
     *
     * @return void
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Returns the target sequence.
     *
     * @return string The second sequence of the pair to align.
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets the target sequence.
     *
     * @param string $target The second sequence of the pair to align.
     *
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Returns the gap penalties.
     *
     * @return GapPenalty The gap penalties used during alignment.
     */
    public function getGapPenalty()
    {
        return $this->gapPenalty;
    }

    /**
     * Sets the gap penalties.
     *
     * @param GapPenalty $gapPenalty The gap penalties used during alignment.
     */
    public function setGapPenalty(GapPenalty $gapPenalty)
    {
        $this->gapPenalty = $gapPenalty;
    }

    /**
	 * Returns the name of the substitution matrix.
     *
     * @return string The name of the substitution matrix to use during
     *                alignment.
	 */
    public function getSubstitutionMatrixName()
    {
        return $this->substitutionMatrixName;
    }

    /**
	 * Sets the name of the substitution matrix.
     *
     * @param string $substitutionMatrixSelection The name of the substitution
     *                                            matrix to use during
     *                                            alignment.
     *
     * @return void
	 */
    public function setSubstitutionMatrixName($substitutionMatrixSelection)
    {
        $this->substitutionMatrixName = $substitutionMatrixSelection;
    }

}
