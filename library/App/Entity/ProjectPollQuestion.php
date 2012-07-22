<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project\PollQuestion")
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