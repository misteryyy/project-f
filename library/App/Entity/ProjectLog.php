<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectLog")
 * @Table(name="project_log")
 */
class ProjectLog {
	
	const TYPE_SYSTEM = "system";
	const TYPE_PRIVATE = "private";
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @Column(type="string", name="type")
	 */
	private $type;
	
	/**
	 * @Column(type="string", name="message")
	 */
	private $message;
	
	/**
	 * @column(type="datetime",name="date")
	 */
	private $created;
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_id", referencedColumnName="id")
	 */
	private $project;
	
	/**
	 *
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 *
	 * @param $type field_type       	
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	public function __construct($message, $type = self::TYPE_SYSTEM) {
		$this->message = $message;
		$this->type = $type;
		$this->created = new \DateTime ( "now" );
	}
	
	public function setProject($project){
		$this->project = $project;
	}
	/*
	 * Reflection methods TODO in production change to real method
	 */
	public function __get($property) {
		return $this->$property;
	}
	public function __set($property, $value) {
		$this->$property = $value;
	}

}