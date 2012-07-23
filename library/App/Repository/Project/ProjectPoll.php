<?php
namespace App\Repository\Project;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

 
class ProjectPoll extends EntityRepository
{
	
    public function findThemAll()
    {
        $stmt = 'SELECT p FROM App\Entity\ProjectPoll p ORDER BY p.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
    
    
    

        
}
