<?php
/**
 * `index.php`
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
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   GIT: $Id$
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     File available since Release 0.1.0
 */

use HochschuleBremen\Application\SequenceAlignment\SequenceAlignmentApplication;

/**
 * Include the *Composer* autoloader.
 */
require __DIR__ . '/../../vendor/autoload.php';

/**
 * The relative or absolute filepath to the configuration file of the
 * application.
 *
 * @var string
 */
define('CONFIG_FILEPATH', __DIR__ . '/../data/config.yml');

try {
    // Create the application.
    $app = new SequenceAlignmentApplication(CONFIG_FILEPATH);
    // Run the application.
    $app->run();
} catch (\RuntimeException $ex) {
    echo 'Unable to locate the file: ' . $ex->getMessage();
} catch (ParseException $ex) {
    echo 'Unable to parse the YAML string: ' . $ex->getMessage();
}
