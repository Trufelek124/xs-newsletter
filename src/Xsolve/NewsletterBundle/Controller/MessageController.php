<?php

namespace Xsolve\NewsletterBundle\Controller;

use DateTime;
use Xsolve\NewsletterBundle\Entity\Message;
use Xsolve\NewsletterBundle\Form\Type\MessageType;

class MessageController extends BaseController
{
    public function __construct()
    {
        parent::__construct(array(
            'entityName' => 'XsolveNewsletterBundle:Message',
            'viewPrefix' => 'XsolveNewsletterBundle:Message:',
            'viewSuffix' => '.html.twig'
        ));
    }

    public function indexAction()
    {
        return $this->render('index', array(
            'messages' => $this->getRepo()->findAll()
        ));
    }

    public function newAction()
    {
        $message = new Message();
        $message->setDate(new DateTime());
        $actionUrl = $this->generateUrl('xsolve_newsletter_message_new');
        $title = 'Dodaj nową wiadomość:';

        return $this->renderForm($message, $actionUrl, $title);
    }

    public function editAction($id)
    {
        $message = $this->getRepo()->find($id);
        $actionUrl = $this->generateUrl('xsolve_newsletter_message_edit', array(
            'id' => $id
        ));
        $title = 'Edytujesz wiadomość "' . $message->getTitle() . '":';

        return $this->renderForm($message, $actionUrl, $title);
    }

    protected function renderForm($message, $actionUrl, $title = null)
    {
        $form = $this->createForm(new MessageType(), $message);
        $req = $this->getRequest();

        if ($req->isMethod('POST')) {
            $form->bind($req);
            if ($form->isValid()) {
                $em = $this->getEm();
                $em->persist($message);
                $em->flush();
                $this->addFlash('ok', 'Wiadomość została zapisana');

                return $this->redirectToRoute('xsolve_newsletter_message_index');
            }
        }

        return $this->render('form', array(
            'form' => $form->createView(),
            'actionUrl' => $actionUrl,
            'title' => $title
        ));
    }

}
