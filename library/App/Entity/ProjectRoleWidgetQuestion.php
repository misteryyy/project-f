<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectRoleWidgetQuestion")
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
     * @ManyToOne(targetEntity="Project", inversedBy="roleWidgetQuestions",cascade={"persist","remove"})
     * @JoinColumn(name="project_id", referencedColumnName="id")
     **/
    private $project;
  
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
		return $this->name;
	}

}