<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;
 
class Project extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\Project q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
}
