<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectUpdate")
 * @Table(name="project_update")
 */
class ProjectUpdate
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", name="title",nullable=false) */
    private $title;   
    
    /** @Column(type="string", name="content",nullable=false) */
    private $content;
        
    /** @Column(type="datetime",name="created") */
    private $created;
    
    /**
     * @column(type="datetime",nullable=true)
     */
    public $modified;
    
    /**
     * @ManyToOne(targetEntity="Project")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     **/
    private $project;
    
    /**
     * 
     * @param unknown_type $name
     */
    public function __construct($project,$title,$content){
    	$this->project = $project;
    	$this->title = $title;
    	$this->content = $content; 
    	$this->created = new \DateTime("now");
    	$this->modified = new \DateTime("now"); // the date is at the beginning the same
    }
    
	/**
	 * @return the $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return the $content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param field_type $title
	 */
	public function setTitle($title) {
		$this->title = $title;
		$this->modified = new \DateTime("now"); // the date is at the beginning the same
	}

	/**
	 * @param field_type $content
	 */
	public function setContent($content) {
		$this->content = $content;
		$this->modified = new \DateTime("now"); // the date is at the beginning the same
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