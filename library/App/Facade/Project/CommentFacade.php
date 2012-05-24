<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class CommentFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	private $userFacade;
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
		$this->userFacade = new \App\Facade\UserFacade($em);
	}
	
	/**
	 * Answer from Creator to comment in project
	 */
	public function answerComment($user_id,$project_id,$data= array()){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$comment = $this->em->getRepository ('\App\Entity\ProjectComment')->findOneById ($data['comment_id']);
		if(!$comment){
			throw new \Exception("Can't find this comment to answer.");
		}
	
		$answerComment = new \App\Entity\ProjectComment($project, $user, $data['content']);
		$answerComment->setParent($comment);
		$answerComment->setPriority(3); // priority of creator
		$comment->addChild($answerComment);
		$comment->setPriority(0);
	
		$this->em->persist($answerComment);
		$this->em->flush();
	
	
	}
	/**
	 * Creates new comment for project
	 * @param int $project_id
	 * @param int $user_id
	 * @param string $message
	 * @param int $priority
	 */
	public function addComment($user_id,$project_id,$data = array()){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
	
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$newComment = new \App\Entity\ProjectComment($project, $user, $data['content'],$data['priority']);
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
	
		$stmt = 'SELECT c FROM App\Entity\ProjectComment c WHERE c.project = ?1 AND c.priority != 3';
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