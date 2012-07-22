<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class TeamFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}	
	
	/**
	 * Return question for role widget
	 * @param unknown_type $project_id
	 * @throws \Exception
	 */
	public function findAllProjectRoleWidgetQuestions($project_id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$stmt = 'SELECT u FROM App\Entity\ProjectRoleWidgetQuestion u WHERE u.project = ?1';
		$stmt .= 'ORDER BY u.id ASC';
		
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		
		return $query->getResult();	
	}
	
	/**
	 * Return one project role
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $id
	 * @throws \Exception
	 * @return object
	 */
	public function findOneProjectRole($project_id,$id){
	
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$r = $this->em->getRepository ('\App\Entity\ProjectRole')->findOneBy(array("id" => $id));
		if($r){
			return $r;
		}else {
			throw new \Exception("This project role doesn't exists");
		}
	
	}
	
	
	
	/**
	 * Return all project widget question
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $id
	 * @throws \Exception
	 * @return object
	 */
	public function findOneProjectWidgetQuestion($user_id,$project_id,$id){
	
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
	
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$q = $this->em->getRepository ('\App\Entity\ProjectRoleWidgetQuestion')->findOneBy(array("id" => $id));
		if($q){
			return $q;
		}else {
			throw new \Exception("This question doesn't exists");
		}
	
	}
	
	/**
	 * Delete Project widget question
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $id
	 * @throws \Exception
	 */
	public function deleteProjectRoleWidgetQuestion($user_id,$project_id,$id){
		$question= $this->findOneProjectWidgetQuestion($user_id, $project_id, $id);
		if($question){
			$this->em->remove($question);
			$this->em->flush();
		}
		else {
			throw new \Exception("This question doesn't exists");
		}
		//TODO delete all answers for this question
	}
	
	/**
	 * Update project widget question
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $update_id
	 * @param unknown_type $data
	 */
	public function updateProjectWidgetQuestion($user_id,$project_id,$update_id,$data = array()){
		if(!isset($data['question']) || (strlen(trim($data['question'])) < 1) ) { throw new \Exception("Question can't be empty."); }

		$q =$this->findOneProjectWidgetQuestion($user_id,$project_id,$update_id);
		if($q){
		$q->setQuestion($data['question']);
		$this->em->flush();
		} else {
			throw new \Exception("This question can't be updated");
		}
	}
	
	/**
	 * Create new question for the project role widget
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 * @throws \Exception
	 */
	public function createProjectWidgetQuestion($user_id,$project_id,$data){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}

		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}

		if(count($this->findAllProjectRoleWidgetQuestions($project_id)) < 5){
			// validate data
			if(!isset($data['question']) || (strlen(trim($data['question'])) < 1) ) { throw new \Exception("Question can't be empty."); }

			$newQuestion = new \App\Entity\ProjectRoleWidgetQuestion($data['question']);
			$newQuestion->setProject($project);
			$this->em->persist($newQuestion);
			$this->em->flush();
		
		}else{
			throw new \Exception("Project can have maximum 5 questions.");
		}
	}
	
	/**
	 * Enable or disable project widget
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 */
	public function updateProjectRoleWidgetVisibility($user_id,$project_id,$data = array()){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		if($data['role_widget_disable'] == 1){
			$project->setDisableRoleWidget(true);
		}else {
			$project->setDisableRoleWidget(false);	
		}
		
		$this->em->flush();
		
	}
	

	/**
	 * Update project survey
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 */
	public function createProjectApplication($user_id,$project_id,$data = array()){		
		
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$content = "<h3>Survey for level ". $data['level']. "  </h3> <br/>";
		// if level 1
		if($data['level'] == 1) {
	
			$i = 1;
			for($i; $i < 6; $i++){
				$questionString = "question_".$i;
				$answerString = "answer_".$i;
			
				if(isset($data[$answerString]) ){
					$content .= "Question: ". $data[$questionString] . "<br/>";
					$content .= "Answer: ". $data[$answerString] . "<br/>";
					$content ." <hr> ";
				}		
			}
		
			$content .= "General question: " .$data['content']. " <br />";
				
			$newApplication = new  \App\Entity\ProjectApplication($user, $project, $data['level'], $content, $data['role']);
			$this->em->persist($newApplication);
			$this->em->flush();
		} 
		// application for level 2
		else if ($data['level'] == 2) {
			
			
			// find project role
			$role = $this->findOneProjectRole($project_id, $data['role_id']);
			
			$content .= "General question: " .$data['content']. " <br />";
			$newApplication = new  \App\Entity\ProjectApplication($user, $project, $data['level'], $content, $role->name);
			$newApplication->setDescription($role->description);
			$newApplication->setProjectRole($role);
			$this->em->persist($newApplication);
			$this->em->flush();
				
		}		
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
	
	
	
	/**
	 * Find all members in project
	 * @param unknown_type $project_id
	 * @param unknown_type $options
	 * @throws \Exception
	 */
	public function findProjectRolesForProject($project_id,$options = array()){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		
		$stmt = 'SELECT r FROM App\Entity\ProjectRole r WHERE r.project = ?1 AND r.type = ?2 AND r.user is NOT NULL ';
		$stmt .= 'ORDER BY r.name, r.level, r.description DESC';
		
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		$query->setParameter(2, \App\Entity\ProjectRole::PROJECT_ROLE_TYPE_MEMBER);
		
		return $query->getResult();	
	}
	

	/**
	 * Find all free positions for project
	 * @param unknown_type $project_id
	 * @param unknown_type $options
	 * @throws \Exception
	 */
	public function findFreeProjectRolesForProject($project_id,$options = array()){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
	
		$stmt = 'SELECT r FROM App\Entity\ProjectRole r WHERE r.project = ?1 AND r.type = ?2 AND r.user is NULL ';
		$stmt .= 'ORDER BY r.name, r.level, r.description DESC';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		$query->setParameter(2, \App\Entity\ProjectRole::PROJECT_ROLE_TYPE_MEMBER);
	
		return $query->getResult();
	}
	
	
	/**
	 * Find creator roles for project
	 * @param unknown_type $project_id
	 * @param unknown_type $options
	 * @throws \Exception
	 */
	public function findCreatorRolesForProject($project_id,$options = array()){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		
		$stmt = 'SELECT r FROM App\Entity\ProjectRole r WHERE r.project = ?1 AND r.type = ?2 ';
		$stmt .= 'ORDER BY r.name, r.level, r.description DESC';
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		$query->setParameter(2, \App\Entity\ProjectRole::PROJECT_ROLE_TYPE_CREATOR);
		return $query->getResult();
	
	}
	
	/**
	 * Delete the role for the current project
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $role_id
	 */
	public function denyProjectRole($user_id, $project_id, $role_id){
		
		// find project for this user
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		
		
		// find role
		$role = $this->em->getRepository ('\App\Entity\ProjectRole')->findOneBy(array("id" => $role_id));
		if(!$role){
			throw new \Exception("This role doesn't exists");
		}
		
		// find application which has this role_id
		$application = $this->em->getRepository ('\App\Entity\ProjectApplication')->findOneBy(array("projectRole" => $role));
		if(!$application){
			throw new \Exception("This role application doesn't exists");
		}

		// change application state
		$application->setState(\App\Entity\ProjectApplication::APPLICATION_DENIED);
		 // update application information, if there was some change
		 // the role will be deleted, so this is to have consistency in database
		$application->setDescription($role->getDescription());
		$application->setProjectRole(null); // member was kicked out
		$application->setResult("You been kickout from the project.");
		
			$this->em->remove($role);
			$this->em->flush();
	}

	/**
	 * Delete the role for the current project
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $role_id
	 */
	public function deleteProjectRole($user_id, $project_id, $role_id){
	
		// find project for this user
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
	
		// find role
		$role = $this->em->getRepository ('\App\Entity\ProjectRole')->findOneBy(array("id" => $role_id));
		if(!$role){
			throw new \Exception("This role doesn't exists");
		}
		
		// should be just one accepted application
		$applications = $this->findApplicationsForProjectRole($user_id, $project_id, $role_id,array('state' => 'new'));
		
		if(isset($applications)){
			foreach ($applications as $a){
				// set new state to the application
				$a->setState(\App\Entity\ProjectApplication::APPLICATION_DENIED);
				$a->setResult("Creator has decided to not have this position.");
				$a->setProjectRole(null);
				$a->setDescription($role->getDescription()); // for consistency, update the role
			}	
		}
		
		$this->em->remove($role);
		$this->em->flush();
	}
	
	
	/**
	 * Find Application for role
	 * type = accepted, denied, ..
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $role_id
	 * @param unknown_type $type
	 * @throws \Exception
	 */
	public function findApplicationsForProjectRole($user_id,$project_id,$role_id,$options = array( "state" => "accepted")){
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		
		$stmt = 'SELECT a FROM App\Entity\ProjectApplication a WHERE a.project = ?1 AND a.projectRole = ?2 ';
		
		// filter level
		if(isset($options['state'])){
			// select application for level
			if( $options['state'] === 'accepted' )
				$stmt .= ' AND a.state = '.\App\Entity\ProjectApplication::APPLICATION_ACCEPTED.' '; //. \App\Entity\ProjectApplication::APPLICATION_NEW;
		
			if( $options['state'] === 'new')
				$stmt .= ' AND a.state = '.\App\Entity\ProjectApplication::APPLICATION_NEW.' '; //. \App\Entity\ProjectApplication::APPLICATION_NEW;			
		}

		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		$query->setParameter(2, $role_id);
		
		return $query->getResult();
		
	}
	

	/*
	 * 
	 * Return applications for the project
	*/
	public function findApplications($user_id,$project_id,$options = array()){
			
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
	
		$stmt = 'SELECT a FROM App\Entity\ProjectApplication a WHERE a.project = ?1';
		
		if(isset($options['state'])){
			// select just new application
			if( $options['state'] == \App\Entity\ProjectApplication::APPLICATION_NEW)
			$stmt .= ' AND a.state = 0 '; //. \App\Entity\ProjectApplication::APPLICATION_NEW;
		
		}
		
		// filter level
		if(isset($options['level'])){
			// select application for level
			if( $options['level'] == 1 )
				$stmt .= ' AND a.level = 1 '; //. \App\Entity\ProjectApplication::APPLICATION_NEW;
		
			if( $options['level'] == 2 )
				$stmt .= ' AND a.level = 2 '; //. \App\Entity\ProjectApplication::APPLICATION_NEW;
			
		}
		
		$stmt .= 'ORDER BY a.level, a.created, a.roleName DESC';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);

	
		return $query->getResult();
	}


	/*
	 * Returns one update by id
	*/
	public function findOneApplication($user_id,$project_id,$id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		$application = $this->em->getRepository ('\App\Entity\ProjectApplication')->findOneBy(array("id" => $id));
		if(!$application){ 	throw new \Exception("This application doesn't exists");}
		return $application;
	}
	
	/**
	 * Accept application from member
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $application_id
	 */
	public function acceptApplication($user_id,$project_id,$application_id){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		
		$application = $this->findOneApplication($user_id, $project_id, $application_id);
		
		if($application->level == 1){
				// create new role for project
				$newRole = new \App\Entity\ProjectRole($application->roleName, \App\Entity\ProjectRole::PROJECT_ROLE_TYPE_MEMBER);
				$project->addProjectRole($newRole);
				$application->user->addProjectRole($newRole); // add application to the member in application
				// set application to the new statea
				$application->setState(\App\Entity\ProjectApplication::APPLICATION_ACCEPTED);
				$application->setProjectRole($newRole); // set role for the application
				$this->em->flush();
		}
		
		// second level, find role, denied all other application except this one
		if($application->level == 2){
			echo "level 2";
			
			// find role for this application 
			
			$role = $this->findOneProjectRole($project_id, $application->projectRole->id);
			$role->setUser($application->user);
			
			// application set accepted
			$application->setState(\App\Entity\ProjectApplication::APPLICATION_ACCEPTED);
			$this->em->flush(); // save it
			
			// denied all other applications
			$applications = $this->findApplicationsForProjectRole($user_id, $project_id, $role->id,array('state' => 'new'));
			
				if(isset($applications)){
					foreach ($applications as $a){
						// set new state to the application
						$a->setState(\App\Entity\ProjectApplication::APPLICATION_DENIED);
						$a->setResult("Creator gave this position to someone else and haven't explain the reason why.");
				}
			}
			
			// create new role for project
			$this->em->flush();
		}
		

	}
	
	/**
	 * Create new role for project
	 * Members will be able to apply for this role
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 * @param unknown_type $level
	 * @throws \Exception
	 */
	public function createProjectRole($user_id,$project_id,$data=array(),$level = 2){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		
		// create new role for project
		$newRole = new \App\Entity\ProjectRole($data['role_name'], \App\Entity\ProjectRole::PROJECT_ROLE_TYPE_MEMBER);
		$newRole->setDescription($data['description']);
		$newRole->setLevel($level);
		
		$project->addProjectRole($newRole);
		$this->em->flush();
	}
	
	
	/**
	 * Update project role or description
	 * @param unknown_type $project_id
	 * @param unknown_type $role_id
	 * @param unknown_type $data
	 */
	public function updateProjectRole($user_id,$project_id,$role_id,$data = array()){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneBy(array("id" => $project_id,"user" => $user_id));
		if(!$project){
			throw new \Exception("Can't find this project for this user.");
		}
		
		// find role
		$role = $this->em->getRepository ('\App\Entity\ProjectRole')->findOneBy(array("id" => $role_id));
		if(!$role){
			throw new \Exception("This role doesn't exists");
		}
		
		// should be just one accepted application
		$applications = $this->findApplicationsForProjectRole($user_id, $project_id, $role_id,array('state'=> 'all'));
		
		// update description if is updated for the role
		if(count($applications) > 0){
			foreach ($applications as $a){	
				$a->setDescription($data['description']); // for consistency, update the role
			}
		}
		
		$role->setDescription($data['description']);
		$this->em->flush(); // save 
		
	}
	
	
		
	
	
	/**
	 * Accept application from member
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $application_id
	 */
	public function denyApplication($user_id,$project_id,$application_id,$data = array()){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
	
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$application = $this->findOneApplication($user_id, $project_id, $application_id);
	
		// set application to the new statea
		$application->setState(\App\Entity\ProjectApplication::APPLICATION_DENIED);
		
		// if creator doesn't fullfil the message
		if(trim($data['message']) ==""){
			$application->setResult("There is no reason written.");
		}
		else{
			$application->setResult($data['message']);
		}
		$this->em->flush();
	
	
	}
}

?>