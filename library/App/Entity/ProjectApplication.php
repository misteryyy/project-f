<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectApplication")
 * @Table(name="project_application",indexes={@index(name="search_project_application",columns={"project_id"}),@index(name="search_project_application_user",columns={"user_id"})})
 */
class ProjectApplication {
	
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
	 * @Column(type="integer", name="level")
	 */
	private $level;
	
	/**
	 * @ManyToOne(targetEntity="Project", inversedBy="roles")
	 * @JoinColumn(name="project_id", referencedColumnName="id")
	 */
	private $project;
	
	/**
	 * @ManyToOne(targetEntity="ProjectRole", inversedBy="applications")
	 * @JoinColumn(name="project_role_id", referencedColumnName="id")
	 */
	private $projectRole; // if empty, we are in the first level
	
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

}