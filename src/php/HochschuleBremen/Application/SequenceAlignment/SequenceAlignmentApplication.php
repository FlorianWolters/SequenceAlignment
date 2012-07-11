<?php

/**
 * `Application.php`
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
 * @category  Biology
 * @package   SequenceAlignment
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   GIT: $Id$
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     File available since Release 0.1.0
 */

namespace HochschuleBremen\Application\SequenceAlignment;

use Silex\Application;
use Silex\Application\FormTrait;
use Silex\Application\TranslationTrait;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * The sequence alignment application.
 *
 * @category  Biology
 * @package   SequenceAlignment
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   Release: @package_version@
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 */
class SequenceAlignmentApplication extends Application
{

    /**
     * Provides a service for building forms in the application with the
     * Symfony2 Form component.
     *
     * @link http://symfony.com/doc/2.0/book/forms.html
     */
    use FormTrait;

    /**
     * Provides a service for translating the pplication into different
     * languages.
     *
     * @link http://silex.sensiolabs.org/doc/providers/translation.html
     */
    use TranslationTrait;

    /**
     * Provides integration with the Twig template engine.
     *
     * @link http://silex.sensiolabs.org/doc/providers/twig.html
     * @link http://twig.sensiolabs.org/documentation
     */
    use TwigTrait;

    /**
     * Provides a service for generating URLs for named routes.
     *
     * @link http://silex.sensiolabs.org/doc/providers/url_generator.html
     */
    use UrlGeneratorTrait;

    /**
     * The configuration of this application.
     *
     * @var array
     */
    private $config;

    /**
     * Constructs a new Application with the specified filepath to the YAML
     * configuration file.
     *
     * @param string $configFile The filepath to the YAML file.
     */
    public function __construct($configFile)
    {
        parent::__construct();
        $this->config = $this->loadConfiguration($configFile);
        $this->configureCoreParameters($this->config);
        $this->registerServiceProviders();
        $this->configureParametersForServiceProviders($this->config);
        $this->mountControllerProviders();
    }

    /**
     * Loads the configuration from the specified YAML file.
     *
     * @param string $configFile The filepath to the YAML file.
     * @return array The configuration.
     *
     * @throws RuntimeException If unable to locate the YAML file.
     * @throws ParseException If unable to paser the YAML file.
     */
    protected function loadConfiguration($configFile)
    {
        $result = [];

        if (false === \file_exists($configFile)) {
            throw new \RuntimeException(
                'Unable to locate the YAML file: ' . $configFile
            );
        } else {
            $result = Yaml::parse($configFile);
        }

        return $result;
    }

    /**
     * Configures Silex core parameters.
     *
     * @return void
     * @link http://silex.sensiolabs.org/doc/services.html#core-parameters
     */
    protected function configureCoreParameters(array $config)
    {
        // The charset to use for Responses.
        $this['charset'] = $config['charset'];
        // Whether or not the application is running in debug mode.
        $this['debug'] = $config['debug'];
        // Set the default port for non-HTTPS URLs.
        $this['request.http_port'] = $config['request']['http_port'];
        // Set the default port for HTTPS URLs.
        $this['request.https_port'] = $config['request']['https_port'];
    }

    /**
     * Registers Silex built-in service providers.
     *
     * @return void
     */
    protected function registerServiceProviders()
    {
        // Provides a service for validating data.
        // http://silex.sensiolabs.org/doc/providers/validator.html
        $this->register(new ValidatorServiceProvider);
        $this->register(new FormServiceProvider);
        $this->register(new TranslationServiceProvider);
        $this->register(new TwigServiceProvider);
        $this->register(new UrlGeneratorServiceProvider);
    }

    /**
     * Configures Silex built-in service providers.
     *
     * @return void
     */
    protected function configureParametersForServiceProviders(array $config)
    {
        $this['translator.messages'] = [];

        $this['twig.form.templates'] = ['form_div_layout.html.twig'];
        $this['twig.options'] = [
            'debug' => $config['debug'],
            'charset' => $config['charset'],
            'base_template_class' => 'Twig_Template',
            'cache' => $config['dir']['cache'],
            'auto_reload' => $config['debug'],
            'strict_variables' => true,
            'autoescape' => true,
            'optimizations' => 1
        ];
        $this['twig.path'] = $config['dir']['assets']['views'];
        $this['twig.templates'] = [];

        // Add the configuration of this application as a global variable to
        // Twig.
        $this['twig']->addGlobal('config', $config);
    }

    /**
     * Mounts the controller providers of this application.
     *
     * @return void
     */
    protected function mountControllerProviders()
    {
        $this->mount('/', new Controller\IndexControllerProvider);
    }

    /**
     * Returns the configuration of this application.
     *
     * @return array The configuration.
     */
    public function getConfig()
    {
        return $this->config;
    }

}
