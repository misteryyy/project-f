<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Poll")
 * @Table(name="project_poll")
 */
class ProjectPoll
{
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
     * @Column(type="string", name="name")
     */
    private $name;
    
    /**
     * @Column(type="boolean", name="active",nullable=true)
     */
    private $active;
    
    /**
     * @ManyToOne(targetEntity="Project")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     **/
    private $project;
    
    
    /**
     * @oneToMany(targetEntity="ProjectPollQuestion", mappedBy="poll")
     */
    private $questions; // if empty, we are in the first level
    

    /**
     * Initialization of Collections
     */
    public function __construct($name,$project){
		$this->project = $project;	
		$this->created = new \DateTime ( "now" );
    	$this->name = $name;
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