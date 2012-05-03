<?php
/**
 * Created by Studio Slepice
 * User: Misteryyy
 * Date: 4.4.2012
 * Time: 
 */

// SETTING BASIC ROLES
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

//////////////////////////////////////////////////////////
//Creating Admins

// adding people to account
$user = new \App\Entity\User();
$user->setEmail("j.kortan@gmail.com");
$user->setPassword("pi2131221");
$user->setName("Josef Kortan");

$user2 = new \App\Entity\User();
$user2->setEmail("j.ko@gmail.com");
$user2->setPassword("pi2131221");
$user2->setName("Josef Kortan");


// setting roles
$user->addRole($role_visitor);
$user->addRole($role_member);
$user->addRole($role_admin);


// adding userInfo / skype, phone, ...
$userInfo = new \App\Entity\UserInfo();
$user->setUserInfo($userInfo);
$em->persist($user);
$em->persist($user2);
$em->flush();

//$user = $this->em->getRepository ('\App\Entity\User')->findOneById ( $id  );

// $user = $em->getRepository ('\App\Entity\User')->findOneById ( 1);
// $info = $em->getRepository ('\App\Entity\UserInfo')->findOneById ( 1);
// $user->getUserInfo()->setIm("neeeeww");
// $em->flush();


