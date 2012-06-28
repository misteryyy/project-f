<?php
namespace App\Facade\Admin;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class NewsletterFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}
	
	/**
	 * Add project on position in slideshow
	 */
	public function getUserForNewsletter($user_id){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		// find user who activated newsletter
		$stmt = 'SELECT c FROM App\Entity\User c WHERE c.emailNewsletter = ?1';
		$stmt .= 'ORDER BY c.created DESC  ';
		
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, true);
		
		return $query->getResult();
	}
	
	
	

	
		
	

}

?>