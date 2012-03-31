<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\User")
 * @Table(name="user")
 */
class User implements \Zend_Acl_Role_Interface
{
	// must be implemented for acl
	public function getRoleId()
	{
		return 'guest';
	}
	
	
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    /** @Column(type="string", name="name") */
    private $name;
    /** @Column(type="string", name="email") */
    private $email;

    /** @Column(type="string", name="password") */
    private $password;
    
    /**
     *
     * @param \Doctrine\Common\Collections\Collection $property
     *
     * @OneToMany(targetEntity="Project",mappedBy="user", cascade={"persist","remove"})
     */
    private $projects; 
    
     /**
      * @ManyToMany(targetEntity="UserTag", inversedBy="user_tag", cascade={"persist,remove"})
      * @JoinTable(name="user_has_user_tag",
      *  joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
      *  inverseJoinColumns={@JoinColumn(name="user_tag_id",referencedColumnName="id")})
      */
  	private $user_tags;
    
    public function __construct(){
    	$this->user_tags = new \Doctrine\Common\Collections\ArrayCollection();
    	
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
    
    
//     public function getId()
//     {
//         return $this->id;
//     }

//     /**
// 	 * @return the $email
// 	 */
// 	public function getEmail() {
// 		return $this->email;
// 	}

// 	/**
// 	 * @param field_type $email
// 	 */
// 	public function setEmail($email) {
// 		$this->email = $email;
// 		return $this;
// 	}

// 	/**
// 	 * @param field_type $name
// 	 */
// 	public function setName($name) {
// 		$this->name = $name;
// 		return $this;
// 	}

// 	public function getName()
//     {
//         return $this->name;
//     }





}