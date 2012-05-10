<?php
namespace App\Facade;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class ProjectFacade {
	
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
	}
	
	/**
	 * Return all categories in array / used for form
	 */
	public function findAllProjectCategoriesArray(){
		$categories = $this->em->getRepository ('\App\Entity\Category')->findThemAll();
		$arr = array(); 
		if(count($categories) > 0) {
			foreach ($categories as $cat){
				
				$arr[$cat->id] = $cat->name;
			}
			
		}
		return $arr;
		
	}



}

?>