<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
 
class UserInfo extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\UserInfo q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }
    
    

    
    
       
    
}
