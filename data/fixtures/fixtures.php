<?php
/**
 * Created by Studio Slepice
 * User: Misteryyy
 * Date: 4.4.2012
 * Time: 
 */

// // PROJECT ROLES
// const MEMBER_ROLE_STARTER = "starter";
// const MEMBER_ROLE_BUILDER = "builder";
// const MEMBER_ROLE_GROWER = "grower";
// const MEMBER_ROLE_LEADER = "leader";
// const MEMBER_ROLE_ADVISER = "advisor";

// $arrayRoles = array(array("name" => MEMBER_ROLE_STARTER, ),
// 		array("name" => MEMBER_ROLE_LEADER),
// 		array("name" => MEMBER_ROLE_BUILDER),
// 		array("name" => MEMBER_ROLE_GROWER),
// 		array("name" => MEMBER_ROLE_ADVISER)
// );

// foreach($arrayRoles as $role){
// 	$rObj = new \App\Entity\ProjectRole($role['name']);
// 	$em->persist($rObj);	
// }

// $em->flush();


// SETTING BASIC SYSTEM ROLES
$role_visitor = new \App\Entity\UserRole();
$role_visitor->setName(\App\Entity\UserRole::SYSTEM_ROLE_VISITOR);
$role_visitor->setType(\App\Entity\UserRole::TYPE_SYSTEM);
$em->persist($role_visitor);

$role_member = new \App\Entity\UserRole();
$role_member->setName(\App\Entity\UserRole::SYSTEM_ROLE_MEMBER);
$role_member->setType(\App\Entity\UserRole::TYPE_SYSTEM);
$em->persist($role_member);

$role_admin = new \App\Entity\UserRole();
$role_admin->setName(\App\Entity\UserRole::SYSTEM_ROLE_ADMIN);
$role_admin->setType(\App\Entity\UserRole::TYPE_SYSTEM);
$em->persist($role_admin);

// CREATING CATEGORIES
$categories = array('Design','Performing arts','Technology', 'Writing', 'Social change', 'Business');
foreach ($categories as $category){
	$cat = new \App\Entity\Category($category);
	$em->persist($cat);
}

// CREATING PROJECT SURVEYS QUESTION
 $question = array(
 'What problem does your idea solve?',
'Did the idea come about because it was your own personal problem?',
'Is this idea new--or are you just trying to be better than the competition?',
'On a scale of 1-10, how passionate are you about this idea?',
'Have you sought outside feedback and validation? Who?',
'How enthusiastic are they?',
'Are people willing to pay for your product? If so, do you know how much?',
'How and when will you make your first dollar?',
'Do you have domain expertise? if not, do you have the skills and time to gain that knowledge?',
'How big is the market?',
'How crowded is the market?',
'How simple will it be to complete a minimum viable product (MVP)',
'What is the most basic version you can get out in 60 days?',
'In 90 days?',
'What message are you looking to convey with your product?',
'Have you focussed in on your value proposition? If so, what is it?'
);

foreach($question as $q){
	$qObj = new \App\Entity\ProjectSurveyQuestion($q);
	$em->persist($qObj);	
}


// Creating Slideshow
$slideshow = new \App\Entity\Slideshow();
$em->persist($slideshow);
$em->flush();



//////////////////////////////////////////////////////////
//Creating Admins

// adding people to account
$project = new \App\Entity\User();
$project->setEmail("j.kortan@gmail.com");
$project->setPassword("pi2131221");
$project->setName("Josef Kortan");

// setting roles
$project->addRole($role_visitor);
$project->addRole($role_member);
$project->addRole($role_admin);

// adding userInfo / skype, phone, ...
$userInfo = new \App\Entity\UserInfo();
$project->setUserInfo($userInfo);
$em->persist($project);


$user2 = new \App\Entity\User();
$user2->setEmail("visitor@gmail.com");
$user2->setPassword("visitor");
$user2->setName("Visitor Jean");
// setting roles
$user2->addRole($role_visitor);
$user2->addRole($role_member);

// adding userInfo / skype, phone, ...
$userInfo = new \App\Entity\UserInfo();
$user2->setUserInfo($userInfo);

$em->persist($user2);
$em->flush();


