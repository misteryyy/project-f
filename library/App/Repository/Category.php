<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Category Repository
 * @author misteryyy
 *
 */
class Category extends EntityRepository
{
	
    /**
     * Find all categories
     */
	public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\Category q ORDER BY q.id ASC';
        return $this->_em->createQuery($stmt)->getResult();
    }
    
    
    /**
     * Find Cateogory by name
     * @param unknown_type $name
     */
    public function findOneByName($name)
    {
    	return $this->_em->createQuery ('SELECT q FROM App\Entity\Category q WHERE q.name = ?1' )
    	->setParameter (1, $name )->getResult();
    
    }
    

        
}
