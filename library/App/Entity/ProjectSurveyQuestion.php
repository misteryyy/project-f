<?php
namespace App\Entity;
/**
 * @Entity(repositoryClass="App\Repository\ProjectSurveyQuestion")
 * @Table(name="project_survey_question")
 */
class ProjectSurveyQuestion
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", name="name") */
    private $question;
    
   
 
    /**
     * Initialization of Collections
     */
    public function __construct($question){
		$this->question = $question;	   
    }
    
    public function getId()
    {
    	return $this->id;
    }
    
    public function getQuestion(){
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

}