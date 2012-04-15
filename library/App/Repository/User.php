<?php
namespace App\Repository;


use Doctrine\ORM\Mapping\Entity;

use Doctrine\ORM\EntityRepository;
use App\Entity;
 
class User extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\User q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
}
