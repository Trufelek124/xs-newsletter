<?php

namespace Xsolve\NewsletterBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function getNextTasks($n)
    {
        return $this->getEntityManager()->createQuery('
            SELECT t, r, d, m
            FROM XsolveNewsletterBundle:Task t
            JOIN t.recipient r
            JOIN t.dispatch d
            JOIN d.message m
        ')->setMaxResults($n)->getResult();
    }

}
