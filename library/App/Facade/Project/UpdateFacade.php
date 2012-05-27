<?php
namespace App\Facade\Project;

use Doctrine\DBAL\Schema\Visitor\RemoveNamespacedAssets;

class UpdateFacade {
	/** @var Doctrine\Orm\EntityManager */
	private $em;

	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}
	
	/*
	 * Return the first layer of commments
	*/
	public function findUpdatesForProjectPaginator($project_id){
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
	
		$stmt = 'SELECT u FROM App\Entity\ProjectUpdate u WHERE u.project = ?1';
		$stmt .= 'ORDER BY u.created DESC  ';
	
		$query = $this->em->createQuery($stmt);
		$query->setParameter(1, $project_id);
			
		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
		$iterator = $paginator->getIterator();
	
		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
		return new \Zend_Paginator($adapter);
	}
	

	/*
	 * Returns one update by id
	*/
	public function findOneUpdate($user_id,$project_id,$id){
		
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$update = $this->em->getRepository ('\App\Entity\ProjectUpdate')->findOneBy(array("id" => $id));	
		if($update){
			return $update;
		}else {
			throw new \Exception("This update doesn't exists");
		}
	
	}
	
	/*
	 * Delete Update
	*/
	public function deleteUpdate($user_id,$project_id,$id){
	
		$update = $this->findOneUpdate($user_id, $project_id, $id);
		if($update->project->id == $project_id){
			$this->em->remove($update);
			$this->em->flush();
			
		}
		else {
			throw new \Exception("This update doesn't exists");
		}
	}
	
	/**
	 * Get data in Paginator
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @throws \Exception
	 */
	public function findProjectUpdates($user_id,$project_id){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}		
	
 		$stmt = 'SELECT a FROM App\Entity\ProjectUpdate a WHERE a.project = ?1';
 		$stmt .= 'ORDER BY a.id ASC';
		
 		$query = $this->em->createQuery($stmt);
 		$query->setParameter(1, $project_id);

 		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
 		$iterator = $paginator->getIterator();
 		
 		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
 		return new \Zend_Paginator($adapter);
 		
	}
	
	/**
	 * Update project survey
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $data
	 */
	public function createProjectUpdate($user_id,$project_id,$data = array()){
		// checking errors
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$project = $this->em->getRepository ('\App\Entity\Project')->findOneById ($project_id);
		if(!$project){
			throw new \Exception("Can't find this project.");
		}
		
		$newUpdate = new \App\Entity\ProjectUpdate($project, $data['title'], $data['content']);
		$this->em->persist($newUpdate);
		$this->em->flush();
	}
	
	/**
	 * Update Project Update
	 * @param unknown_type $user_id
	 * @param unknown_type $project_id
	 * @param unknown_type $update_id
	 * @param unknown_type $data
	 */
	public function updateProjectUpdate($user_id,$project_id,$update_id,$data = array()){		
		$update = $this->findOneUpdate($user_id, $project_id, $update_id);
			$update->setTitle($data['title']);
			$update->setContent($data['content']);
		$this->em->flush();
	}

}

?>