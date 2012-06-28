<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectRole")
 * @Table(name="project_role",indexes={@index(name="search_project_role",columns={"project_id"}),@index(name="search_project_role_user",columns={"user_id"})})
 */
class ProjectRole {
	const PROJECT_ROLE_STARTER = "starter";
	const PROJECT_ROLE_BUILDER = "builder";
	const PROJECT_ROLE_GROWER = "grower";
	const PROJECT_ROLE_LEADER = "leader";
	const PROJECT_ROLE_ADVISER = "advisor";
	const PROJECT_ROLE_TYPE_CREATOR = "creator";
	const PROJECT_ROLE_TYPE_MEMBER = "member";
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @Column(type="string", name="name",nullable=false)
	 */
	private $name;
	
	/**
	 * @Column(type="string", name="type",nullable=false)
	 */
	private $type;
	
	/**
	 * @Column(type="string", name="description",nullable=true)
	 */
	private $description;
	
	/**
	 * @Column(type="integer", name="level")
	 */
	private $level;
	
	/**
	 * @ManyToOne(targetEntity="Project", inversedBy="roles")
	 * @JoinColumn(name="project_id", referencedColumnName="id")
	 */
	private $project;
	
	/**
	 * @ManyToOne(targetEntity="User", inversedBy="projectRoles")
	 * @JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;
	
	public function setUser($user) {
		$this->user = $user;
	}
	
	public function setProject($project) {
		$this->project = $project;
	}
	
	/**
	 *
	 * @param $name unknown_type       	
	 */
	public function __construct($name, $type) {
		$this->name = $name;
		$this->level = 1;
		$this->type = $type;
	
	}
	/**
	 *
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 *
	 * @param $name field_type       	
	 */
	public function setName($name) {
		$this->name = $name;
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