<?php

namespace Xsolve\NewsletterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    public function render($view, array $parameters = array(), Response $response = null)
    {
        if (isset($this->options['viewPrefix'])) {
            $view = $this->options['viewPrefix'] . $view;
        }
        if (isset($this->options['viewSuffix'])) {
            $view = $view . $this->options['viewSuffix'];
        }

        return parent::render($view, $parameters, $response);
    }

    protected function addFlash($type, $message)
    {
        $this->get('session')->getFlashBag()->add($type, $message);
    }

    protected function redirectToRoute($route, array $parameters = array())
    {
        return $this->redirect($this->generateUrl($route, $parameters));
    }

    protected function getParam($name)
    {
        if (isset($this->options['paramPrefix'])) {
            $name = $this->options['paramPrefix'] . $name;
        }

        return $this->container->getParameter($name);
    }

    protected function getRepo($entityName = '')
    {
        if ( ! $entityName && isset($this->options['entityName'])) {
            $entityName = $this->options['entityName'];
        }

        return $this->getEm()->getRepository($entityName);
    }

    protected function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

}
