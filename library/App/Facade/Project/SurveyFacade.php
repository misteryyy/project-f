<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class SurveyFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
	}
	
	
	/**
	 * Get answers for project survey Paginator
	 */
	public function findProjectSurveyAnswersPaginator($project_id){
			
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}

		$stmt = 'SELECT a FROM App\Entity\ProjectSurveyAnswer a WHERE a.project = ?1';
		$stmt .= 'ORDER BY a.id ASC';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
			
		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
		$iterator = $paginator->getIterator();
	
		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
		return new \Zend_Paginator($adapter);
			
	}
	
	
	/**
	 * Get answers for project survey
	 */
	public function findProjectSurveyAnswers($user_id,$project_id){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}		
	
		
 		$stmt = 'SELECT a FROM App\Entity\ProjectSurveyAnswer a WHERE a.project = ?1';
 		$stmt .= 'ORDER BY a.id ASC';
		
 		$query = $this->em->createQuery($stmt);
 		$query->setParameter(1, $project_id);
 		return $query->getResult();
 		
	}
	
	/**
	 * Return all questions for project in array / used for form suvey
	 */
	public function findAllProjectSurveyQuestionsArray(){
		$qs = $this->em->getRepository ('\App\Entity\ProjectSurveyQuestion')->findThemAll();
		$arr = array();
		if(count($qs) > 0) {
			foreach ($qs as $q){
				$arr[$q->id] = $q->question;
			}
		}
		return $arr;
	}
	
	/**
	 * Update project survey
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 */
	public function updateProjectSurvey($user_id,$project_id,$data = array()){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		// survey adding
		foreach($data as $key => $value){
			$id = substr(strrchr($key, '_'), 1); // get id of question
			$answer = $this->em->getRepository ('\App\Entity\ProjectSurveyAnswer')->findOneBy(array("id"=> $id));
			$answer->setAnswer($value);
		}
		$this->em->flush();
	}
	
	
	/**
	 * Return collection of answers for the project, which are empty
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @throws \Exception
	 */
	public function findEmptyAnswers($user_id,$project_id){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$stmt = "SELECT a FROM App\Entity\ProjectSurveyAnswer a WHERE a.answer = '' AND a.project = ?1 ";
		$stmt .= 'ORDER BY a.id ASC';
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
		return $query->getResult();
		
		
		
	}
	
	
}

?>