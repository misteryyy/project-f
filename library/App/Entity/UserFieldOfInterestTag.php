<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\UserFieldOfInterestTag")
 * @Table(name="user_field_of_interest_tag",indexes={@index(name="search_idx",columns={"name"})})
 */
class UserFieldOfInterestTag
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", name="name",unique=true) */
    private $name;
    
    /**
     * 
     * @ManyToMany(targetEntity="User",mappedBy="userFieldOfInterestTags", cascade={"persist"})
     */
    private $users;
    
    
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
	public function getUsers() {
		
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

	public function removeUser($user){
		$this->users->removeElement($user);
	}




}