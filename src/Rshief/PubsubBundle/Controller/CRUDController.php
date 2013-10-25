<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rshief\PubsubBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CRUDController extends BaseController
{

    /**
     * return the Response object associated to the create action
     *
     * @throws AccessDeniedException
     * @return Response
     */
    public function createAction()
    {
        if ($this->getRestMethod()== 'POST') {

            // the key used to lookup the template
            $templateKey = 'edit';

            if (false === $this->admin->isGranted('CREATE')) {
                throw new AccessDeniedException();
            }

            $object = $this->admin->getNewInstance();

            $this->admin->setSubject($object);

            /* @var $form Form */
            $form = $this->admin->getForm();
            $form->setData($object);

            $form->bind($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $criteria = array(
                  'topicUrl' => $object->getTopicUrl(),
                  'hubName' => $object->getHubName(),
                );
                $object = $this->get('sputnik_pubsub.topic_manager')->findOneBy($criteria);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                        'result' => 'ok',
                        'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                $this->addFlash('sonata_flash_success','flash_create_success');
                // redirect to edit mode
                return $this->redirectTo($object);
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', 'flash_create_error');
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }

            $view = $form->createView();

            // set the theme for the current Admin Form
            $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

            return $this->render($this->admin->getTemplate($templateKey), array(
                'action' => 'create',
                'form'   => $view,
                'object' => $object,
            ));
        } else {
            return parent::createAction();
        }
    }
}
