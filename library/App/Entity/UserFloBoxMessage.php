<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\UserFloBoxMessage")
 * @Table(name="user_flo_box_message")
 */
class UserFloBoxMessage
{
	const MESSAGE_TYPE_INTEREST = "interest";
	const MESSAGE_TYPE_PROBLEM = "problem";
	const MESSAGE_TYPE_CHOICE = "choice";
	
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    
    /** @ManyToOne(targetEntity="User")
     *	@JoinColumn(name="user_id",referencedColumnName="id")
     *
     */
    private $user;

    /**
     * Set user for this message
     * @param unknown_type $user
     */
    public function setUser($user){
    	$this->user = $user;
    }
    
    /** @Column(type="string", name="title") */
    private $title;
    
    /** @Column(type="string", name="type") */
    private $type;
    
    /** @Column(type="string", name="type_detail") */
    private $typeDetail;
    
    /** @Column(type="datetime", name="created") */
    private $created;

    /** @Column(type="string", name="message") */
    private $message;

	
    public function __construct($user,$type,$typeDetail,$title,$message){
    	$this->created = new \DateTime("now");
    	$this->user = $user;
    	$this->title = $title;
    	$this->typeDetail = $typeDetail;
    	$this->message = $message;
    	$this->type = $type;
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