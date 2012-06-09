<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectRoleWidgetQuestion")
 * @Table(name="project_role_widget_question")
 */
class ProjectRoleWidgetQuestion
{
	
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", name="question",nullable=false) */
    private $question;   
    
    
    /**
     * @ManyToOne(targetEntity="Project", inversedBy="roleWidgetQuestions")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     **/
    private $project;
  
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
	public function setQuestion($question) {
		$this->question = $question;
	}

	public function setProject($project){
    	$this->project = $project;
    	
    }
    
    /**
     * 
     * @param unknown_type $question
     */
    public function __construct($question){
    	$this->question = $question;
    
    	
    }
    /**
	 * @return the $question
	 */
	public function getQuestion() {
		return $this->question;
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
						 "question" => $this->question,
						 "project_id" => $this->project->id,
						  "user_id" => $this->project->user->id);	
		return $params;
	}
	
}