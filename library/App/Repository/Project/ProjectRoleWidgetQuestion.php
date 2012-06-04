<?php
namespace App\Repository\Project;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

 
class ProjectRoleWidgetQuestion extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT u FROM App\Entity\ProjectRoleWidgetQuestion u ORDER BY u.id ASC';
        return $this->_em->createQuery($stmt)->getResult();
    }

        
}
