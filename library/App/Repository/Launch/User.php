<?php
namespace App\Repository\Launch;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
 
class User extends EntityRepository
{
    public function findAll()
    {
        $stmt = 'SELECT q FROM App\Entity\Launch\User q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
    
    
    public function findOneByEmail($email)
    {
    	return $this->_em->createQuery ('SELECT u FROM App\Entity\Launch\User u WHERE u.email = ?1' )
    	->setParameter (1, $email )->getResult();
    	 
    }
    
    
       
    
}
