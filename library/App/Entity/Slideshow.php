<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Admin\Slideshow")
 * @Table(name="setting_slideshow")
 */
class Slideshow {
	
	/**
	 * @Id @Column(type="integer", name="id")
	 */
	private $id;
	
	public function __construct(){
		$this->id = 1;
	}
	
	public function setProject($slot,$project){
		$var = "project".$slot;
		$this->$var = $project;
	}
	
	public function getProject($slot){
		$var = "project".$slot;
		return $this->$var;
	}
	
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_1_id", referencedColumnName="id")
	 */
	private $project1;
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_2_id", referencedColumnName="id")
	 */
	private $project2;
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_3_id", referencedColumnName="id")
	 */
	private $project3;
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_4_id", referencedColumnName="id")
	 */
	private $project4;
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_5_id", referencedColumnName="id")
	 */
	private $project5;
	
		
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
    
   