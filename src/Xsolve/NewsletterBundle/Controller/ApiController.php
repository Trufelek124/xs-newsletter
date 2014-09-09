<?php

namespace Xsolve\NewsletterBundle\Controller;

use Xsolve\NewsletterBundle\Entity\Recipient;
use Xsolve\NewsletterBundle\Form\Type\RecipientType;

class ApiController extends BaseController
{
    public function __construct()
    {
        parent::__construct(array(
            'entityName' => 'XsolveNewsletterBundle:Recipient',
            'viewPrefix' => 'XsolveNewsletterBundle:Api:',
            'viewSuffix' => '.html.twig'
        ));
    }

    public function sampleformAction($listId)
    {
        $form = $this->createForm(new RecipientType(), new Recipient(), array(
            'csrf_protection' => false
        ));

        return $this->render('sampleform', array(
            'form' => $form->createView(),
            'actionUrl' => $this->generateUrl('xsolve_newsletter_api_subscribe', array(
                'listId' => $listId
            ), true)
        ));
    }

    public function subscribeAction($listId)
    {
        $recipient = $this->getRepo()->createRecipientOnListWithId($listId);
        $form = $this->createForm(new RecipientType(), $recipient, array(
            'csrf_protection' => false
        ));
        $req = $this->getRequest();

        if ($req->isMethod('POST')) {
            $form->bind($req);
            $msg = 'Your e-mail address is invalid.';
            if ($form->isValid()) {
                $recipient->setActive(true);
                $em = $this->getEm();
                $em->persist($recipient);
                $em->flush();
                $msg = 'Your e-mail address has ben successfully saved in the database.';
            }

            return $this->render('subscribe', array('msg' => $msg));
        }
        throw $this->createNotFoundException();
    }

    public function unsubscribeAction($mail, $id)
    {
        $mail = str_replace('___AT___', '@', $mail);
        $recipient = $this->getRepo()->findToUnsubscribe($mail, $id);
        $em = $this->getEm();
        $em->remove($recipient);
        $em->flush();

        return $this->render('unsubscribe', array(
            'mail' => $mail, 'id' => $id
        ));
    }

}
