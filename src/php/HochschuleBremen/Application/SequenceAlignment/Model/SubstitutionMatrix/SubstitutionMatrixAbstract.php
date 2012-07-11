<?php
/**
 * `SubstitutionMatrixAbstract.php`
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
 * @subpackage Model
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Model\SubstitutionMatrix;

use \FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * An object of class SubstitutionMatrixAbstract wraps a substitution matrix
 * into an object.
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
abstract class SubstitutionMatrixAbstract
{

    /**
     * This class implements the *Singleton* creational design pattern.
     */
    use SingletonTrait;

    /**
     * The scores of this substitution matrix.
     *
     * @var array
     */
    private $scores;

    /**
     * The identifier of this substitution matrix.
     *
     * @var string
     */
    private $id;

    /**
     * Constructs a new substitution matrix with the specified scores and the
     * optionally specified identifier.
     *
     * This constructor is *package-private*.
     *
     * @param array  $scores The scores of the substitution matrix.
     * @param string $id     The identifier of the substitution matrix.
     */
    protected function __construct(array $scores, $id = null)
    {
        $this->setScores($scores);
        $this->setId($id);
    }

    /**
     * Sets the scores of this substitution matrix.
     *
     * @param array $scores The scores to set.
     *
     * @return void
     */
    private function setScores(array $scores)
    {
        if (!is_array($scores)) {
            throw new \InvalidArgumentException;
        }

        $this->scores = $scores;
    }

    /**
     * Sets the identifier of this substitution matrix.
     *
     * @param string $id The identifier to set.
     *
     * @return void
     */
    private function setId($id)
    {
        if (null === $id) {
            $id = \get_called_class();
            $id = \strtoupper($id);
        }

        $this->id = $id;
    }

    /**
     * Returns the scores of this substitution matrix.
     *
     * @return array The scores.
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * Returns the identifier of this substitution matrix.
     *
     * @return string The identifier.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the score from a specified row and a specified column of this
     * substitution matrix.
     *
     * @param integer $row    The row.
     * @param integer $column The column.
     *
     * @return integer The score.
     *
     * @throws OutOfBoundsException If the cell with the specified row and the
     *                              specified column does not exist.
     */
    public function getScore($row, $column)
    {
        if (false === isset($this->scores[$row][$column])) {
            throw new \OutOfBoundsException(
                'A cell with the specified row ' . $row
                . ' and the specified column ' . $column. ' does not exist.'
            );
        }

        return $this->scores[$row][$column];
    }

}
