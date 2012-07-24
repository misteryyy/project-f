<?php
namespace App\Entity;

/**
 * @Entity(repositoryClass="App\Repository\User")
 * @Table(name="user",indexes={@index(name="search_user_email",columns={"email"})})
 */
class User {
	
	const PROFILE_PHOTO_RESOLUTION_50 = 50;
	const PROFILE_PHOTO_RESOLUTION_100 = 100;
	const PROFILE_PHOTO_RESOLUTION_200 = 200;
	
	/**
	 * @Id @Column(type="integer", name="id")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @ManyToMany(targetEntity="UserRole", inversedBy="user_role",cascade={"persist","remove"})
	 * @JoinTable(name="user_has_user_role",
	 * joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
	 * inverseJoinColumns={@JoinColumn(name="user_role_id",referencedColumnName="id")})
	 */
	private $roles; // every user is in role / System Roles, Benefit roles
	
	/**
	 * @OneToMany(targetEntity="UserSpecificRole", mappedBy="user", cascade={"ALL"})
	 */
	private $specRoles;
	
	/**
	 * @OneToMany(targetEntity="ProjectRole", mappedBy="user", cascade={"ALL"})
	 */
	private $projectRoles;
	

	/**
	 * @Column(type="string", name="name")
	 */
	private $name;
	/**
	 * @Column(type="string", name="email",unique=true)
	 */
	private $email;
	
	/**
	 * @Column(type="string", name="profile_picture",unique=true,nullable=true)
	 */
	private $profilePicture;
		
	/**
	 * @Column(type="boolean", name="email_visibility",nullable=true)
	 */
	private $emailVisibility;
	
	
	/**
	 * @Column(type="boolean", name="email_newsletter")
	 */
	private $emailNewsletter;
	
	/**
	 * @Column(type="boolean", name="email_notification")
	 */
	private $emailNotification;
	
	/**
	 * @Column(type="string", name="password")
	 */
	private $password;
	/**
	 * @Column(type="string", name="country", columnDefinition="CHAR(2)",nullable=true)
	 */
	protected $country;
	/** @Column(type="smallint",name="confirmed",nullable=true) */
	private $confirmed;
	/**
	 * @OneToOne(targetEntity="UserInfo",cascade={"persist"})
	 * @JoinColumn(name="user_info_id", referencedColumnName="id")
	 */
	private $userInfo;
	/**
	 * @Column(type="string", name="description",nullable=true)
	 */
	private $description;
	/**
	 * @column(type="date",name="date_of_birth",nullable=true)
	 */
	public $dateOfBirth;
	
	/**
	 * @column(type="datetime",name="created",nullable=true)
	 */
	public $created;
	
	/**
	 * @Column(type="boolean", name="date_of_birth_visibility",nullable=true)
	 */
	private $dateOfBirthVisibility;
	
	/**
	 * @Column(type="boolean", name="ban")
	 */
	private $ban;
	
	
	/**
	 *
	 * @param $property \Doctrine\Common\Collections\Collection
	 *       	 @OneToMany(targetEntity="Project",mappedBy="user",
	 *        	cascade={"persist","remove"})
	 */
	private $projects;
	
	/**
	 * @ManyToMany(targetEntity="UserFieldOfInterestTag", inversedBy="users",cascade={"persist","remove"})
	 * @JoinTable(name="user_has_user_field_of_interest_tag",
	 * joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
	 * inverseJoinColumns={@JoinColumn(name="user_field_of_interest_tag_id",referencedColumnName="id")})
	 */
	private $userFieldOfInterestTags;
	

	public function __construct() {
		$this->userFieldOfInterestTags = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->roles = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->specRoles = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->projectRoles = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->floMessages = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->emailVisibility = false;
		$this->dateOfBirthVisibility = false;
		$this->confirmed = true;
		$this->dateOfBirth = new \DateTime();
		$this->created = new \DateTime("now");
		$this->ban = false;
		$this->info = new \App\Entity\UserInfo();
		
		// notification settings
		$this->emailNewsletter = true;
		$this->emailNotification = true;
	}
	
	public function setProfilePicture($path){
	
		$this->profilePicture = $path;
	}
	
	/**
	 * @return the $emailNewsletter
	 */
	public function getEmailNewsletter() {
		return $this->emailNewsletter;
	}

	/**
	 * @return the $emailNotification
	 */
	public function getEmailNotification() {
		return $this->emailNotification;
	}

	/**
	 * @param boolean $emailNewsletter
	 */
	public function setEmailNewsletter($emailNewsletter) {
		$this->emailNewsletter = $emailNewsletter;
	}

	/**
	 * @param boolean $emailNotification
	 */
	public function setEmailNotification($emailNotification) {
		$this->emailNotification = $emailNotification;
	}

	public function getProfilePicture($resolution = 200){
	
		if($this->profilePicture == null){
			return "no_image_".$resolution.".jpg";
		}
		
		// Return different resolutions
		if($resolution == \App\Entity\User::PROFILE_PHOTO_RESOLUTION_100 ||
				$resolution == \App\Entity\User::PROFILE_PHOTO_RESOLUTION_50 )
		{
			$ext = substr(strrchr($this->profilePicture, '.'), 1);
			$pre = substr($this->profilePicture,0,strrpos($this->profilePicture, '_'));
				
			return $pre.'_'.$resolution.'.'.$ext;
				
		}
	
		return $this->profilePicture;
	}
	
