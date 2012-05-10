<?php
namespace App\Facade;
use Doctrine\ORM\Tools\Pagination as Paginator;

class FloBoxFacade {
	
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
	}
	
	
	/**
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $data
	 */
	public function createFloMessage($id,$data = array()){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $id );	
		if($user){
			debug($data);			
			$floMessage = new \App\Entity\UserFloBoxMessage($user, $data['type'], $data['typeDetail'], $data['title'], $data['message']);
			$this->em->persist($floMessage);
			$this->em->flush();
		
		} else {
			throwException("Can't find this user.");
		}
	}
	
	
	/**
	 * 
	 * @param int $idUser
	 * @param int $idMessage
	 * @param string $text
	 */
	public function createCommentToFloMessage($idUser,$idMessage,$text){
		//	find if user exists
			
	}
	
	/**
	 * Return paginator to the data
	 * @param unknown_type $id
	 * @param unknown_type $options
	 */
	public function findFloMessages($id,$options=array()){
		
		
	}
	
	
	

}

?>