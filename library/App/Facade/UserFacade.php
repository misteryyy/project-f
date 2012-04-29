<?php
namespace App\Facade;

class UserFacade {
	
	/** @var Doctrine\Orm\EntityManager */
	private $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em){
		
		$this->em = $em;
	}
	
	/*
	 * Creates new account
	 */
	public function createAccount($data){

		$user = new \App\Entity\User();
		$user->setEmail($data['email']);
		$user->setPassword($data['password']);
		$user->setName($data['name']);
		$user->setConfirmed(1); // confirmed // we can find the use for this latter
	
		// setting user info
		$userInfo = new \App\Entity\UserInfo();
		$user->setUserInfo($userInfo);
		
		$this->em->persist($user);
		$this->em->flush();

		// TODO SENDING EMAIL
		// $mailer = new \App\Mailer\HtmlMailer();
		// $mailer->setSubject("Welcome to FLO~ Platform")
		// ->addTo($data['email'])
		// ->setViewParam('name',"Josef Kortan")
		// ->sendHtmlTemplate("welcome.phtml");
		
		
	}

	/**
	 * Update information about user
	 * @param unknown_type $id
	 * @param unknown_type $data
	 */
	public function updateInfo($id,$data = array()){
		
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $id );
			
		if($user){
			//$user = new \App\Entity\User();
			// update basic information in user entity	
			$user->setDescription($data['description']);
			$user->setName($data['name']);
			$user->setCountry($data['country']);
			$user->setDateOfBirthVisibility($data['dateOfBirthVisibility']);
			$user->setEmailVisibility($data['emailVisibility']);
				
			// TODO Parse The date
			$user->setDateOfBirth($data['dateOfBirth']);
				
				// UserInfo already exists just update it
				$info = $user->getUserInfo();
				$info->setSkype($data['skype']);
				$info->setPhone($data['phone']);
				$info->setIm($data['im']);
				$info->setWebsite($data['website']);	
				
				// delete all tags -> empty textfield
				if(strlen(trim($data['fieldOfInterestTag'])) <= 0){
					$userTags = $user->getUserFieldOfInterestTags();
					// Delete previsou tag from the database
					if(!empty($userTags)){
						foreach($userTags as $tag){
								//check if the tag is not the same
								$user->removeUserFieldOfInterestTag($tag);
								// noone else has this tag, delete it from database
								if($tag->getUsers()->count() == 0){
									$this->em->remove($tag); // delete entity tag
								}
						}
					}
					$this->em->flush();
				}
				
				
				// user has some tags
				if(strlen(trim($data['fieldOfInterestTag'])) > 0){
				
					$tags = explode(',', $data['fieldOfInterestTag']);
					$tags = trimArray($tags);
					
				// delete all tags before update them
						$userTags = $user->getUserFieldOfInterestTags();				
						// Delete previsou tag from the database
		  				if(!empty($userTags)){
		  				  	foreach($userTags as $tag){			

		  				  		if(!in_array($tag->getName(), $tags)){ //check if the tag is not the same
		  				  		$user->removeUserFieldOfInterestTag($tag);
		 						// noone else has this tag, delete it from database
		 					 	if($tag->getUsers()->count() == 0){
									//echo "Number of users for this tag " . $tag->getUsers()->Count();
									
		 					 		$this->em->remove($tag); // delete entity tag
								}
		 					 	}
		 				  	}	
		 				}
		 	//	$this->em->flush(); // flush because we need to update current tags, when this are deleted
 				
		 		// addTags
 					
 				foreach ($tags as $tag_string){
					$tag = $this->em->getRepository("\App\Entity\UserFieldOfInterestTag")->findOneBy(array("name"=> $tag_string));
					if($tag){
						echo $tag->getName();
						//$user->addUserTag($tag);
					}else {
						$tagObj = new \App\Entity\UserFieldOfInterestTag();
						$tagObj->setName($tag_string);
						$user->addUserFieldOfInterestTag($tagObj);
					}	
				}	
				
				$this->em->flush();
				
				}	
		
		} else {
			throwException("Can't find this user.");
		}
		
	}
	
	/**
	 * 
	 * @param unknown_type $id
	 */
	public function findUserSettings($id){
		$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $id );
		
		if($user){
			return $user;
		} else {
			throwException("Can't find this user.");
		}
		
	}
	
	
	

}

?>