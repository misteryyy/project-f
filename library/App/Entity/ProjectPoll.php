<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectPoll")
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
    

	    
    

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $created
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $active
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * @return the $project
	 */
	public function getProject() {
		return $this->project;
	}

	/**
	 * @return the $questions
	 */
	public function getQuestions() {
		return $this->questions;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param \DateTime $created
	 */
	public function setCreated($created) {
		$this->created = $created;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $active
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * @param field_type $project
	 */
	public function setProject($project) {
		$this->project = $project;
	}

	/**
	 * @param field_type $questions
	 */
	public function setQuestions($questions) {
		$this->questions = $questions;
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