	/**
	 * Return all specific roles
	 */
	public function getSpecificRoles(){
		return $this->specRoles;
	}
	
	/**
	 * Delete specific role with all their tags
	 * @param unknown_type $name
	 */
	public function deleteSpecificRole($role){
	
		$role->setUser(null);
		$this->specRoles->removeElement($role);
	}

	/**
	 * @return the $role
	 */
	public function getRoles() {
		return $this->roles;
	}
	
	public function getRolesArray(){
		$r = array();
		foreach ($this->roles as $role){
			$r[] = $role->getName();
		}		
		return $r;
	}
	
	/**
	 * @param number $role
	 */
	public function addRole($role) {
		$role->addUser($this);
		$this->roles[] = $role;
	}
	
	public function addProjectRole($role){
		$role->setUser($this);
		$this->projectRoles[] = $role;
	}
	
	public function getId(){
		return $this->id;
	}

	/**
	 * Add new Specific Role
	 *
	 */
	public function addSpecificRole($name)
	{
		// add only if don't have this role
		if(!$this->getSpecificRole($name)){
			$this->specRoles[] = new \App\Entity\UserSpecificRole($name, $this);
		}
	}
	/**
	 * Return specific role on key index
	 */
	public function getSpecificRole($name){
			
		if($this->specRoles->count() > 0){
			foreach($this->specRoles as $role){
				if($role->getName() == $name){
					return $role;
				}
			}
		}
		return false;
	
	}
	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $user_tags
	 */
	public function addUserFieldOfInterestTag($tag) {
	
		$this->userFieldOfInterestTags[] = $tag;
		$tag->addUser($this); // synchronously updating inverse side
	}
	
	/**
	 * Returns user tags in format for form
	 */
	public function getUserFieldOfInterestTagsString(){	
		
		if($this->userFieldOfInterestTags->isEmpty()){
			
			return "";
		}
		
		if(!empty( $this->userFieldOfInterestTags)){
			
			foreach ($this->userFieldOfInterestTags as $tag){	
				$tags [] = $tag->getName();
			}	
			$implode = implode(',', $tags);
			return $implode;
		}
	}
	
	/**
	 * @return the $user_tags
	 */
	public function getUserFieldOfInterestTags() {
		return $this->userFieldOfInterestTags;
	}
	
	
	
	public function removeUserFieldOfInterestTag($userTag){
	
		$this->userFieldOfInterestTags->removeElement($userTag);
		$userTag->removeUser($this);
	}
	
	
	public function setPassword($value) {
		$this->password = sha1 ( $value );
	}
	
	
	/**
	 * @return the $emailVisibility
	 */
	public function getEmailVisibility() {
		return $this->emailVisibility;
	}

	/**
	 * @return the $country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * @return the $confirmed
	 */
	public function getConfirmed() {
		return $this->confirmed;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return the $dateOfBirth
	 */
	public function getDateOfBirth() {
		return $this->dateOfBirth;
	}

	/**
	 * @return the $dateOfBirthVisibility
	 */
	public function getDateOfBirthVisibility() {
		return $this->dateOfBirthVisibility;
	}

	/**
	 * @return the $projects
	 */
	public function getProjects() {
		return $this->projects;
	}



	/**
	 * @param field_type $emailVisibility
	 */
	public function setEmailVisibility($emailVisibility) {
		$this->emailVisibility = $emailVisibility;
	}

	/**
	 * @param field_type $country
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * @param field_type $confirmed
	 */
	public function setConfirmed($confirmed) {
		$this->confirmed = $confirmed;
	}

	/**
	 * @param field_type $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @param field_type $dateOfBirth
	 */
	public function setDateOfBirth($dateOfBirth) {
		$date = explode("/", $dateOfBirth);
		$datetime = new \DateTime();
		$datetime->setDate($date[0], $date[1], $date[2]);
		// set the datetime
		$this->dateOfBirth =  $datetime;
	}

	/**
	 * @param field_type $dateOfBirthVisibility
	 */
	public function setDateOfBirthVisibility($dateOfBirthVisibility) {
		$this->dateOfBirthVisibility = $dateOfBirthVisibility;
	}

	/**
	 * @param field_type $projects
	 */
	public function setProjects($projects) {
		$this->projects = $projects;
	}

	

	public function getPassword() {
		return $this->password;
	}
	
	public function setName($value) {
		$this->name =  $value ;
	}
	
	
	public function getName() {
		return $this->name;
	}
	
	public function setEmail($value) {
		$this->email =  $value ;
	}
	
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getUserInfo(){
		
		return $this->userInfo;
	}
	
	/**
	 * Profile Public Url
	 */
	public function getProfileUrl(){
		
		return '/member/profile/index/id/'.$this->id;
	}
	
	
	public function setUserInfo(\App\Entity\UserInfo $info){
		$this->userInfo = $info;
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
    
   