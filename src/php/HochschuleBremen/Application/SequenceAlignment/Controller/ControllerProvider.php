<?php
/**
 * `ControllerProvider.php`
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
use HochschuleBremen\Application\SequenceAlignment\Form\AlignmentType;
use HochschuleBremen\Application\SequenceAlignment\Form\SequenceSelectionType;
use HochschuleBremen\Application\SequenceAlignment\Entity\Alignment;
use HochschuleBremen\Application\SequenceAlignment\Entity\SequenceSelection;
use HochschuleBremen\Component\Alignment\SmithWaterman;
use HochschuleBremen\Component\Alignment\SubstitutionMatrix\AminoAcidSubstitutionMatrixEnum;
use HochschuleBremen\Component\Alignment\SubstitutionMatrix\NucleotideSubstitutionMatrixEnum;
use HochschuleBremen\Component\Alignment\SubstitutionMatrix\SubstitutionMatrixFactory;
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
class ControllerProvider implements ControllerProviderInterface
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
            'home.html.twig', [
                'form' => $form->createView(),
                'form_method' => 'post',
                'route_name' => 'home'
            ]
        );
    }

    /**
     * @param Application $app An Application instance.
     *
     * @return string
     */
    public function displayProteinForm(Application $app)
    {
        $options = [
            'sequence_type' => 'protein',
            'matrices' => AminoAcidSubstitutionMatrixEnum::names(),
            'matrix_choice' => AminoAcidSubstitutionMatrixEnum::BLOSUM62()->getName()
        ];

        // TODO This is far from optimal.
        return $this->displayForm(
            $app,
            $options,
            'HochschuleBremen\Component\Alignment\SubstitutionMatrix\AminoAcidSubstitutionMatrixEnum'
        );
    }

    /**
     * @param Application $app     An Application instance.
     * @param array       $options
     *
     * @return string
     */
    private function displayForm(Application $app, array $options, $enumType)
    {
        $type = new AlignmentType;
        $entity = new Alignment;

        /* @var $form Symfony\Component\Form\FormFactory */
        $form = $app['form.factory']->create($type, $entity, $options);

        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if (true === $form->isValid()) {
                /* @var $data HochschuleBremen\Application\SequenceAlignment\Entity\Alignment */
                $data = $form->getData();

                // TODO Implement ModelTransformer for this.
                $substitutionMatrixName = $data->getSubstitutionMatrixName();
                $substitutionMatrixType = EnumUtils::valueOf(
                    $enumType, $substitutionMatrixName
                );
                $substitutionMatrix = SubstitutionMatrixFactory::getInstance()
                    ->create($substitutionMatrixType);

                // TODO Modify algorithm and the constructor call.
                $aligner = new SmithWaterman(
                    $data->getQuery(),
                    $data->getTarget(),
                    1,
                    -1,
                    $data->getGapPenalty()->getOpenPenalty()/*,
                    $substitutionMatrix*/
                );

                return $app->render(
                    'result.html.twig', [
                        'alignment' => $data,
                        'aligner' => $aligner,
                        'firstSequence' => \str_split($data->getQuery()),
                        'secondSequence' => \str_split($data->getTarget())
                    ]
                );
            }
        }

        return $app->render(
            'alignment.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Application $app An Application instance.
     *
     * @return string
     */
    public function displayNucleotideForm(Application $app)
    {
        $options = [
            'sequence_type' => 'nucleotide',
            'matrices' => NucleotideSubstitutionMatrixEnum::names(),
            'matrix_choice' => NucleotideSubstitutionMatrixEnum::NUCFOURFOUR()->getName()
        ];

        return $this->displayForm(
            $app,
            $options,
            'HochschuleBremen\Component\Alignment\SubstitutionMatrix\NucleotideSubstitutionMatrixEnum'
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

        $controllers->match('/amino_acid', function () use ($app) {
            return $this->displayProteinForm($app);
        }, 'GET|POST');

        $controllers->match('/nucleotide', function () use ($app) {
            return $this->displayNucleotideForm($app);
        }, 'GET|POST');

        return $controllers;
    }

}
