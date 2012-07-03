<?php
namespace App\Facade;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class ProjectFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	private $userFacade;
	private $taskFacade;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
		$this->userFacade = new \App\Facade\UserFacade($em);
		$this->taskFacade = new \App\Facade\Project\TaskFacade($em);
		
	}
	
	public function disableProjectWidget($user_id,$project_id,$data){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		if($project->user == $user){
			$project->setDisableRoleWidget($data['role_widget_disable']);
			$this->em->flush();
		} else {
			throw new \Exception("You are not allowed to change this property.");
		}
		
		
	}
	

	
	/*
	 * Returns one project by id
	 */
	public function findOneProject($id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ( $id );
		if($project){
			return $project;
		}else {
			throw new \Exception("This user doesn't exists");
		}
	
	}
	
	/**
	 * Adds log message to the user activity
	 * @param unknown_type $user
	 * @param unknown_type $message
	 */
	public function addLogMessage($project,$message){
		$lm = new \App\Entity\ProjectLog($message);
		$lm->setProject($project);
		$this->em->persist($lm);
		$this->em->flush();
	}
	
	/**
	 * Return all log information for user
	 * @param unknown_type $project_id
	 * @throws \Exception
	 */
	public function findLogForProject($project_id){
	
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if($project){
			return $this->em->getRepository ('\App\Entity\ProjectLog')->findByProject($project);
		}
		else{
			throw new \Exception("Can't find this project.");
		}
	}
	
	
 	/**
 	 * Handle new picture for the project. Delete the old files if its neccessary
 	 * @param unknown_type $user_id
 	 * @param unknown_type $project_id
 	 * @param unknown_type $path
 	 * @param unknown_type $fileName
 	 * @throws \Exception
 	 */
	public function updateProjectPicture($user_id,$project_id,$path,$filename){
		
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if($user){
			
			$project = $this->em->getRepository('\App\Entity\Project')->findOneBy(array("user" => $user,"id" => $project_id ));
			if($project == null){ throw new \Exception("Project for this user doesn't exists");}
			
				$imageManager = new \Boilerplate_Util_ImageManager($path);
				$ext = substr(strrchr($path,'.'), 1);
				$pre = substr($path,0,strrpos($path, '.'));
				
				$mediumImagePath = $pre.'_medium.'.$ext;
				$imageManager->resizeImage(240, 160, 'crop');
				$imageManager->saveImage($mediumImagePath, 100);
					
				$smallImagePath = $pre.'_small.'.$ext;
				$imageManager->resizeImage(130, 90, 'crop');
				$imageManager->saveImage($smallImagePath, 100);
					
				$largeImagePath = $pre.'_large.'.$ext;
				$imageManager->resizeImage(480, 320, 'crop');
				$imageManager->saveImage($largeImagePath, 100);
				// extenstion is the same, just rewrite the old files
				if($project->getPicture('orig') != $filename){
					// delete the old files which has different extension
					$oldExt= substr(strrchr($project->getPicture('orig'),'.'), 1);
					$delete = array();
					$delete[] = $pre.'_medium.'.$oldExt;
					$delete[] = $pre.'_small.'.$oldExt;
					$delete[] = $pre.'_large.'.$oldExt;
					$delete[] = $pre.'.'.$oldExt;
					
					foreach($delete as $deleteMe){
						if(is_file($deleteMe)){
							unlink($deleteMe);
						}
					}
				}
				
				$project->setPicture($filename);
				$this->em->flush(); // save to db
				$this->addLogMessage($project, "Updated Project Picture");
				
		} else {	
				throw new \Exception("User doesn't exists");
				}
		
		
		
		
	}
	
	/**
	 * Create basic project for user
	 * @param unknown_type $id
	 * @param unknown_type $dataFirstStep
	 * @param unknown_type $dataSecondStep
	 */
	public function createProject($id,$dataFirstStep = array(),$dataSecondStep = array(),$dataThirdStep = array(),$dataFourthStep = array()){
			
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $id );
		if($user){
				// find category
				$category = $this->em->getRepository ('\App\Entity\Category')->findOneBy(array("id"=> $dataFirstStep['category']));
				if($category){
				$newProject = new \App\Entity\Project($user, $category, 
													$dataFirstStep['title'], 
													$dataFirstStep['pitch'],
													$dataFirstStep['content'],
													$dataFirstStep['priority']);

				$newProject->setLesson($dataFirstStep['plan']);
				$newProject->setIssue($dataFirstStep['issue']);
				$newProject->setPlan($dataFirstStep['lesson']);

				$this->em->persist($newProject);
			
				// adding tags
				
				$tags_raw = $dataFirstStep['project_tags'];
				$clear_tags = parseTagsToArray($tags_raw);
				
						foreach($clear_tags as $tag){
							
							$tagObj = $this->em->getRepository ('\App\Entity\ProjectTag')->findOneBy(array("name"=> $tag));
							// exists, just add to the project
							if($tagObj){
								$newProject->addTag($tagObj);
							}else {
								// create new tag
								$tagNew = new \App\Entity\ProjectTag($tag);
								$newProject->addTag($tagNew);
							}
								
						}
				$this->em->flush(); // save to db
				
				// create project folder and save path for directory
				$config = new \Zend_Config(\Zend_Registry::get('config'));
				$path = $config->app->storage->project;
		
			//	echo $newProject->getId() .' + ' . $newProject->getUser()->getId();
				$dir = sha1($newProject->getId() .'+' . $newProject->getUser()->getId());
				
				rrmdir($path.$dir); // delete previous files
				mkdir($path.$dir); // creating of the new directory
	
				$newImagePath = $path.$dir.'/'.$dataSecondStep['fileName'];

				if (copy($dataSecondStep['absolutPath'],$newImagePath)) {
					
					//PROCESSING OF IMAGE
					// creating new thumbs
					$imageManager = new \Boilerplate_Util_ImageManager($newImagePath);
					$ext = substr(strrchr($newImagePath, '.'), 1);
					$pre = substr($newImagePath,0,strrpos($newImagePath, '.'));
					$mediumImagePath = $pre.'_medium.'.$ext;
					$imageManager->resizeImage(240, 160, 'crop');
					$imageManager->saveImage($mediumImagePath, 100);
					
					$smallImagePath = $pre.'_small.'.$ext;
					$imageManager->resizeImage(130, 90, 'crop');
					$imageManager->saveImage($smallImagePath, 100);
					
					$largeImagePath = $pre.'_large.'.$ext;
					$imageManager->resizeImage(480, 320, 'crop');
					$imageManager->saveImage($largeImagePath, 100);
						
					$newProject->setPicture($dataSecondStep['fileName']);
					echo $dataSecondStep['fileName'];
					$newProject->setDir($dir);
					$this->em->flush(); // save to db
					// TODO unlink($dataSecondStep['absolutPath']);
				} else {
					
					throw new \Exception("Can't copy the file." );
				}
				
				// creating roles for creator
				$arrayRoles = array(array("name" => \App\Entity\UserRole::MEMBER_ROLE_STARTER, ),
						array("name" => \App\Entity\UserRole::MEMBER_ROLE_LEADER),
						array("name" => \App\Entity\UserRole::MEMBER_ROLE_BUILDER),
						array("name" => \App\Entity\UserRole::MEMBER_ROLE_GROWER),
						array("name" => \App\Entity\UserRole::MEMBER_ROLE_ADVISER)
				);
				
				foreach($arrayRoles as $role){
					if($dataThirdStep['role_'.$role['name']] == 1 ){
						
						$newRole = new \App\Entity\ProjectRole($role['name'], \App\Entity\ProjectRole::PROJECT_ROLE_TYPE_CREATOR);
						$user->addProjectRole($newRole);
						$newProject->addProjectRole($newRole);
					}
				}
				
				$this->em->flush();
				
				// disable role widget and adding question
				if($dataThirdStep['role_widget_disable'] == 1){
					$newProject->setDisableRoleWidget(true);
				} else {
					// no change + create questions for new members
					for($i = 1; $i < 6; $i++){
						$q =$dataThirdStep['question_'.$i]; 					 
						if(strlen (trim($q)) > 0){
					 		$newQuestion = new \App\Entity\ProjectRoleWidgetQuestion($q);
					 		$newProject->addRoleWidgetQuestion($newQuestion);
					 	}
					}
				}
				
				$this->em->flush();
				
				// survey adding
				foreach($dataFourthStep as $key => $value){
					$id = substr(strrchr($key, '_'), 1);
					$question = $this->em->getRepository ('\App\Entity\ProjectSurveyQuestion')->findOneBy(array("id"=> $id));
					$newAnswer = new \App\Entity\ProjectSurveyAnswer($value,$newProject);
					$newAnswer->setQuestion($question);
				}
				$this->em->flush();
				// save answers
	
					// log
					$this->userFacade->addLogMessage($user, "Create new project ".$newProject->getTitle()." with ID ".$newProject->getId());
					$this->addLogMessage($newProject, "Project created");
					
				} else {	
					throw new \Exception("Category doesn't exists");
				}
					
				} else {
				
				throw new \Exception("User doesn't exists");
				}
		}
		
	public function	updateProject($user_id,$project_id,$data = array()){
			
		// check if user exists
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if($user){
		
			$project = $this->em->getRepository('\App\Entity\Project')->findOneBy(array("user" => $user,"id" => $project_id ));
			if($project == null){
				throw new \Exception("Project for this user doesn't exists");
					
			}

			$category = $this->em->getRepository ('\App\Entity\Category')->findOneBy(array("id"=> $data['category']));
			if($category){
				
				$project->setContent($data['content']);
				$project->setPitchSentence($data['pitch']);
				$project->setPriority($data['priority']);
				$project->setTitle($data['title']);
				$project->setCategory($category);
				$project->setLesson($data['plan']);
				$project->setIssue($data['issue']);
				$project->setPlan($data['lesson']);
				$project->setModified();
				
				// tags modification
				$oldTags = $project->getTagsArray();
				$newTags = parseTagsToArray($data['project_tags']);
				
				
				$tagsToAdd = array_diff($newTags,$oldTags);
				$tagsToDelete= array_diff($oldTags, $newTags);
				
				debug("to add");
				debug($tagsToAdd);
				debug($tagsToDelete);
							
				// adding tags
				foreach($tagsToAdd as $tagAdd){			
					$t = $this->em->getRepository("\App\Entity\ProjectTag")->findOneBy(array("name"=> $tagAdd));
					if($t){
						$project->addTag($t);
					}else{
						// add tag
						$newTag = new \App\Entity\ProjectTag($tagAdd);
						$project->addTag($newTag);
					}
				}
				
				foreach($tagsToDelete as $delTag){	
 					// get tag
					$tagDelObj = $project->getTag($delTag);
 					if($tagDelObj){
 						$project->removeTag($tagDelObj);
						// if the tag doesn't have any follower
 						if($tagDelObj->getCountOfProjects() == 0){
 							$this->em->remove($tagDelObj);
						}
					}
 				}
				
				$this->em->flush();
				$this->userFacade->addLogMessage($user, "Update project ".$project->getTitle()." with ID ".$project->getId());
				$this->addLogMessage($project, "Project description updated.");
			}else {
				throw new \Exception("Category  doesn't exists");
				
			}			
		}
		else {
			throw new \Exception("User doesn't exists");
		
		}	
	}
	/**
	 * Adds creator roles
	 * @param unknown_type $id_project
	 * @param unknown_type $data
	 */
	public function addCreatorRoleToProject($id_project,$data = array()){
		
	}
	
	/**
	 * Return all users
	 */
	public function findAllProjects(){
		$projects = $this->em->getRepository ('\App\Entity\Project')->findThemAll();
		return $projects;
	
	}
	
	public function findProjectForUser($user_id,$project_id){
		// check if user exists
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if($user){
				
			$project = $this->em->getRepository('\App\Entity\Project')->findOneBy(array("user" => $user,"id" => $project_id ));
			if($project == null){
				throw new \Exception("Project for this user doesn't exists");	
			}
			return $project;		
		}
		else {
			throw new \Exception("User doesn't exists");		
		}	
	}
	
	public function findAllProjectsForUser($user_id){
		// check if user exists
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
	
		if(!$user){	throw new \Exception("User doesn't exists");}
		
		$projects = $this->em->getRepository('\App\Entity\Project')->findBy(array("user" => $user));	
		return $projects;	
	}
	
	

	
	
	
	/**
	 * Return all categories in array / used for form
	 */
	public function findAllProjectCategoriesArray(){
		$categories = $this->em->getRepository ('\App\Entity\Category')->findThemAll();
		$arr = array(); 
		if(count($categories) > 0) {
			foreach ($categories as $cat){	
				$arr[$cat->id] = $cat->name;
			}	
		}
		return $arr;
	}
	

	
}

?>