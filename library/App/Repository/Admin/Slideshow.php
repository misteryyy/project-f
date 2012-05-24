<?php
namespace App\Repository\Admin;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;

 
class Slideshow extends EntityRepository
{
    public function findThemAll()
    {
        $stmt = 'SELECT q FROM App\Entity\Slideshow q ORDER BY q.id DESC';
        return $this->_em->createQuery($stmt)->getResult();
    }

        
}
