<?php
/**
 * @class Boilerplate_Auth_Adapter_Doctrine2
 *
 * @author misteryyy
 */

class Boilerplate_Auth_Adapter_Doctrine2 implements Zend_Auth_Adapter_Interface {	
	
	/**
	 * Doctrine EntityManager
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $_em;
	
	private $email;
	private $password;
	
	public function __construct($email, $password) {
		$this->email = $email;
		$this->password = sha1($password); // password is encoded
		$this->_em = Zend_Registry::get ('em');
		
	}
		
	public function authenticate() {
		
		// Try to fetch the user from the database using the model
		$user = $this->_em->getRepository ('\App\Entity\User')->findOneBy ( array ('email' => $this->email, 'password' => $this->password ) );
		

		
		// Initialize return values
		$code = Zend_Auth_Result::FAILURE;
		$identity = null;
		$messages = array ();
		
		// is the user valid?
		if ($user) {
			$userArray = array();
			$userArray["name"] =$user->getName();
			$userArray["email"] =$user->getEmail();
			$userArray["id"] =$user->getId();
			$userArray["roles"] =$user->getRoles();
			$userArray["profile_picture_200"] =$user->getProfilePicture();
				
	
			$code = Zend_Auth_Result::SUCCESS;
			$identity = $userArray;
		} else {
			$messages [] = 'Authentication error';
		}
		
		return new Zend_Auth_Result ( $code, $identity, $messages );
	}
}

?>