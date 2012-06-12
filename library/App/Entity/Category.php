<?php
namespace App\Entity;
/**
 * @Entity(repositoryClass="App\Repository\Category")
 * @Table(name="category")
 */
class Category
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", name="name") */
    private $name;
    
    /**
     * @oneToMany(targetEntity="Project", mappedBy="category")
     */
    private $projects;
 
    /**
     * Initialization of Collections
     */
    public function __construct($name){
		$this->name = $name;	
    	$this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    
    }
    
    public function getId()
    {
    	return $this->id;
    }
    
    public function getName(){
    	return $this->name;
    }
  /**
     * @return \Doctrine\Common\Collections\Collection;
     */
    public function getProjects(){
    	return $this->projects;
    }
    
    /**
     * Add project to category
     * @param unknown_type $project
     */
    public function addProject($project){
    	$this->projects[] = $project;
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