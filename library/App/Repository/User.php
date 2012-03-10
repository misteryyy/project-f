<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;
 
class User extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\User q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
}
