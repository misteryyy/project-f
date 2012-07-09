<?php
namespace App\Repository\Project;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

 
class ProjectRole extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT u FROM App\Entity\ProjectRole u ORDER BY u.id ASC';
        return $this->_em->createQuery($stmt)->getResult();
    }

        
}
