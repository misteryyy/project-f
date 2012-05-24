<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;
 
class UserFloBox extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\UserFloBox q ORDER BY q._id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
}