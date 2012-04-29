<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectTag")
 * @Table(name="project_tag")
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
     * @ManyToMany(targetEntity="Project",mappedBy="project", cascade={"ALL"})
     */
    private $projects;
    
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
    
    
    
//     public function getId()
//     {
//         return $this->id;
//     }

//     /**
// 	 * @return the $email
// 	 */
// 	public function getEmail() {
// 		return $this->email;
// 	}

// 	/**
// 	 * @param field_type $email
// 	 */
// 	public function setEmail($email) {
// 		$this->email = $email;
// 		return $this;
// 	}

// 	/**
// 	 * @param field_type $name
// 	 */
// 	public function setName($name) {
// 		$this->name = $name;
// 		return $this;
// 	}

// 	public function getName()
//     {
//         return $this->name;
//     }





}