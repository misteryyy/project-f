<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
 
class User extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\User q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
    
    
    public function findOneByEmail($email)
    {
    	$query = $this->_em->createQuery ('SELECT PARTIAL u.{id} FROM App\Entity\User u WHERE u.email = ?1' )
    	->setParameter (1, $email );
    	return $query->getResult();
    }
    
    
       
    
}
