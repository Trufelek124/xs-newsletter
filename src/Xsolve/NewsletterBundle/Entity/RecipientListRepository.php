<?php

namespace Xsolve\NewsletterBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RecipientListRepository extends EntityRepository
{
    public function getListsWithNumbers()
    {
        return $this->getEntityManager()->createQuery('
            SELECT l.id, l.name, COUNT(r.id) AS num
            FROM XsolveNewsletterBundle:RecipientList l
            LEFT JOIN l.recipients r
            GROUP BY l.id
            ORDER BY l.name ASC
        ')->getResult();
    }

}
