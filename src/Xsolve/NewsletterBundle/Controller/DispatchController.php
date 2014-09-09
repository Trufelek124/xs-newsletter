<?php

namespace Xsolve\NewsletterBundle\Controller;

use DateTime;
use Xsolve\NewsletterBundle\Entity\Dispatch;
use Xsolve\NewsletterBundle\Entity\Task;
use Xsolve\NewsletterBundle\Form\Type\DispatchType;
use Xsolve\NewsletterBundle\Form\Type\RecipientSelectionType;

class DispatchController extends BaseController
{
    public function __construct()
    {
        parent::__construct(array(
            'entityName' => 'XsolveNewsletterBundle:Dispatch',
            'viewPrefix' => 'XsolveNewsletterBundle:Dispatch:',
            'viewSuffix' => '.html.twig',
            'paramPrefix' => 'xsolve_newsletter.'
        ));
    }

    public function indexAction()
    {
        return $this->render('index', array(
            'dispatches' => $this->getRepo()->findAll(),
            'tasksPerTime' => $this->getParam('tasks_per_time')
        ));
    }

    public function newAction()
    {
        $form = $this->createForm(new DispatchType(), new Dispatch());
        $req = $this->getRequest();

        if ($req->isMethod('POST')) {
            $form->bind($req);
        }

        return $this->render('new', array(
            'form' => $form->createView()
        ));
    }

    public function selectAction()
    {
        $dispatch = new Dispatch();
        $form = $this->createForm(new DispatchType(), $dispatch);
        $req = $this->getRequest();

        if ($req->isMethod('POST')) {
            $form->bind($req);
            if ($form->isValid()) {
                $dispatch->setDate(new DateTime());
                $dispatch->setDoneTasks(0)->setFailedTasks(0)->setTotalTasks(0);
                $em = $this->getEm();
                $em->persist($dispatch);
                $em->flush();

                $listId = $dispatch->getList()->getId();
                $selectionForm = $this->createForm(new RecipientSelectionType($listId));

                return $this->render('select', array(
                    'dispatch' => $dispatch,
                    'form' => $selectionForm->createView()
                ));
            }
        }

        return $this->forward('XsolveNewsletterBundle:Dispatch:new');
    }

    public function startAction($id)
    {
        $dispatch = $this->getRepo()->find($id);
        $listId = $dispatch->getList()->getId();
        $form = $this->createForm(new RecipientSelectionType($listId));
        $req = $this->getRequest();

        if ($req->isMethod('POST')) {
            $form->bind($req);
            if ($form->isValid()) {
                $recipients = $form->get('recipients')->getData();
                $this->createTasks($recipients, $dispatch);
                $this->addFlash('ok', 'Wysyłka została rozpoczęta');

                return $this->redirectToRoute('xsolve_newsletter_dispatch_index');
            }
        }
    }

    protected function createTasks($recipients, $dispatch)
    {
        $em = $this->getEm();
        foreach ($recipients as $recipient) {
            $task = new Task();
            $task->setRecipient($recipient);
            $task->setDispatch($dispatch);
            $em->persist($task);
        }
        $dispatch->setTotalTasks($recipients->count());
        $em->persist($dispatch);
        $em->flush();
    }

}
