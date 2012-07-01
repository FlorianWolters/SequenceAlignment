<?php
/**
 * `app.php`
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
 * @category  Biology
 * @package   SequenceAlignment
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   GIT: $Id$
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     File available since Release 0.1.0
 */

declare(encoding = 'UTF-8');

namespace HSBremen\ISBio\SequenceAlignment;

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// TODO: Place configuration options in .yml or .json file.

define('PROGRAM_DEBUG', true);
define('PATH_VENDOR', __DIR__ . '/../../../../../vendor');
define('PATH_WWW', __DIR__ . '/../../../../www');

/**
 * Include the *Composer* autoloader file.
 */
require_once PATH_VENDOR . '/autoload.php';

/**
 * The Silex application object.
 */
$app = new Application;

// Set Silex core parameters.
// http://silex.sensiolabs.org/doc/services.html#core-parameters

// The charset to use for Responses.
$app['charset'] = 'UTF-8';
// Whether or not the application is running in debug mode.
$app['debug'] = PROGRAM_DEBUG;
// Set the default port for non-HTTPS URLs.
$app['request.http_port'] = 80;
// Set the default port for HTTPS URLs.
$app['request.https_port'] = 443;

// Register Silex service providers.

// Provides a service for building forms in the application with the Symfony2
// Form component.
// http://symfony.com/doc/2.0/book/forms.html
$app->register(
    new FormServiceProvider, array('form.class_path' => PATH_VENDOR)
);

// Provides integration with the Twig template engine.
// http://silex.sensiolabs.org/doc/providers/twig.html
// http://twig.sensiolabs.org/documentation
$app->register(
    new TwigServiceProvider,
    array(
        'twig.path' => PATH_WWW . '/views',
        'twig.templates' => array(),
        'twig.options' => array(
            'debug' => PROGRAM_DEBUG,
            'charset' => 'utf-8',
            'base_template_class' => 'Twig_Template',
            'cache' => PATH_WWW . '/cache',
            'auto_reload' => PROGRAM_DEBUG,
            'strict_variables' => true,
            'autoescape' => true,
            'optimizations' => 1,
        ),
        'twig.class_path' => PATH_VENDOR,
        'twig.form.templates' => array(
            'form.html.twig'
        )
    )
);

// Provides a service for validating data.
// http://silex.sensiolabs.org/doc/providers/validator.html
$app->register(
    new ValidatorServiceProvider,
    array('validator.class_path' => PATH_VENDOR)
);

// Provides a service for generating URLs for named routes.
// http://silex.sensiolabs.org/doc/providers/url_generator.html
$app->register(new UrlGeneratorServiceProvider);

// Register a Silex response error handler.
$app->error(
    function(\Exception $ex, $code) use($app) {
        if ( $app['debug'] ) {
            // Do nothing (display the exception stack trace) if the debug mode
            // is enabled.
            return;
        }

        return $app['twig']->render(
            'error.html.twig',
            array(
                'code' => $code,
                'message' => $ex->getMessage()
            )
        );
    }
);

// Register the Silex before filter which allows to run code before every request.
// (The filter is only run for the "master" request.)
//
// This implements the "Intercepting Filter" design pattern.
$app->before(
    function(Request $request) use($app) {
        // Set up.
        // TODO Remove if unused on release.
    }
);

// Register the Silex after filter which allows to run code after every request.
// (The filter is only run for the "master" request.)
//
// This implements the "Intercepting Filter" design pattern.
$app->after(
    function(Request $request, Response $response) {
        // Tear down.
        // TODO Compress HTM.
    }
);

// TODO: Simple routes should be enough. We can mount controllers later.

$app->get('/hello/{name}', function($name) use($app) {
    return 'Hello '.$app->escape($name);
} );

// "It is possible to execute a return() statement inside an included file in
// order to terminate processing in that file and return to the script which
// called it. Also, it's possible to return values from included files."
// http://php.net/function.include
return $app;
