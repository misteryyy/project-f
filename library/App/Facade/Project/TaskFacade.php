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
	 * Change the project Level
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 * @throws \Exception
	 */
	public function setProjectLevel($user_id,$project_id,$data=array()){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
	
		// check if all task from previous level are done
		if($data['level'] == 2 || $data['level'] == 3 ) {
			// check 	
			$finished = $this->findFinishedTasksCountForProject($project_id,$data['level']);
			$allTaskCount = $this->findTasksCountForProject($project_id,$data['level']);
			
			if( ($allTaskCount[0][1] - $finished[0][1]) != 0) {
				throw new \Exception("You don't have finished tasks from previous level. Please finish them.");
			}
		}
		
		if($project->user == $user){
				
			// TODO checking if all task are completed
			$project->setLevel($data['level']);
			$this->em->flush();
	
		} else {
			throw new \Exception("You are not allowed to change this property.");
		}
	
	
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
		if($level != 0 ){
			$stmt .= " AND u.level = " . $level;	
		}
		
		$stmt .= 'ORDER BY u.id, u.level ASC';	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		return $query->getResult();	
	}
	
	/**
	 * Find all finished task for level
	 * @param unknown_type $project_id
	 * @param unknown_type $level
	 * @throws \Exception
	 */
	public function findFinishedTasksCountForProject($project_id,$level = 0){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$stmt = 'SELECT COUNT(u.id) FROM App\Entity\ProjectTask u WHERE u.project = ?1';
	
		// filter tasks
		if($level != 0 ){
			$stmt .= " AND u.finished = true AND u.level < " . $level;
		}
	
		$stmt .= 'ORDER BY u.id ASC';
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		return $query->getResult();
	}
	
	/**
	 * Find all finished task for level
	 * @param unknown_type $project_id
	 * @param unknown_type $level
	 * @throws \Exception
	 */
	public function findTasksCountForProject($project_id,$level = 0){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$stmt = 'SELECT COUNT(u.id) FROM App\Entity\ProjectTask u WHERE u.project = ?1';
	
		// filter tasks
		if($level != 0){
			$stmt .= "AND u.level < " . $level;
		}
	
		$stmt .= 'ORDER BY u.id ASC';
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
		
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		$task = $this->findOneTaskForProject($project_id, $id);
		
		if($task){
			$this->em->remove($task);
			$this->em->flush();
		}
		else {
			throw new \Exception("This question doesn't exists");
		}
	}
	
	
	public function finishProjectTask($user_id,$project_id,$task_id,$data = array()){
		// check existence of user -> idea better check if task is created by this user
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
	
		// find task
		$t =$this->findOneTaskForProject($project_id, $task_id);
	
		if($t){
			// if checkbox is checked  ; jquery is not sending variable when chechbox is unchecked
			if(isset($data['finished'])) {
				$t->setFinished(true);
			} else {
				$t->setFinished(false);
			}
			$this->em->flush();
		} else {
			throw new \Exception("This question can't be updated");
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
			$t->setTask($data['task']);
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
	
	
	
	
}

?>