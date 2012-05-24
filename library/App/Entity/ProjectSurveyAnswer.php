<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectSurveyAnswer")
 * @Table(name="project_survey_answer",indexes={@index(name="search_project_survey_answer_project_id",columns={"project_id"})})
 */
class ProjectSurveyAnswer
{
	
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", name="answer",nullable=false) */
    private $answer;   
      
    /**
     * @ManyToOne(targetEntity="ProjectSurveyQuestion", inversedBy="answers",cascade={"persist","remove"})
     * @JoinColumn(name="question_id", referencedColumnName="id")
     **/
    private $question;

    
    
    /**
     * @ManyToOne(targetEntity="Project", inversedBy="roles")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     **/
    private $project;

    /**
     * @column(type="datetime",nullable=true)
     */
    public $modified;
    

    /**
     * 
     * @param unknown_type $name
     */
    public function __construct($answer,$project){
		$this->answer = $answer;
		$this->modified = new \DateTime("now"); // the date is at the beginning the same
		$this->project = $project;
    }
 
    public function setQuestion($q){
    	$q->addAnswer($this);
    	$this->question = $q;
    }
    
	public function setAnswer($a){
		$this->answer = $a;
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