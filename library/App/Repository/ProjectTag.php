<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
 
class ProjectTag extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\ProjectTag q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
    
    
    	
    
    
}
