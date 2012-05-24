<?php
namespace App\Facade\Member;
use Doctrine\ORM\Tools\Pagination as Paginator; // goes at top of file

class FloBoxFacade {
	
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}
	
	/*
	 * Returns one update by id
	*/
	public function findOneMessage($user_id,$flobox_id){
	
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}
		
		$message = $this->em->getRepository ('\App\Entity\UserFloBox')->findOneBy(array("id" => $flobox_id));
		if($message){
			return $message;
		}else {
			throw new \Exception("This message doesn't exists");
		}
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
			$floMessage = new \App\Entity\UserFloBox($user, $data['type'], $data['typeDetail'], $data['title'], $data['message']);
			$this->em->persist($floMessage);
			$this->em->flush();
		
		} else {
			throwException("Can't find this user.");
		}
	}
	
	/*
	 * Delete FloBox Message
	*/
	public function deleteMessage($user_id,$id){
		$message = $this->findOneMessage($user_id, $id);
		
		if($message->user->id == $user_id){
			$this->em->remove($message);
			$this->em->flush();
			
		} else {
			throw new \Exception("This message doesn't exists");	
		}
	}
	
	/**
	 * 
	 * @param int $idUser
	 * @param int $idMessage
	 * @param string $text
	 */
	public function createComment($user_id,$flobox_id,$data=array()){	
			
			$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
			if(!$user){
				throw new \Exception("Member doesn't exists");
			}
		
			$flobox = $this->em->getRepository ('\App\Entity\UserFloBox')->findOneBy(array("id" => $flobox_id));
			if($flobox){				
				$newComment =  new \App\Entity\UserFloBoxComment($user, $data['content']);
				$flobox->addComment($newComment);
				$this->em->flush();	
				// create comment
			}else {
			
				throw new \Exception("This message doesn't exists");
			}	
	}
	
	/**
	 * Return paginator to the data
	 * @param user_id $user_id
	 * @param unknown_type $options
	 */
	public function findFloMessages($user_id,$options=array()){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $user_id );
		if(!$user){
			throw new \Exception("Member doesn't exists");
		}

		$stmt = 'SELECT m FROM App\Entity\UserFloBox m ORDER BY m.created DESC';
		
		$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($this->em->createQuery($stmt));
		$iterator = $paginator->getIterator();
		
		$adapter = new \Zend_Paginator_Adapter_Iterator($iterator);
		return new \Zend_Paginator($adapter);

	}
	
	
	

}

?>