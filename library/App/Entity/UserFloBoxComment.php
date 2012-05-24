<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\UserFloBoxComment")
 * @Table(name="user_flo_box_comment",indexes={@index(name="search_flo_box_comment",columns={"flo_box_id"})})
 */
class UserFloBoxComment {
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @Column(type="datetime",name="created")
	 */
	private $created;

	/**
	 * @Column(type="string", name="content",nullable=true)
	 */
	private $content;
	
	/**
	 * @ManyToOne(targetEntity="UserFloBox", inversedBy="comments", cascade={"persist","delete"})
	 * @JoinColumn(name="flo_box_id", referencedColumnName="id")
	 */
	private $flobox;

	/**
	 * @ManyToOne(targetEntity="User")
	 * @JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;
	
	/**
	 *
	 * @param $name unknown_type       	
	 */
	public function __construct($user,$content) {
		$this->content = $content; 
		$this->user = $user;
		$this->created = new \DateTime ( "now" );
		
	}
	
	public function addFlobox($f){
		$this->flobox = $f;
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