<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\UserSpecificRoleTag")
 * @Table(name="user_specific_role_tag",indexes={@index(name="search_idx",columns={"name"})})
 */
class UserSpecificRoleTag
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
     * @ManyToMany(targetEntity="UserSpecificRole",mappedBy="tags", cascade={"persist"})
     */
    private $specRoles;
    
    
    public function __construct(){
   
    	$this->specRoles =  new \Doctrine\Common\Collections\ArrayCollection();	
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
	public function getSpecificRoles() {	
		return $this->specRoles;
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
	public function addSpecificRole($role) {
		$this->specRoles[] = $role;
	}

	public function removeSpecificRole($role){
		$this->specRoles->removeElement($role);
	}

	public function getCountOfSpecRolesUsingThisTag(){
		return $this->specRoles->count();	
	}



}