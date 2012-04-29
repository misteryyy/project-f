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
    private $_id;
    
    /** @Column(type="string", name="name") */
    private $_name;
    
    /**
     * @oneToMany(targetEntity="Project", mappedBy="category")
     */
    private $projects;

    
    /**
     * Initialization of Collections
     */
    public function __construct(){
    	$this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId()
    {
    	return $this->_id;
    }
  /**
     * @return \Doctrine\Common\Collections\Collection;
     */
    public function getProjects(){
    	return $this->projects;
    }
    
    
    public function addProject(Project $project){
    	$this->projects->add($project);
    	$project->setCategory($this);
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