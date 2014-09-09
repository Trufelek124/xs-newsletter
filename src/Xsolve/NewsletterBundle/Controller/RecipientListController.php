<?php

namespace Xsolve\NewsletterBundle\Controller;

use Xsolve\NewsletterBundle\Entity\RecipientList;
use Xsolve\NewsletterBundle\Form\Type\RecipientListType;

class RecipientListController extends BaseController
{
    public function __construct()
    {
        parent::__construct(array(
            'entityName' => 'XsolveNewsletterBundle:RecipientList',
            'viewPrefix' => 'XsolveNewsletterBundle:RecipientList:',
            'viewSuffix' => '.html.twig'
        ));
    }

    public function indexAction()
    {
        return $this->render('index', array(
            'lists' => $this->getRepo()->getListsWithNumbers()
        ));
    }

    public function newAction()
    {
        $list = new RecipientList();
        $form = $this->createForm(new RecipientListType(), $list);
        $req = $this->getRequest();

        if ($req->isMethod('POST')) {
            $form->bind($req);
            if ($form->isValid()) {
                $em = $this->getEm();
                $em->persist($list);
                $em->flush();
                $this->addFlash('ok', 'Lista została dodana');

                return $this->redirectToRoute('xsolve_newsletter_list_index');
            }
        }

        return $this->render('new', array(
            'form' => $form->createView()
        ));
    }

    public function detailsAction($id)
    {
        return $this->render('details', array(
            'list' => $this->getRepo()->find($id)
        ));
    }

}
