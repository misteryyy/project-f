<?php
namespace App\Entity;
 // User specific role, which has other atributes like tags. Its not project specific role

 /**
  * @Entity
  * @Table(name="user_specific_role",uniqueConstraints={@UniqueConstraint(name="search_name", columns={"user_id", "name"})})
 */
class UserSpecificRole
{	
	const TYPE_MEMBER = "user_specific_role"; // 
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
	
	/** @ManyToOne(targetEntity="User", inversedBy="specRoles")
	 *	@JoinColumn(name="user_id",referencedColumnName="id") 
	 * 
	 */
	private $user;
	

	/** @Column(type="string", name="name") */
	private $name;
	
	/**
	 * @ManyToMany(targetEntity="UserSpecificRoleTag", inversedBy="specRoles",cascade={"persist","remove"})
	 * @JoinTable(name="user_specific_role_has_user_specific_tag",
	 * joinColumns={@JoinColumn(name="specific_role_id", referencedColumnName="id")},
	 * inverseJoinColumns={@JoinColumn(name="user_specific_tag_id",referencedColumnName="id")})
	 */
	private $tags;
	
	public function __construct($name, $user)
	{
		$this->name= $name;
		$this->user = $user;
		$this->tags = new \Doctrine\Common\Collections\ArrayCollection ();
	}
	 	
	/*
	 * Add tag to the SpecificRole
	 */
	public function addTag($tag){
		// add tag only if doesn't exist
		if(!$this->getTag($tag->getName())){
			// adding role to the tag
			$tag->addSpecificRole($this);
			$this->tags[] = $tag;
		}
	}
	

	/*
	 * Remove tag from this role
	 */
	public function removeTag($tag){
		// remove role from the tag, maybe somebody will use this tag
		$tag->removeSpecificRole($this);
		$this->tags->removeElement($tag);
	}
	
	
	
	/**
	 * Return tags in string format with , divider
	 */
	public function getTagsString($toString = true){
	//collecting names
		$tagArray = array();
		foreach($this->tags as $tag){		
			$tagArray[] = $tag->getName();
		}	
		return implode(",", $tagArray);
	}
	
	public function getTags(){
		return $this->tags;
	}
	
	/**
	 * Return tags in string format with , divider
	 */
	public function getTag($name){
		foreach($this->tags as $tag){
			if($tag->getName() == $name){
				return $tag;
			}
		}
		
		return false;
	}
	
	/**
	 * Function return array of string tags
	 * if no tags are find. Return empty array
	 */
	public function getTagsArray(){
		$tagArray = array();
		
		if($this->tags->count() > 0){
			foreach($this->tags as $tag){
				$tagArray[] = $tag->getName();		
				
			}
		}	
		
		return $tagArray;
	}
	
	/**
	 * Number of tags
	 */
	public function countTag(){
		return $this->tags->count();
	}
	
    /**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $user
	 */
	public function getUser() {
		
		return $this->user;
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
	public function setUser($user) {
		$this->user = $user;
	}

}