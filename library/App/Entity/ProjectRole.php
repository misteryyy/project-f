<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectRole")
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
	
	/**
	 * @Column(type="datetime",name="created", nullable=false)
	 */
	private $created;
	
	
	/**
	 * @oneToMany(targetEntity="ProjectApplication", mappedBy="projectRole")
	 */
	private $applications;
	
	/**
	 * Return array of all roles in the system
	 */
	public static function getRolesArray(){
		
		return array(self::PROJECT_ROLE_STARTER,
					self::PROJECT_ROLE_LEADER,
					self::PROJECT_ROLE_GROWER,
					self::PROJECT_ROLE_BUILDER,
					self::PROJECT_ROLE_ADVISER);
	}
	
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
	public function __construct($name, $type,$level = 1,$description = "") {
		$this->name = $name;
		$this->level = $level;
		$this->type = $type;
		$this->description = $description;
		$this->created = new \DateTime ( "now" );	
		$this->applications = new \Doctrine\Common\Collections\ArrayCollection();
	}
	/**
	 *
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function setLevel($level){
		$this->level = $level;
	}
	
	public function setDescription($description){
		return $this->description = $description;
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
	
	
	/**
	 * Return just basic information about the entity
	 */
	public function toArray(){
		$params = array ("id" => $this->id,
				"level" => $this->level,
				"role_name" => $this->name,
				"type" => $this->type,
				"description" => $this->description,
				"project_id" => $this->project->id,
				"applications" => null,
				"applications_count" => 0
		);
		
		// add application information to array
		if (count($this->applications) > 0){
			foreach($this->applications as $a){
			if($a->state == \App\Entity\ProjectApplication::APPLICATION_NEW) {
				$params["applications"][] = $a->toArray();
				
				}
			};	
		}
		
		$params['applications_count']  = count($params["applications"]);
		
		
		// add information about the user who has this role
		if(isset($this->user)){
			$params["user_id"]= $this->user->id;
			$params["user_name"] = $this->user->name;
		}
		
		
		
		return $params;
	}
}