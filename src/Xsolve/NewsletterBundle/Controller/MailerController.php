<?php

namespace Xsolve\NewsletterBundle\Controller;

use Swift_Message;

class MailerController extends BaseController
{
    public function __construct()
    {
        parent::__construct(array(
            'entityName' => 'XsolveNewsletterBundle:Task',
            'viewPrefix' => 'XsolveNewsletterBundle:Mailer:',
            'viewSuffix' => '.html.twig',
            'paramPrefix' => 'xsolve_newsletter.'
        ));
    }

    public function sendAction($key)
    {
        if ( ! $this->isKeyValid($key)) {
            throw $this->createNotFoundException();
        }
        $stats = $this->executeTasks();
        $this->getEm()->flush();

        return $this->render('send', array(
            'stats' => $stats
        ));
    }

    protected function isKeyValid($key)
    {
        $validKey = $this->getParam('send_key');

        return $validKey == $key;
    }

    protected function executeTasks()
    {
        $stats = array('done' => 0, 'failed' => 0);
        $perTime = $this->getParam('tasks_per_time');
        $tasks = $this->getRepo()->getNextTasks($perTime);
        foreach ($tasks as $task) {
            $result = $this->executeTask($task);
            $result ? $stats['done'] += 1 : $stats['failed'] += 1;
            $this->getEm()->remove($task);
        }

        return $stats;
    }

    protected function executeTask($task)
    {
        $dispatch = $task->getDispatch();
        $message = $dispatch->getMessage();
        $swiftMessage = $this->createSwiftMessage($task, $message);
        $result = $this->get('mailer')->send($swiftMessage);
        if ($result == 1) {
            $dispatch->incDoneTasks();

            return TRUE;
        }
        $dispatch->incFailedTasks();

        return FALSE;
    }

    protected function createSwiftMessage($task, $message)
    {
        $fromMail = $this->getParam('from_mail');
        $fromName = $message->getFromName();
        if (strlen($fromName) < 1) {
            $fromName = $this->getParam('from_name');
        }
        $recipient = $task->getRecipient();
        $unsubscribeLink = $this->createUnsubscribeLink($recipient);
        $content = $message->getContent() . $unsubscribeLink;

        return Swift_Message::newInstance()
            ->setFrom(array($fromMail => $fromName))
            ->setTo($recipient->getMail())
            ->setSubject($message->getTitle())
            ->setBody($content, 'text/plain');
    }

    protected function createUnsubscribeLink($recipient)
    {
        $url = $this->generateUrl('xsolve_newsletter_api_unsubscribe', array(
            'mail' => str_replace('@', '___AT___', $recipient->getMail()),
            'id' => $recipient->getId()
        ), true);

        return "\n\n--\nclick to unsubscribe: $url\n";
    }

}
