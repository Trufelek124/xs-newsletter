<?php

namespace Xsolve\NewsletterBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipientRepository extends EntityRepository
{
    public function findToUnsubscribe($mail, $id)
    {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT r
                    FROM XsolveNewsletterBundle:Recipient r
                    WHERE r.mail = :mail AND r.id = :id
                ')
                ->setParameter('mail', $mail)
                ->setParameter('id', $id)
                ->getSingleResult();
    }

    public function createRecipientOnListWithId($id)
    {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('XsolveNewsletterBundle:RecipientList');
        $list = $repo->find($id);
        if (! $list) {
            throw new NotFoundHttpException();
        }
        $recipient = new Recipient();
        $recipient->setList($list);

        return $recipient;
    }

}
