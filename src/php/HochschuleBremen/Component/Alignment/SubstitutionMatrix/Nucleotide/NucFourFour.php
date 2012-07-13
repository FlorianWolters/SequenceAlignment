<?php
/**
 * `NucFourFour.php`
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

namespace HochschuleBremen\Component\Alignment\SubstitutionMatrix\Nucleotide;

use HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixAbstract;

/**
 * An object of class NucFourFour wraps the NUC.4.4 substitution matrix into an
 * object.
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
class NucFourFour extends SubstitutionMatrixAbstract
{

    /**
     * Constructs a new NUC.4.4 substitution matrix.
     */
    protected function __construct()
    {
        $scores = [
            ['' ,'A','T','G','C','S','W','R','Y','K','M','B','V','H','D','N'],
            ['A',  5, -4, -4, -4, -4,  1,  1, -4, -4,  1, -4, -1, -1, -1, -2],
            ['T', -4,  5, -4, -4, -4,  1, -4,  1,  1, -4, -1, -4, -1, -1, -2],
            ['G', -4, -4,  5, -4,  1, -4,  1, -4,  1, -4, -1, -1, -4, -1, -2],
            ['C', -4, -4, -4,  5,  1, -4, -4,  1, -4,  1, -1, -1, -1, -4, -2],
            ['S', -4, -4,  1,  1, -1, -4, -2, -2, -2, -2, -1, -1, -3, -3, -1],
            ['W',  1,  1, -4, -4, -4, -1, -2, -2, -2, -2, -3, -3, -1, -1, -1],
            ['R',  1, -4,  1, -4, -2, -2, -1, -4, -2, -2, -3, -1, -3, -1, -1],
            ['Y', -4,  1, -4,  1, -2, -2, -4, -1, -2, -2, -1, -3, -1, -3, -1],
            ['K', -4,  1,  1, -4, -2, -2, -2, -2, -1, -4, -1, -3, -3, -1, -1],
            ['M',  1, -4, -4,  1, -2, -2, -2, -2, -4, -1, -3, -1, -1, -3, -1],
            ['B', -4, -1, -1, -1, -1, -3, -3, -1, -1, -3, -1, -2, -2, -2, -1],
            ['V', -1, -4, -1, -1, -1, -3, -1, -3, -3, -1, -2, -1, -2, -2, -1],
            ['H', -1, -1, -4, -1, -3, -1, -3, -1, -3, -1, -2, -2, -1, -2, -1],
            ['D', -1, -1, -1, -4, -3, -1, -1, -3, -1, -3, -2, -2, -2, -1, -1],
            ['N', -2, -2, -2, -2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1]
        ];

        parent::__construct($scores);
    }

}
