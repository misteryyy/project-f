<?php
namespace App\Facade\Admin;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class SlideshowFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
	}
	
	/**
	 * Add project on position in slideshow
	 */
	public function updateProject($user_id,$project_id,$slot_id){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$slideshow = $this->em->getRepository ('\App\Entity\Slideshow')->findOneById(1);
		if(!$slideshow){
			throw new \Exception("Can't set slideshow, something is wrong.");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}

		$slideshow->setProject($slot_id,$project);
		$this->em->flush();

	}
	
	
	/**
	 * Returns the slideshow object
	 * @param unknown_type $user_id
	 */
	public function findSlideshow(){
		
		$slideshow = $this->em->getRepository ('\App\Entity\Slideshow')->findOneById(1);
		if(!$slideshow){
			throw new \Exception("Can't set slideshow, something is wrong.");
		}
		
		return $slideshow;	
	}
	
	
	
		
	

}

?>