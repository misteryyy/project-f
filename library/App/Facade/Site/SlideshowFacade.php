<?php
namespace App\Facade\Site;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class SlideshowFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){		
		$this->em = $em;
	}
	
	/**
	 * Returns the slideshow object
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