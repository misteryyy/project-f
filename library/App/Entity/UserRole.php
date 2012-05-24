<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\UserRole")
 * @Table(name="user_role",indexes={@index(name="search_idx",columns={"type"})})
 */
class UserRole
{
	const SYSTEM_ROLE_ADMIN = "admin";
	const SYSTEM_ROLE_MEMBER = "member";
	const SYSTEM_ROLE_VISITOR = "visitor";
	
	const TYPE_SYSTEM = "system_role";
	const TYPE_BENEFIT = "benefit_role";
	
	const TYPE_MEMBER = "member_role"; // 
	const MEMBER_ROLE_STARTER = "starter";
	const MEMBER_ROLE_BUILDER = "builder";
	const MEMBER_ROLE_GROWER = "grower";
	const MEMBER_ROLE_LEADER = "leader";
	const MEMBER_ROLE_ADVISER = "advisor";

    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    
    /** @Column(type="string", name="type") */
    private $type;
    
    
    /** @Column(type="string", name="name",unique=true) */
    private $name;
    

    /**
     * 
     * @ManyToMany(targetEntity="User",mappedBy="user", cascade={"persist"})
     */
    private $users;
    
    
    /**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param field_type $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	public function __construct(){
    	$this->users = new \Doctrine\Common\Collections\ArrayCollection();	
    }
    
    /**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $users
	 */
	public function getUser() {
		return $this->users;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $users
	 */
	public function addUser($user) {
		$this->users[] = $user;
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