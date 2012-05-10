<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

 
class Category extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\Category q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }

        
}
