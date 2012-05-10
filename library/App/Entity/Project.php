<?php
namespace App\Entity;
/**
 * @Entity(repositoryClass="App\Repository\Project")
 * @Table(name="project")
 */
class Project
{
	const LEVEL_1 = 1;
	const LEVEL_2 = 2;
	const LEVEL_3 = 3;
	
	const STATUS_DRAFT = 1;
	const STATUS_PUBLISHED = 2;
	
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $_id;
    /** @Column(type="string", name="name") */
    private $_name;

    /** @Column(type="string", name="pitch_sentence") */
    private $_pitch_sentence;

    /** @Column(type="datetime",name="created") */
    private $created;
    
    /** @Column(type="integer", name="view_count") */ 
    private $viewCount;
    
    
    /** @Column(type="integer") */
    private $status;
    
    /**
     * @column(type="datetime")
     */
    public $modified;
    /**
     * @prePersist
     * @preUpdatet
     */
    public function update(){
    	$this->modified = new \DateTime('now');	
    }
    
    public function getCreated(){
    	return $this->created;
    }

    /**
     * @manyToOne(targetEntity="Category", inversedBy="projects")
     * @joinColumn(name="category_id")
     */
    private $category;
    
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * @var User
     * @ManyToOne(targetEntity="User")
     * @JoinColumns({
     *  @JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;
        
	/**
	* @manyToMany(targetEntity="ProjectTag")
	* @joinTable(
	* name="project_has_project_tag",
	* joinColumns={
	*         @joinColumn(name="project_id", referencedColumnName="id")
	*    },
	*inverseJoinColumns={
	*         @joinColumn(name="project_tag_id", referencedColumnName="id")
	*     }
	* )
	*/ 
    private $tags;
    
    /**
     * Date initialization
     */
    public function __construct(){
    	// date
    	$this->created = new \DateTime("now");
    	$this->status = static::STATUS_DRAFT;
    	$this->viewCount = 0;
    }
    
    /**
     * @return Category
     */
    public function getCategory(){
    	return $this->category;
    }
    
    /**
     * Set Category
     */
    public function setCategory(Category $category){
    	
    	$this->category = $category;
    }
    
    /*
     * Reflection methods
    * TODO in production change to real method
    */
    public function __get($property)
    {
    	return $this->$property;
    }
    public function __set($property,$value)
    {
    	$this->$property = $value;
    }

}