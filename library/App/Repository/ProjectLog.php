<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
 
class ProjectLog extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT l FROM App\Entity\ProjectLog l ORDER BY l.created DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }

}
