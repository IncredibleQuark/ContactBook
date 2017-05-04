<?php

namespace ContactBookBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends EntityRepository
{
    public function sort() {
        $dql = "SELECT contact FROM ContactBookBundle:Contact contact ORDER BY contact.surname ";
        $contacts = $this->getEntityManager()->createQuery($dql)->getResult();
        return $contacts;
    }
}
