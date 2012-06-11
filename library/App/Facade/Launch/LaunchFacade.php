<?php
namespace App\Facade\Launch;
use Doctrine\ORM\Tools\Pagination as Paginator; // goes at top of file

class LaunchFacade {
	
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){	
		$this->em = $em;
	}
	
	
	/*
	 * Creates BETA Account
	*/
	public function createBetaAccount($data){
	
		// check if the email exists 
		// finding user
		debug($data);
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
		 ->sendHtmlTemplate("welcome.phtml");
		// log
	
	
	
	}
	

}

?>