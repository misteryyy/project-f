<?php
namespace App\Repository;


namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
 
class Project extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\Project q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }


    
    /*
     * Return the most popular project in application
     */
    public function findTopProject($maxResultsCount) {
    	return $this->_em->createQueryBuilder()
    	->select('p')
    	->from('Project', 'p')
    	->where('p.status = ?1')
    	->orderBy('p.viewCount DESC')
    	->setMaxResults($maxResultsCount)
    	->getQuery()
    	->setParameter(1, Project::STATUS_PUBLISHED)
    	->getResult();
    }
    
}
