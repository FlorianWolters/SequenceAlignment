<?php
/**
 * `ScoringMatrixFactory.php`
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
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix;

use \FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * TODO
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
class ScoringMatrixFactory
{

    /**
     * This class implements the *Singleton* creation design pattern.
     */
    use SingletonTrait;

    /**
     * Constructs a new scoring matrix.
     *
     * @param ScoringMatrixEnum $type The type of the scoring matrix to create.
     *
     * @return ScoringMatrixAbstract The scoring matrix.
     * @throws InvalidArgumentException If the specified type is not supported.
     */
    public function create(ScoringMatrixEnum $type = null)
    {
        /* @var $result ScoringMatrixAbstract */
        $result = null;

        switch ($type) {
            case null:
                // Create a BLOSUM62 scoring matrix if no type is specified.
            case ScoringMatrixEnum::BLOSUM62();
                $result = Blosum62::getInstance();
                break;
            default:
                throw new \InvalidArgumentException;
        }

        return $result;
    }

}
