<?php
/**
 * `ScoringMatrixAbstract.php`
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

declare(encoding = 'UTF-8');

namespace HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix;

use \FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * TODO: Add short class comment.
 *
 * TODO: Add long class comment.
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
class ScoringMatrixAbstract
{

    /**
     * This class implements the *Singleton* creation design pattern.
     */
    use SingletonTrait;

    /**
     * The substitution matrix.
     *
     * @var array
     */
    private $matrix;

    /**
     * Returns the substitution matrix.
     *
     * @param array $matrix The substitution matrix to set.
     *
     * @return void
     */
    protected function setMatrix(array $matrix)
    {
        if (!is_array($matrix)) {
            throw new \InvalidArgumentException;
        }

        $this->matrix = $matrix;
    }

    /**
     * Returns the substitution matrix.
     *
     * @return array The substitution matrix.
     */
    public function getMatrix()
    {
        return $this->matrix;
    }

}
