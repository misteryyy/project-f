<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class CollaborationFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}
	
	
	/**
	 * Find Project Roles for accepted users
	 * @param unknown_type $user_id
	 * @throws \Exception
	 */
	public function findAllCollaborationRolesForUser($user_id){
		// check if user exists
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("User doesn't exists");
		}
			
		$stmt = 'SELECT u FROM App\Entity\ProjectRole u WHERE u.user = ?1 AND u.type = ?2';
		$stmt .= ' ORDER BY u.id ASC';
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $user);
		$query->setParameter(2, \App\Entity\ProjectRole::PROJECT_ROLE_TYPE_MEMBER);
		return $query->getResult();
	}
	
	/*
	 * Return applications for the member
	*/
	public function findApplications($user_id,$options = array()){

		$stmt = 'SELECT a FROM App\Entity\ProjectApplication a WHERE a.user = ?1';
	
		if(isset($options['state'])){
			// select just new application
			if( $options['state'] == \App\Entity\ProjectApplication::APPLICATION_NEW){
				$stmt .= ' AND a.state = 0'; //. \App\Entity\ProjectApplication::APPLICATION_NEW;
			}
			
			if( $options['state'] == \App\Entity\ProjectApplication::APPLICATION_DENIED){
				$stmt .= ' AND a.state = 1'; //. \App\Entity\ProjectApplication::APPLICATION_NEW;
			}

			if( $options['state'] == \App\Entity\ProjectApplication::APPLICATION_ACCEPTED){
				$stmt .= ' AND a.state = 2'; //. \App\Entity\ProjectApplication::APPLICATION_NEW;
			}
		}
		$stmt .= 'ORDER BY a.created';
		
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $user_id);
		return $query->getResult();
	}
	
	

}

?>