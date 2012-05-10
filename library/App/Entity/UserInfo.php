<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\UserInfo")
 * @Table(name="user_info")
 */
class UserInfo {

	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
		
	
	/**
	 * @Column(type="string", name="skype",nullable=true)
	 */
	private $skype;
	
	/**
	 * @Column(type="string", name="im",nullable=true)
	 */
	private $im;
	
	/**
	 * @Column(type="string", name="phone",nullable=true)
	 */
	private $phone;
	
	/**
	 * @Column(type="string", name="website",nullable=true)
	 */
	private $website;

	public function __construct(){
		$this->im = "";
		$this->skype = "";
		$this->website = "";
		$this->phone = "";	
	}

	/**
	 * @return the $skype
	 */
	public function getSkype() {
		return $this->skype;
	}

	/**
	 * @return the $im
	 */
	public function getIm() {
		return $this->im;
	}

	/**
	 * @return the $phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @return the $website
	 */
	public function getWebsite() {
		return $this->website;
	}


	/**
	 * @param field_type $skype
	 */
	public function setSkype($skype) {
		$this->skype = $skype;
	}

	/**
	 * @param field_type $im
	 */
	public function setIm($im) {
		$this->im = $im;
	}

	/**
	 * @param field_type $phone
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * @param field_type $website
	 */
	public function setWebsite($website) {
		$this->website = $website;
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
    
   