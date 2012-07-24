<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\ProjectPollQuestion")
 * @Table(name="project_poll_question",indexes={@index(name="search_project_poll_question",columns={"poll_id"})})
 */
class ProjectPollQuestion {
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @Column(type="string", name="role_name",nullable=false)
	 */
	private $question;
	
	
	/**
	 * @ManyToOne(targetEntity="ProjectPoll",inversedBy="questions")
	 * @JoinColumn(name="poll_id", referencedColumnName="id")
	 */
	private $poll;
	

	/**
	 * @oneToMany(targetEntity="ProjectPollAnswer", mappedBy="question")
	 */
	private $answers; // if empty, we are in the first level
	
	
	/**
	 * Create new question for poll
	 * @param unknown_type $question
	 * @param unknown_type $poll
	 */
	public function __construct($question,$poll){
		$this->question = $question;
		$this->poll = $poll;
		$this->answers = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * Return sum of all integer answers
	 */
	public function sumOfAnswers(){
		
		$sum = 0;
		foreach($this->answers as $ca){
			$sum += $ca->answer;
		}
			
		return $sum;
	}
	
	/**
	 * Return avg of all integer answers
	 */
	public function avgOfAnswers(){
		
		if(count($this->answers) == 0) return 0;
		
		$sum = 0;
		foreach($this->answers as $ca){
			$sum += $ca->answer;
		}
		
		return round($sum / count($this->answers),2);
	}
	
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $question
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * @return the $poll
	 */
	public function getPoll() {
		return $this->poll;
	}

	/**
	 * @return the $answers
	 */
	public function getAnswers() {
		return $this->answers;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $question
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}

	/**
	 * @param field_type $poll
	 */
	public function setPoll($poll) {
		$this->poll = $poll;
	}

	/**
	 * @param field_type $answers
	 */
	public function setAnswers($answers) {
		$this->answers = $answers;
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