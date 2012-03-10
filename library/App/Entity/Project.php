<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\Project")
 * @Table(name="project")
 */
class Project
{
    /**
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $_id;
    /** @Column(type="string", name="name") */
    private $_name;

    /** @Column(type="string", name="pitch_sentence") */
    private $_pitch_sentence;

    public function getId()
    {
        return $this->_id;
    }
    
    /**
     *
     * @var User
     * @ManyToOne(targetEntity="User")
     * @JoinColumns({
     *  @JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;
    
    
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
    
    
    
//     /**
// 	 * @return the $_pitch_sentence
// 	 */
// 	public function getPitchSentence() {
// 		return $this->_pitch_sentence;
// 	}

// 	/**
// 	 * @param field_type $_pitch_sentence
// 	 */
// 	public function setPitchSentence($pitch) {
// 		$this->_pitch_sentence = $pitch;
// 		return $this;
// 	}

// 	/**
// 	 * @param field_type $name
// 	 */
// 	public function setName($name) {
// 		$this->_name = $name;
// 		return $this;
// 	}

// 	public function getName()
//     {
//         return $this->_name;
//     }





}