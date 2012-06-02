<?php
namespace App\Entity;
class UserSettingInfoTest extends \ModelTestCase {
	
	public function testCanCreateUser() {
		$this->assertInstanceOf ( 'App\Entity\User', new User () );
	}
	
	
	public function saveUser() {
		$u1 = new User ();
		$u1->setName("Josef");
		$pass = "thisispass";
		$u1->setPassword($pass);
		$u1->setEmail("j.test@gmail.com");
		$u1->setConfirmed(1);
		$this->em->persist ( $u1 );
		$this->em->flush ();
		
		$userInfo = new \App\Entity\UserInfo();
		//$user->setUserInfo($userInfo);
		$userInfo->setUser($u1);
		$em->persist($userInfo);

		
		
		// Second User
		$user2 = new \App\Entity\User();
		$user2->setEmail("j.kortan@gmail.com");
		$user2->setPassword("pi2131221");
		$user2->setName("Josef Kortan");
		
		
		
		
		//$em->persist($user);
		//$userInfo->setUser($user);
		
// 		$em->flush();
		
		$user = $em->getRepository ('\App\Entity\User')->findOneById ( 1);
// 		$info = $em->getRepository ('\App\Entity\UserInfo')->findOneById ( 1);
// 		$info->setIm("bllllalalalalalal");
// 		$user->getUserInfo()->setIm("neeeeww");
// 		$em->flush();
		
		
		
// 		// adding people to account
// 		$user2 = new \App\Entity\User();
// 		$user2->setEmail("jtan@gmail.com");
// 		$user2->setPassword("pi2131221");
// 		$user2->setName("Fil Kortan");
// 		$em->persist($user2);
// 		$em->flush();
		
		
// 		$user = $em->getRepository ('\App\Entity\User')->findOneById ( 1);
// 		$user2 = $em->getRepository ('\App\Entity\User')->findOneById ( 2);
		
		
// 		// Adding tags
// 		$tag = new \App\Entity\UserTag();
// 		$tag->setName("poetry");
		
		
// 		//$tag2 = new \App\Entity\UserTag();
// 		//$tag2->setName("piiiiiii");
		
// 		$user->addUserTag($tag);
// 		$user2->addUserTag($tag);
		
// 		$tag2 = new \App\Entity\UserTag();
// 		$tag2->setName("literatur");
// 		$user2->addUserTag($tag2);
		
// 		//$user->addUserTag($tag2);
		
// 		$em->flush();
		
		
		
		
	}
	
	public function findUser(){
		
		
		
	}
	

	/*
	 * Username already exists?
	 */
	public function findEmail($email = "j.test@gmail.com") {
		$users = $this->em->createQuery ( " SELECT PARTIAL u.{id} FROM App\Entity\User u WHERE u.email = ?1 " )->setParameter ( 1, $email )->execute ();
		return count ( $users );
	}
	
	
}