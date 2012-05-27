<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class ProjectBoardFacade {
	
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	private $userFacade;
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
		$this->userFacade = new \App\Facade\UserFacade($em);
	}
	

	/**
	 * Add new project board message
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 * @param unknown_type $files
	 * @throws \Exception
	 */
	public function addComment($user_id,$project_id,$data = array(),$files = array()){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
	
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$newComment = new \App\Entity\ProjectBoardComment($user, $project, $data['content']);
		// add files
		if(count($files) > 0 ){
			foreach ($files as $file){
				$newFile = new \App\Entity\ProjectBoardFile($file['file'],$file['type'],$file['size']);
				$newComment->addFile($newFile);			
			}
		}
		
		$this->em->persist($newComment);
		$this->em->flush();
	}
	
	
	/*
	 * Return the first layer of commments
	*/
	public function findCommentsForProject($project_id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$stmt = 'SELECT c FROM App\Entity\ProjectBoardComment c WHERE c.project = ?1';
		$stmt .= 'ORDER BY c.created DESC  ';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
			
		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
		$iterator = $paginator->getIterator();
	
		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
		return new \Zend_Paginator($adapter);
	}
	
	
	/*
	 * Return the first layer of commments
	*/
	public function findUnasweredCommentsForProject($project_id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		$stmt = 'SELECT c FROM App\Entity\ProjectComment c WHERE c.project = ?1 AND c.priority = 1';
		$stmt .= 'ORDER BY c.created DESC  ';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
			
		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
		$iterator = $paginator->getIterator();
	
		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
		return new \Zend_Paginator($adapter);
	}
	
	
	
	
}

?>