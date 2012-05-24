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
    
    
    /*
     * Reflection methods
    * TODO in production change to real method
    */
    public function __get($property)
    {
    	return $this->$property;
    }
    public function __set($property,$value)
    {
    	$this->$property = $value;
    }
    

}