<?php
/**
 * `IndexControllerProvider.php`
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
 * @subpackage Controller
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HochschuleBremen\Application\SequenceAlignment\Controller;

use FlorianWolters\Component\Core\Enum\EnumUtils;
use HochschuleBremen\Application\SequenceAlignment\Algorithm\SmithWaterman;
use HochschuleBremen\Application\SequenceAlignment\Form\AminoAcidAlignmentType;
use HochschuleBremen\Application\SequenceAlignment\Form\NucleicAcidAlignmentType;
use HochschuleBremen\Application\SequenceAlignment\Form\SequenceSelectionType;
use HochschuleBremen\Application\SequenceAlignment\Entity\AminoAcidAlignment;
use HochschuleBremen\Application\SequenceAlignment\Entity\NucleicAcidAlignment;
use HochschuleBremen\Application\SequenceAlignment\Entity\SequenceSelection;
use HochschuleBremen\Application\SequenceAlignment\Model\SubstitutionMatrix\SubstitutionMatrixFactory;
use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * TODO Add class comment.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Controller
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 * @todo       This class requires some serious refactoring.
 */
class IndexControllerProvider implements ControllerProviderInterface
{

    /**
     * @param Application $app An Application instance.
     *
     * @return string
     */
    public function indexAction(Application $app)
    {
        $type = new SequenceSelectionType;
        $entity = new SequenceSelection;

        /* @var $form Symfony\Component\Form\Form */
        $form = $app['form.factory']->create($type, $entity);
        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];

        // Check whether the HTTP request method is "POST".
        if ('POST' === $request->getMethod()) {
            // Bind the HTTP request to the form.
            $form->bindRequest($request);

            // Check whether the form is valid.
            if (true === $form->isValid()) {
                // Return the data from the form.
                $data = $form->getData();

                // HTTP redirect.
                return $app->redirect("/{$data->getSequenceType()}");
            }
        }

        return $app->render(
            'index.html.twig', [
                'form' => $form->createView(),
                'form_method' => 'post',
                'route_name' => 'home',
                'form_legend' => 'Select the type of the sequences to align',
                'button_label' => 'Proceed'
            ]
        );
    }

    /**
     * @param Application $app An Application instance.
     *
     * @return string
     */
    public function viewAminoAcidAlignmentFormAction(Application $app)
    {
        $type = new AminoAcidAlignmentType;
        $entity = new AminoAcidAlignment;

        /* @var $form Symfony\Component\Form\Form */
        $form = $app['form.factory']->create($type, $entity);
        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if (true === $form->isValid()) {
                return $app->redirect('/result');
            }
        }

        return $app->render(
            'index.html.twig', [
                'form' => $form->createView(),
                'form_method' => 'post',
                'route_name' => 'result',
                'form_legend' => 'Enter the parameters for the pairwise local amino acid sequence alignment',
                'button_label' => 'Go'
            ]
        );
    }

    /**
     * @param Application $app An Application instance.
     *
     * @return string
     */
    public function viewNucleicAcidAlignmentFormAction(Application $app)
    {
        $type = new NucleicAcidAlignmentType;
        $entity = new NucleicAcidAlignment;

        /* @var $form Symfony\Component\Form\Form */
        $form = $app['form.factory']->create($type, $entity);
        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if (true === $form->isValid()) {
                return $app->redirect('/result');
            }
        }

        return $app->render(
            'index.html.twig', [
                'form' => $form->createView(),
                'form_method' => 'post',
                'route_name' => 'result',
                'form_legend' => 'Enter the parameters for the pairwise local nucleic acid sequence alignment',
                'button_label' => 'Go'
            ]
        );
    }

    /**
     * @param Application $app An Application instance.
     *
     * @return string
     */
    public function displayResultAction(Application $app)
    {
        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];
        $data = $request->get('amino_acid_alignment');

        // TODO Find a way to use the enumeration constant IN the entity.
        $enumType = 'HochschuleBremen\Application\SequenceAlignment\Model\SubstitutionMatrix\SubstitutionMatrixEnum';
        $matrixName = EnumUtils::getNameForOrdinal(
            $enumType, $data['scoringMatrix']
        );
        $matrixEnum = EnumUtils::valueOf($enumType, $matrixName);
        $matrix = SubstitutionMatrixFactory::getInstance()->create(
            $matrixEnum
        );

        $aligner = new SmithWaterman(
            $data['firstSequence'],
            $data['secondSequence']
        );

        $scoreTable = $aligner->getScoreTable();

        return $app->render(
            'result.html.twig', [
                'alignment' => $data,
                'aligner' => $aligner,
                'firstSequence' => \str_split($data['firstSequence']),
                'secondSequence' => \str_split($data['secondSequence'])
            ]
        );
    }

    /**
     * Returns routes to connect to the given application.
     *
     * {@inheritdoc}
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function () use ($app) {
            return $this->indexAction($app);
        }, 'GET|POST')->bind('home');

        $controllers->get('/aa', function () use ($app) {
            return $this->viewAminoAcidAlignmentFormAction($app);
        })->bind('amino_acid_form');

        $controllers->get('/sa', function () use ($app) {
            return $this->viewNucleicAcidAlignmentFormAction($app);
        })->bind('nucleic_acid_form');

        $controllers->post('/result', function () use ($app) {
            return $this->displayResultAction($app);
        })->bind('result');

        return $controllers;
    }

}
