<?php
namespace App\Repository\Project;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

 
class ProjectPollAnswer extends EntityRepository
{
	
    public function findThemAll()
    {
        $stmt = 'SELECT p FROM App\Entity\ProjectPollAnswer p ORDER BY p.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
    
    
    

        
}
