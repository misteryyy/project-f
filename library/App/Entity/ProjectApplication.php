<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectApplication")
 * @Table(name="project_application",indexes={@index(name="search_project_application",columns={"project_id"}),@index(name="search_project_role",columns={"project_role_id"}),@index(name="search_project_application_user",columns={"user_id"})})
 */
class ProjectApplication {
	
	const PROJECT_ROLE_STARTER = "starter";
	const PROJECT_ROLE_BUILDER = "builder";
	const PROJECT_ROLE_GROWER = "grower";
	const PROJECT_ROLE_LEADER = "leader";
	const PROJECT_ROLE_ADVISER = "advisor";
	const PROJECT_ROLE_TYPE_CREATOR = "creator";
	const PROJECT_ROLE_TYPE_MEMBER = "member";
	const APPLICATION_ACCEPTED = 2;
	const APPLICATION_DENIED = 1;
	const APPLICATION_NEW = 0;
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @Column(type="string", name="role_name",nullable=false)
	 */
	private $roleName;
	
	/**
	 * @Column(type="datetime",name="created", nullable=false)
	 */
	private $created;
	
	/**
	 * @column(type="datetime",nullable=false)
	 */
	public $modified;
	
	
	/**
	 * @Column(type="string", name="content",nullable=false)
	 */
	private $content;
	
	/**
	 * @Column(type="string", name="description",nullable=true)
	 */
	private $description;

	/**
	 * @Column(type="string", name="result",nullable=true)
	 */
	private $result; // result from Creator
	
	// STATE 0 -> new application
	// STATE 1 -> accepted application
	// STATE 2 -> declined application
	/**
	 * @Column(type="integer", name="state",nullable=false)
	 */
	private $state;
	

	/**
	 * @Column(type="integer", name="level")
	 */
	private $level; // level when was applying
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_id", referencedColumnName="id")
	 */
	private $project;

	/**
	 * @ManyToOne(targetEntity="ProjectRole",inversedBy="applications")
	 * @JoinColumn(name="project_role_id", referencedColumnName="id")
	 */
	private $projectRole; // if empty, we are in the first level
	
	/**
	 * @ManyToOne(targetEntity="User")
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
	 * Constructor for new application
	 * @param unknown_type $user
	 * @param unknown_type $project
	 * @param unknown_type $level
	 * @param unknown_type $content
	 * @param unknown_type $roleName
	 */
	public function __construct($user,$project,$level,$content,$roleName){
		$this->level = $level;
		$this->user = $user;
		$this->project = $project;
		$this->content = $content;
		$this->roleName = $roleName;
		$this->state = 0; // created state
		$this->created = new \DateTime ( "now" );
		$this->modified = new \DateTime ( "now" ); // the date when the application were modified

	}
	
	/**
	 * Set description of application
	 * @param unknown_type $description
	 */
	public function setDescription($description){
		$this->description = $description;
	}

	
	/**
	 * @return the $roleName
	 */
	public function getRoleName() {
		return $this->roleName;
	}

	/**
	 * @return the $content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @return the $result
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @return the $state
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @return the $level
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @return the $project
	 */
	public function getProject() {
		return $this->project;
	}

	/**
	 * @return the $projectRole
	 */
	public function getProjectRole() {
		return $this->projectRole;
	}

	/**
	 * @return the $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param field_type $roleName
	 */
	public function setRoleName($roleName) {
		$this->roleName = $roleName;
	}

	/**
	 * @param field_type $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * @param field_type $result
	 */
	public function setResult($result) {
		$this->modified = new \DateTime ( "now" );
		$this->result = $result;
	}

	/**
	 * @param field_type $state
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * @param field_type $level
	 */
	public function setLevel($level) {
		$this->level = $level;
	}

	/**
	 * @param field_type $projectRole
	 */
	public function setProjectRole($projectRole) {
		$this->projectRole = $projectRole;
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

	
	/**
	 * Return just basic information about the entity
	 */
	public function toArray(){
		$params = array ("id" => $this->id,
				"level" => $this->level,
				"role_name" => $this->roleName,
				"content" => $this->content,
				"description" => $this->description,
				"project_id" => $this->project->id,
				"user_id" => $this->project->user->id,
				"created" => $this->created->format('Y/m/d h:m:s'),
				"user_id" => $this->user->id,
				"user_name" => $this->user->name,
				
				
		);
		
		// if role exists
		if(isset($this->projectRole)){
			$params["project_role_id"] = $this->projectRole->id;
			$params["project_role_description"] = $this->projectRole->description;
		}else {
			$params["project_role_id"] = null;
			$params["project_role_description"] = null;
			
		}
		
		// additional information for second level
		if($this->level ==2 && isset($this->projectRole)){
			$params["project_role_id"] = $this->projectRole->id;
			$params["project_role_description"] = $this->projectRole->description;
		}
		
		return $params;
	}

}