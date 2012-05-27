<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectComment")
 * @Table(name="project_comment",indexes={@index(name="search_project_board_message",columns={"project_id"})})
 */
class ProjectComment {
	
	const COMMENT_PRIORITY_HIGH = 1;
	const COMMENT_PRIORITY_LOW = 0;
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @Column(type="datetime",name="created")
	 */
	private $created;
	
	/**
	 * @Column(type="string", name="priority",nullable=false)
	 */
	private $priority;
	
	
	/**
	 * @Column(type="string", name="description",nullable=true)
	 */
	private $content;
	
	
	/**
	 * @ManyToOne(targetEntity="Project")
	 * @JoinColumn(name="project_id", referencedColumnName="id")
	 */
	private $project;
	
	
	/**
	 * @ManyToOne(targetEntity="ProjectComment")
	 * @JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	private $parent;
	
	/**
	 * 
	 * @OneToMany(targetEntity="ProjectComment",mappedBy="parent")
	 * 
	 */
	private $children;
	
	/**
	 * @ManyToOne(targetEntity="User")
	 * @JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;
	
	
	/**
	 *
	 * @param $name unknown_type       	
	 */
	public function __construct($project,$user,$content,$priority = self::COMMENT_PRIORITY_LOW) {
		$this->content = $content;
		$this->project = $project;
		$this->user = $user;
		$this->priority = $priority;
		$this->created = new \DateTime ( "now" );
		$this->children = new \Doctrine\Common\Collections\ArrayCollection();
		
	}
	public function setPriority($priority){
		$this->priority= $priority;
	}
	
	public function addChild($child){
		$this->children[] = $child;
	}
	
	public function setParent($parent){
		$this->parent = $parent;
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