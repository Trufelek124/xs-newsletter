<?php

namespace Xsolve\NewsletterBundle\Controller;

use Xsolve\NewsletterBundle\Form\Type\RecipientType;

class RecipientController extends BaseController
{
    public function __construct()
    {
        parent::__construct(array(
            'entityName' => 'XsolveNewsletterBundle:Recipient',
            'viewPrefix' => 'XsolveNewsletterBundle:Recipient:',
            'viewSuffix' => '.html.twig'
        ));
    }

    public function newAction($listId)
    {
        $recipient = $this->getRepo()->createRecipientOnListWithId($listId);
        $form = $this->createForm(new RecipientType(), $recipient);
        $req = $this->getRequest();

        if ($req->isMethod('POST')) {
            $form->bind($req);
            if ($form->isValid()) {
                $recipient->setActive(true);
                $em = $this->getEm();
                $em->persist($recipient);
                $em->flush();
                $this->addFlash('ok', 'Adres został zapisany');

                return $this->redirectToRoute('xsolve_newsletter_list_details', array(
                    'id' => $listId
                ));
            }
        }

        return $this->render('new', array(
            'listId' => $listId,
            'form' => $form->createView()
        ));
    }

}
