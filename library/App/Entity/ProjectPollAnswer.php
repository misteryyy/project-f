<?php
namespace App\Entity;
/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectPollAnswer")
 * @Table(name="project_poll_answer")
 */
class ProjectPollAnswer
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    
    
    /** @Column(type="integer", name="answer") */
    private $answer;
    
    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    
    /**
     * @ManyToOne(targetEntity="ProjectPoll",inversedBy="questions")
     * @JoinColumn(name="poll_id", referencedColumnName="id")
     */
    private $poll;
    
    /**
     * @ManyToOne(targetEntity="ProjectPollQuestion",inversedBy="answers")
     * @JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;
    
    /**
     * @Column(type="datetime",name="created")
     */
    private $created;
    
    /**
     * Initialization of Collections
     */
    public function __construct($user,$answer,$question,$poll){
    	$this->user = $user;
		$this->answer = $answer;	
		$this->question = $question;
		$this->poll = $poll;
		$this->created = new \DateTime ( "now" );
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