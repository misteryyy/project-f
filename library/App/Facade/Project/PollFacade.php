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
	public function findOneQuestionForProjectPoll($project_id,$poll_id){
 		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
 		if(!$project){
 			throw new \Exception("Can't find this project.");
 		}
		
 		$q = $this->em->getRepository ('\App\Entity\ProjectPollQuestion')->findOneBy(array("id" => $poll_id));
		
 		if($q){
 			return $q;
 		}else {
 			throw new \Exception("This question doesn't exists");
 		}
	
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
		
		// create new poll
		$poll = new \App\Entity\ProjectPoll($data['title'], $project);
		$this->em->persist($poll);
		
		// create questions
		// go through all questions
		$attLeastOneQuestion = false;
		for($i = 1; $i < 6; $i++){
			$q =$data['question_'.$i];
			if(strlen (trim($q)) > 0){
					$question = new \App\Entity\ProjectPollQuestion($q, $poll);
					$attLeastOneQuestion = true;
					$this->em->persist($question);
			}
		}
		
		// check there is at least one question
		if($attLeastOneQuestion === false) {throw new \Exception("You should have at least one question for your poll.");}

		// save the data
		$this->em->flush();
	}
	
	
	/**
	 * Find the last polls for project
	 * @param unknown_type $project_id
	 */
	public function findTheLastPollForProject($project_id){
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$stmt = 'SELECT p FROM App\Entity\ProjectPoll p WHERE p.project = ?1';
 		$stmt .= 'ORDER BY p.created DESC';
		
 		$query = $this->em->createQuery($stmt);
 		$query->setParameter(1, $project_id);
		
 		$polls = $query->getResult();
		
 		
 		if(count($polls) > 0){
 				return $polls[0];
 		}
 		else {
 				throw new \Exception("There is not poll for this project");
 		}	
	}
	
	
	
	/**
	 * Find poll for project
	 * @param unknown_type $poll_id
	 */
	public function findOnePollForProject($poll_id){
		
		$poll = $this->em->getRepository ('\App\Entity\ProjectPoll')->findOneBy(array("id" => $poll_id));
		if($poll){
			return $poll;
		}else {
			throw new \Exception("This poll doesn't exists");
		}
		
	}
	
	
	/**
	 * Find all answers for specifil poll and user
	 * @param unknown_type $user_id
	 * @param unknown_type $poll_id
	 */
	public function findAllAnswersForUser($project_id, $user_id,$poll_id){
		
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$stmt = 'SELECT a FROM App\Entity\ProjectPollAnswer a WHERE  a.user = ?1 AND a.poll = ?2 ';
		$stmt .= 'ORDER BY a.id ASC';
		
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $user_id);
		$query->setParameter(2, $poll_id);
		
		$polls = $query->getResult();
		
		return $polls;
		
		
	}
	
	/**
	 * Delete all answers for member who has voted for Poll
	 * @param unknown_type $project_id
	 * @param unknown_type $user_id
	 * @param unknown_type $poll_id
	 */
	public function deleteAllAnswersForPollAndUser($project_id,$user_id,$poll_id){
		
		$answers = $this->findAllAnswersForUser($project_id, $user_id, $poll_id);
		
		if($answers){
			foreach ($answers as $a){
				$this->em->remove($a);
			}	
		}
		$this->em->flush(); // save persistence
	}
	
	/**
	 * Answer poll
	 * @param unknown_type $project_id
	 * @param unknown_type $user_id
	 * @param unknown_type $poll_id
	 * @param unknown_type $data
	 * @throws \Exception
	 */
	public function answerPoll($project_id,$user_id,$poll_id,$data = array()){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		// find poll
		$poll = $this->findOnePollForProject($poll_id);
		unset($data['poll_id']); // leave just answers
		
		
		// delete previous answers
		$this->deleteAllAnswersForPollAndUser($project_id, $user_id, $poll_id);
		
		// creating anwers
		foreach($data as $key => $value){
	 			$question_id = substr(strrchr($key, '_'), 1);
	 			// find question
	 			$question = $this->findOneQuestionForProjectPoll($project_id,$question_id);
	 			$a = new \App\Entity\ProjectPollAnswer($user, $value, $question, $poll); // create new answer for this user
	 			$this->em->persist($a);	 			
		}
		
		$this->em->flush(); // save data

	}
	
	
	/*
	 * Return the paginator
	*/
	public function findAllPollsForProjectPaginator($project_id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$stmt = 'SELECT p FROM App\Entity\ProjectPoll p WHERE p.project = ?1';
		$stmt .= 'ORDER BY p.created ASC';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
			
		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
		$iterator = $paginator->getIterator();
	
		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
		return new \Zend_Paginator($adapter);
	}
	
	
	
	
	
	
}

?>