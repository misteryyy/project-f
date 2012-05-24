<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectTag")
 * @Table(name="project_tag",indexes={@index(name="search_project_tag_name",columns={"name"})})
 */
class ProjectTag
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    /** @Column(type="string", name="name") */
    private $name;
    /**
     * 
     * @ManyToMany(targetEntity="Project",mappedBy="tags", cascade={"ALL"})
     */
    private $projects;
    
  
    public function __construct($name){
    	$this->projects = new \Doctrine\Common\Collections\ArrayCollection();	
    	$this->name = $name;
    	
    }
    
    public function getName(){
    	return $this->name;
    }
    
    /**
     * @param field_type $users
     */
    public function addProject($project) {
    	$this->projects[] = $project;
    }
    
    public function removeProject($project){
    	$this->projects->removeElement($project);
    }
    
    public function getCountOfProjects(){
    	return $this->projects->count();
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