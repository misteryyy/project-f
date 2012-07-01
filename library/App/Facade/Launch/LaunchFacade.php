<?php
namespace App\Facade\Launch;
use Doctrine\ORM\Tools\Pagination as Paginator; // goes at top of file

class LaunchFacade {
	
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}
	
	/**
	 * Add email for newsletter Beta Launch
	 * @param unknown_type $data
	 */
	public function createNewsleter($data){
		
		$nl = new \App\Entity\Launch\Newsletter($data['email']);
		$this->em->persist($nl);
		$this->em->flush();
	}
	
	
	/**
	 * Get all registered newsletter
	 */
	public function findNewslettersArray(){
		return $this->em->getRepository('\App\Entity\Launch\Newsletter')->findAll();
		
	}
		
	/**
	 * Return the account of all registrated members for beta account
	 */
	public function findBetaAccounts(){
		return $this->em->getRepository('\App\Entity\Launch\User')->findAll();
	}
	
	
	/*
	 * Creates BETA Account
	*/
	public function createBetaAccount($data){
		// check if the email exists 
		// finding user
		$user = $this->em->getRepository ('\App\Entity\Launch\User')->findOneByEmail ( $data['email'] );
		if($user) {throw new \Exception("This email is already registered. You can't use this email.");}

		$user = new \App\Entity\Launch\User($data['name'],$data['email'] ,$data['location'], $data['password']);
		$this->em->persist($user);
		$this->em->flush();
	
		// TODO SENDING EMAIL
		 $mailer = new \App\Mailer\HtmlMailer();
		 $mailer->setSubject("Welcome to FLO~ Platform")
		 ->addTo($data['email'])
		 ->setViewParam('name',"Josef Kortan")
		 ->sendHtmlTemplate("welcome-beta.phtml");
	}
	

}

?>