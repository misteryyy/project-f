<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\User")
 * @Table(name="user",indexes={@index(name="search_idx",columns={"email"})})
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
	 * @Column(type="string", name="password")
	 */
	private $password;
	
	
	/** @Column(type="smallint",name="confirmed",nullable=true) */
	private $confirmed;

	
	/**
	 *
	 * @param $property \Doctrine\Common\Collections\Collection
	 *       	 @OneToMany(targetEntity="Project",mappedBy="user",
	 *        	cascade={"persist","remove"})
	 */
	private $projects;
	
	/**
	 * @ManyToMany(targetEntity="UserTag", inversedBy="user_tag",
	 * cascade={"persist,remove"})
	 * @JoinTable(name="user_has_user_tag",
	 * joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
	 * inverseJoinColumns={@JoinColumn(name="user_tag_id",referencedColumnName="id")})
	 */
	private $user_tags;
	
	public function __construct() {
		$this->user_tags = new \Doctrine\Common\Collections\ArrayCollection ();
	
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
    
   