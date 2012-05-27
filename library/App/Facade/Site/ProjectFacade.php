<?php
namespace App\Facade\Site;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

/**
 * Public Project Facade
 * @author misteryyy
 *
 */
class ProjectFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	private $userFacade;
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
		$this->userFacade = new \App\Facade\UserFacade($em);
	}
	
	
	/*
	 * Returns one project by id
	 */
	public function findOneProject($id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ( $id );
		if($project){
			return $project;
		}else {
			throw new \Exception("This project doesn't exists");
		}
	
	}
	
	/**
	 * Return all users
	 */
	public function findAllProjectsPaginator($options=array()){
		
			$stmt = 'SELECT p FROM App\Entity\Project p ';
			$stmt .= 'ORDER BY p.created DESC';
			$query = $this->em->createQuery($stmt);
				
			$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
			$iterator = $paginator->getIterator();
			$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
			return new \Zend_Paginator($adapter);	
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
	
	public function findAllProjectsForUser($id){
		// check if user exists
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $id );
	
		if($user){	
			$projects = $this->em->getRepository('\App\Entity\Project')->findBy(array("user" => $user));	
			return $projects;
			
		}else {
			throw new \Exception("User doesn't exists");		
		}	
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