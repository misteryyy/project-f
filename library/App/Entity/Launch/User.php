<?php
namespace App\Entity\Launch;

/**
 * @Entity(repositoryClass="App\Repository\Launch\User")
 * @Table(name="launch_user",indexes={@index(name="search_launch_user_email",columns={"email"})})
 */
class User {
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	

	/**
	 * @Column(type="string", name="name")
	 */
	private $name;
	
	/**
	 * @Column(type="string", name="email",unique=true)
	 */
	private $email;
	
		
	/**
	 * @Column(type="boolean", name="location",nullable=true)
	 */
	private $location;
	
	/**
	 * @Column(type="string", name="password")
	 */
	private $password;
	
	/**
	 * @column(type="datetime",name="created",nullable=true)
	 */
	public $created;

	/**
	 * Construct for Launch User Beta
	 * @param unknown_type $name
	 * @param unknown_type $email
	 * @param unknown_type $location
	 * @param unknown_type $password
	 */
	public function __construct($name,$email,$location,$password) {
		$this->created = new \DateTime("now");
		$this->password = sha1 ( $password );
		$this->location = $location;
		$this->name = $name;
		$this->email = $email;
		
	}
	

	public function getId(){
		return $this->id;
	}

		
	public function setPassword($value) {
		$this->password = sha1 ( $value );
	}
	
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setName($value) {
		$this->name =  $value ;
	}
	
	
	public function getName() {
		return $this->name;
	}
	
	public function setEmail($value) {
		$this->email =  $value ;
	}
	
	
	public function getEmail() {
		return $this->email;
	}
	
	
	public function __get($property) {
		// If a method exists to get the property call it.
		if (method_exists ( $this, 'get' . ucfirst ( $property ) )) {
			// This will call $this->getPassword() while getting $this->password
			return call_user_func ( array ($this, 'get' . ucfirst ( $property ) ) );
		} else {
			return $this->$property;
			
		}
	}
	
	public function __set($property, $value) {
		// If a method exists to set the property call it.
		if (method_exists ( $this, 'set' . ucfirst ( $property ) )) {
			// This will call $this->setPassword($value) while setting
			// $this->password
			return call_user_func ( array ($this, 'set' . ucfirst ( $property ) ), $value );
		} else {
			$this->$property = $value;
		}
	}
}
    
   