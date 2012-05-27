<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\ProjectBoardComment")
 * @Table(name="project_board_comment",indexes={@index(name="search_project_board_comment", columns={"project_id"})})
 */
class ProjectBoardComment
{

    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /** @ManyToOne(targetEntity="User")
     *	@JoinColumn(name="user_id",referencedColumnName="id")
     *
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Project")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;
    
    /**
     * Set user for this message
     * @param unknown_type $user
     */
    public function setUser($user){
    	$this->user = $user;
    }
      
    /** @Column(type="datetime", name="created") */
    private $created;

    /** @Column(type="string", name="content") */
    private $content;
    
    /** 
    * @OneToMany(targetEntity="ProjectBoardFile", mappedBy="projectBoard",cascade={"persist","delete"}) 
	*/
    private $files;

    public function __construct($user,$project,$content){
    	$this->created = new \DateTime("now");
    	$this->files = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->user = $user;
    	$this->content = $content;
    	$this->project = $project;
    }
	 
    public function addFile($f){
    	$f->addProjectBoardComment($this);
    	$this->files[] = $f;	
    }

	/**
	 * @return the $created
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @return the $content
	 */
	public function getContent() {
		return $this->content;
	}


	/**
	 * @param \DateTime $created
	 */
	public function setCreated($created) {
		$this->created = $created;
	}

	/**
	 * @param field_type $message
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	public function getFiles(){
		return $this->files;
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