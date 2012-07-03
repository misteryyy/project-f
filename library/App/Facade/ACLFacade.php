<?php
namespace App\Facade;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class ACLFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	private $userFacade;
	private $taskFacade;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
		$this->userFacade = new \App\Facade\UserFacade($em);
		$this->taskFacade = new \App\Facade\Project\TaskFacade($em);
		
	}
	
	
	/**
	 * If User Has already Applied don't let him to this again
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 */
	public function projectApplicationHasBeenSent($user_id,$project_id){
		
		// check if user exists
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("User doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$stmt = 'SELECT COUNT(a.id) FROM App\Entity\ProjectApplication a WHERE a.project = ?1 AND a.user = ?2';
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project);
		$query->setParameter(2, $user);
		
		$result = $query->getOneOrNullResult();
		return $result[1];
		
		//$query = $em->createQuery('SELECT COUNT(u.id) FROM Entities\User u');
		//$count = $query->getSingleScalarResult();
	}
		

	
}

?>