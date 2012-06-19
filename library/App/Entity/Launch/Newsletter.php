<?php
namespace App\Entity\Launch;
/**
 * @Entity(repositoryClass="App\Repository\Launch\Newsletter")
 * @Table(name="launch_newsletter")
 */
class Newsletter
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", name="email") */
    private $email;
    
    /** @Column(type="string", name="ip") */
    private $ip;
    
    /**
     * @Column(type="datetime",name="date")
     */
    private $date;
    

    /**
     * Initialization of Collections
     */
    public function __construct($email){
		$this->email = $email;	
		$this->date = new \DateTime ( "now" );
    	$this->ip = getRealIpAddr();
    }
    
    public function getId()
    {
    	return $this->id;
    }

    
    /**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $ip
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param field_type $email
	 */
	public function setEmail($email) {
		$this->email = $email;
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