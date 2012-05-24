<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

 
class ProjectSurveyQuestion extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\ProjectSurveyQuestion q ORDER BY q.id ASC';
        return $this->_em->createQuery($stmt)->getResult();
    }

        
}
