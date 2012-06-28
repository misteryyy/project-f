<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class TaskFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}	
	
	
	/**
	 * Find all task for the project 
	 * @param unknown_type $project_id
	 * @param unknown_type $level
	 * @throws \Exception
	 */
	public function findTasksForProject($project_id,$level = 0){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$stmt = 'SELECT u FROM App\Entity\ProjectTask u WHERE u.project = ?1';
		
		// filter tasks
		if($level != 0 && $level < 3){
			$stmt . " AND u.level = " . $level;	
		}
		
		$stmt .= 'ORDER BY u.id, u.level ASC';	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		return $query->getResult();	
	}
	
	/**
	 * 
	 * @param unknown_type $project_id
	 * @param unknown_type $id
	 * @throws \Exception
	 */
	public function findOneTaskForProject($project_id,$id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$q = $this->em->getRepository ('\App\Entity\ProjectTask')->findOneBy(array("id" => $id));
		if($q){
			return $q;
		}else {
			throw new \Exception("This task doesn't exists");
		}
	
	}
	
	/**
	 * Delete Project task
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $id
	 * @throws \Exception
	 */
	public function deleteProjectTask($user_id,$project_id,$id){
		$question= $this->findOneProjectWidgetQuestion($user_id, $project_id, $id);
		if($question){
			$this->em->remove($question);
			$this->em->flush();
		}
		else {
			throw new \Exception("This question doesn't exists");
		}
	}
	
	/**
	 * 
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $task_id
	 * @param unknown_type $data
	 * @throws \Exception
	 */
	public function updateProjectTask($user_id,$project_id,$task_id,$data = array()){
		// check existence of user -> idea better check if task is created by this user
		
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		// find task
		$t =$this->findOneTaskForProject($project_id, $task_id);
		
		if($t){
			$t->setTask = $data['task'];
			$this->em->flush();
		} else {
			throw new \Exception("This question can't be updated");
		}
	}
	
	/**
	 * Create new task for the project 
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 * @throws \Exception
	 */
	public function createProjectTask($user_id,$project_id,$data){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}

		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$newTask = new \App\Entity\ProjectTask($data['task'],$data['level']);
		$newTask->setProject($project);
		$this->em->persist($newTask);
		$this->em->flush();
	}
	
	
	/*
	 * Return applications for the project
	*/
	public function findApplicationsPaginator($user_id,$project_id,$options = array()){
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		
		$stmt = 'SELECT a FROM App\Entity\ProjectApplication a WHERE a.project = ?1';
		$stmt .= 'ORDER BY a.created, a.roleName DESC';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
			
		
		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
		$iterator = $paginator->getIterator();
	
		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
		
		return new \Zend_Paginator($adapter);
	}

	
	/*
	 * Return applications for the project
	*/
	public function findApplications($user_id,$project_id,$options = array()){
	
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
	
		$stmt = 'SELECT a FROM App\Entity\ProjectApplication a WHERE a.project = ?1';
		$stmt .= 'ORDER BY a.created, a.roleName DESC';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);

	
		return $query->getResult();
	}
	
	
}

?>