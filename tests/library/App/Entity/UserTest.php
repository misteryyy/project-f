<?php
namespace App\Entity;
class UserTest extends \ModelTestCase {
	
 	public function testCanCreateUser() {
 		$this->assertInstanceOf ( 'App\Entity\User', new User () );
 	}
	
// 	public function saveUser() {
// 		$u = new User ();
// 		$u->name = "Jimmy";
// 		$pass = "thisispass";
// 		$u->password = $pass;
// 		$u->email = "j.test@gmail.com";
// 		$u->confirmed = 0;
		
// 		$this->em->persist ( $u );
// 		$this->em->flush ();
	
// 	}
	
// 	/*
// 	 * Sign Up test
// 	 */
// 	public function testSignUp() {		
// 		$this->saveUser ();
		
// 		$users = $this->em->createQuery ( 'select u from App\Entity\User u' )->execute ();
// 		$this->assertEquals ( 1, count ( $users ) );
// 		$pass = "thisispass";
// 		$this->assertEquals ( 1, $this->findEmail ( $users [0]->email ) );
// 		$this->assertEquals ( 'Jimmy', $users [0]->name );
// 		$this->assertEquals ( sha1 ( $pass ), $users [0]->password );
// 		$this->assertEquals ( 'j.test@gmail.com', $users [0]->email );
		
// 		$user = $this->em->getRepository ('\App\Entity\User')->findOneBy ( array ('email' => 'j.test@gmail.com', 'password' => sha1($pass) ) );
// 		$this->assertEquals ( 'Jimmy', $user->name );
		
		
		
// 	}
	
// 	/*
// 	 * Username already exists?
// 	 */
// 	public function findEmail($email = "j.test@gmail.com") {
// 		$users = $this->em->createQuery ( " SELECT PARTIAL u.{id} FROM App\Entity\User u WHERE u.email = ?1 " )->setParameter ( 1, $email )->execute ();
// 		return count ( $users );
// 	}
	
// 	/*
// 	 * Check if user exists
// 	 */
// 	public function findUserByEmailAndPassword($email, $pass) {
		
// 		$users = $this->em->createQuery ('SELECT u FROM App\Entity\User u WHERE u.email = ?1 AND u.password = ?2 ')->setParameter ( 1, $email )->setParameter ( 2, sha1 ( $pass ) )->execute ();
// 		return $users;
	
// 	}
	
// 	public function testLogin() {
// 		$this->saveUser ();
// 		$email = "j.test@gmail.com";
// 		$pass = "thisispass";
// 		$users = $this->findUserByEmailAndPassword ( $email, $pass );
// 		$this->assertEquals ( 1, count ( $users ) );
// 		$this->assertEquals ( sha1 ( $pass ), $users [0]->password );
// 		$this->assertEquals ( $email, $users [0]->email );
	
// 	}
}