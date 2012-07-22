<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class PollFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}	
	

	
	
	/**
	 * 
	 * @param unknown_type $project_id
	 * @param unknown_type $id
	 * @throws \Exception
	 */
	public function findOneAnswerForProjectPoll($project_id,$user_id,$id){
// 		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
// 		if(!$project){
// 			throw new \Exception("Can't find this project.");
// 		}
		
// 		$q = $this->em->getRepository ('\App\Entity\ProjectTask')->findOneBy(array("id" => $id));
		
		
// 		if($q){
// 			return $q;
// 		}else {
// 			throw new \Exception("This task doesn't exists");
// 		}
	
	}
		
	
	/**
	 * Create new task for the project 
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 * @throws \Exception
	 */
	public function createPoll($user_id,$project_id,$data){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}

		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		print_r($data);
		// create questions
		// go through all questions
		$attLeastOneQuestion = false;
		for($i = 1; $i < 6; $i++){
			$q =$data['question_'.$i];
			if(strlen (trim($q)) > 0){
					$attLeastOneQuestion = true;
			}
		}
		
		// check there is at least one question
		if($attLeastOneQuestion === false) {throw new \Exception("You should have at least one question for your poll.");}

		
	}
	
	
	
	
}

?>