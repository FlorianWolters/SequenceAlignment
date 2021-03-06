<?php
/**
 * `Blosum65.php`
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
 * @subpackage SubstitutionMatrix
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Alignment\SubstitutionMatrix\AminoAcid;

use HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixAbstract;

/**
 * An object of class Blosum65 wraps the BLOcks of Amino Acid SUbstitution
 * Matrix number 65 (BLOSUM65) into an object.
 *
 * @category   Biology
 * @package    Alignment
 * @subpackage SubstitutionMatrix
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
class Blosum65 extends SubstitutionMatrixAbstract
{

    /**
     * Constructs a new BLOcks of Amino Acid SUbstitution Matrix.
     */
    protected function __construct()
    {
        $scores = [
            ['' ,'A','R','N','D','C','Q','E','G','H','I','L','K','M','F','P','S','T','W','Y','V','B','Z','X','*'],
            ['A',  4, -1, -2, -2,  0, -1, -1,  0, -2, -1, -2, -1, -1, -2, -1,  1,  0, -3, -2,  0, -2, -1, -1, -5],
            ['R', -1,  6,  0, -2, -4,  1,  0, -2,  0, -3, -2,  2, -2, -3, -2, -1, -1, -3, -2, -3, -1,  0, -1, -5],
            ['N', -2,  0,  6,  1, -3,  0,  0, -1,  1, -3, -4,  0, -2, -3, -2,  1,  0, -4, -2, -3,  3,  0, -1, -5],
            ['D', -2, -2,  1,  6, -4,  0,  2, -1, -1, -3, -4, -1, -3, -4, -2,  0, -1, -5, -3, -3,  4,  1, -1, -5],
            ['C',  0, -4, -3, -4,  9, -3, -4, -3, -3, -1, -1, -3, -2, -2, -3, -1, -1, -2, -2, -1, -3, -4, -2, -5],
            ['Q', -1,  1,  0,  0, -3,  6,  2, -2,  1, -3, -2,  1,  0, -3, -1,  0, -1, -2, -2, -2,  0,  3, -1, -5],
            ['E', -1,  0,  0,  2, -4,  2,  5, -2,  0, -3, -3,  1, -2, -3, -1,  0, -1, -3, -2, -3,  1,  4, -1, -5],
            ['G',  0, -2, -1, -1, -3, -2, -2,  6, -2, -4, -4, -2, -3, -3, -2,  0, -2, -3, -3, -3, -1, -2, -2, -5],
            ['H', -2,  0,  1, -1, -3,  1,  0, -2,  8, -3, -3, -1, -2, -1, -2, -1, -2, -2,  2, -3,  0,  0, -1, -5],
            ['I', -1, -3, -3, -3, -1, -3, -3, -4, -3,  4,  2, -3,  1,  0, -3, -2, -1, -2, -1,  3, -3, -3, -1, -5],
            ['L', -2, -2, -4, -4, -1, -2, -3, -4, -3,  2,  4, -3,  2,  0, -3, -3, -1, -2, -1,  1, -4, -3, -1, -5],
            ['K', -1,  2,  0, -1, -3,  1,  1, -2, -1, -3, -3,  5, -2, -3, -1,  0, -1, -3, -2, -2,  0,  1, -1, -5],
            ['M', -1, -2, -2, -3, -2,  0, -2, -3, -2,  1,  2, -2,  6,  0, -3, -2, -1, -2, -1,  1, -3, -2, -1, -5],
            ['F', -2, -3, -3, -4, -2, -3, -3, -3, -1,  0,  0, -3,  0,  6, -4, -2, -2,  1,  3, -1, -3, -3, -2, -5],
            ['P', -1, -2, -2, -2, -3, -1, -1, -2, -2, -3, -3, -1, -3, -4,  8, -1, -1, -4, -3, -2, -2, -1, -2, -5],
            ['S',  1, -1,  1,  0, -1,  0,  0,  0, -1, -2, -3,  0, -2, -2, -1,  4,  1, -3, -2, -2,  0,  0, -1, -5],
            ['T',  0, -1,  0, -1, -1, -1, -1, -2, -2, -1, -1, -1, -1, -2, -1,  1,  5, -3, -2,  0, -1, -1, -1, -5],
            ['W', -3, -3, -4, -5, -2, -2, -3, -3, -2, -2, -2, -3, -2,  1, -4, -3, -3, 10,  2, -3, -4, -3, -2, -5],
            ['Y', -2, -2, -2, -3, -2, -2, -2, -3,  2, -1, -1, -2, -1,  3, -3, -2, -2,  2,  7, -1, -3, -2, -1, -5],
            ['V',  0, -3, -3, -3, -1, -2, -3, -3, -3,  3,  1, -2,  1, -1, -2, -2,  0, -3, -1,  4, -3, -2, -1, -5],
            ['B', -2, -1,  3,  4, -3,  0,  1, -1,  0, -3, -4,  0, -3, -3, -2,  0, -1, -4, -3, -3,  4,  1, -1, -5],
            ['Z', -1,  0,  0,  1, -4,  3,  4, -2,  0, -3, -3,  1, -2, -3, -1,  0, -1, -3, -2, -2,  1,  4, -1, -5],
            ['X', -1, -1, -1, -1, -2, -1, -1, -2, -1, -1, -1, -1, -1, -2, -2, -1, -1, -2, -1, -1, -1, -1, -1, -5],
            ['*', -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5,  1]
        ];

        parent::__construct($scores);
    }

}
