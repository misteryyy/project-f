<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
 
class ProjectComment extends EntityRepository
{
    public function findThemAll($project)
    {
        $stmt = 'SELECT c FROM App\Entity\ProjectComment c ORDER BY c.created DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }

}
