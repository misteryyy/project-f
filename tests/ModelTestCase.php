<?php

/**
 * Description of ModelTestCase
 *
 * @author misteryyy
 */
class ModelTestCase extends PHPUnit_Framework_TestCase {

    /**
     *
     * @var \Bisna\Application\Container\DoctrineContainer
     */
    protected $doctrineContainer;
 	protected $em;

 
    public function setUp()
    {
    	global $application;
    	$application->bootstrap();
    	$this->doctrineContainer = Zend_Registry::get('doctrine');  	
    	$em = $this->doctrineContainer->getEntityManager();
    	$this->em = $em;
    	$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
    	$tool->dropDatabase();
    	$tool->createSchema($em->getMetadataFactory()->getAllMetadata());
    
    	parent::setUp();
    }
    
    
    public function tearDown()
    {
    	$this->doctrineContainer->getConnection()->close();
    	$em = $this->doctrineContainer->getEntityManager();
    	$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
    	
    	//$tool->dropDatabase();
    	parent::tearDown();
    }
 }
    
    



