<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\User")
 * @Table(name="user")
 */
class User
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    /** @Column(type="string", name="name") */
    private $name;
    /** @Column(type="string", name="email") */
    private $email;

    
    /**
     *
     * @param \Doctrine\Common\Collections\Collection $property
     *
     * @OneToMany(targetEntity="Project",mappedBy="user", cascade={"persist","remove"})
     */
    private $_projects;
    
    
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