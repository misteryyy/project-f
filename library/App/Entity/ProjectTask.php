<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectTask")
 * @Table(name="project_task")
 */
class ProjectTask
{
	
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="integer", name="level")
     */
    private $level;
    
    /** @Column(type="string", name="task",nullable=false) */
    private $task;   
    
    
    /**
     * @ManyToOne(targetEntity="Project", inversedBy="roleWidgetQuestions")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     **/
    private $project;
  
    
    /**
     * @Column(type="boolean", name="finished")
     */
    private $finished;
    
    /**
     *
     * @param unknown_type $question
     */
    public function __construct($task,$level = 1){
    	$this->task = $task;
    	$this->level = $level;
    	$this->finished = false;
    }
    
    /**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param unknown_type $question
	 */
	public function setTask($task) {
		$this->task = $task;
	}

	public function setProject($project){
    	$this->project = $project;
    	
    }
    
    
    /**
	 * @return the $finished
	 */
	public function getFinished() {
		return $this->finished;
	}

	/**
	 * @param field_type $finished
	 */
	public function setFinished($finished) {
		$this->finished = $finished;
	}

	
    /**
	 * @return the $question
	 */
	public function getTask() {
		return $this->task;
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
						 "task" => $this->task,
						 "level" => $this->level,
						"finished" => $this->finished,
						 "project_id" => $this->project->id,
						  "user_id" => $this->project->user->id);	
		return $params;
	}
	
}