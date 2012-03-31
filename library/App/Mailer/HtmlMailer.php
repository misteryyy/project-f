<?php
/**
 * Class HtmlMailer
 * Sends email from html templates from the /application/mails
 * User: misteryyy
 */
namespace App\Mailer;

class HtmlMailer extends \Zend_Mail
{
	/*
	 * Basic settings
	 */
static $fromEmail = "FLO~ Platform";
static $fromName = "info@floplatform.com";

/**
 * 
 * @var Zend_View static 
 */
static $_defaultView;

 	/**
     * current instance of our Zend_View
     * @var Zend_View
     */
protected $_view;

public function __construct($charset = "iso-8859-1"){
	parent::__construct($charset);
	$this->setFrom(self::$fromEmail, self::$fromName);
	$this->_view = self::getDefaultView();
}


	protected static function getDefaultView(){
		
 		if(self::$_defaultView == null){
 			self::$_defaultView = new \Zend_View();
 			self::$_defaultView->setScriptPath(APPLICATION_PATH."/emails");
 		}
 		return self::$_defaultView;
 	}
 
  public function sendHtmlTemplate($template, $encoding = \Zend_Mime::ENCODING_QUOTEDPRINTABLE){
  	$html = $this->_view->render($template);
  	
  	$smtpOptions = array(
  			'auth' => "login",
  			'username' => "info@floplatform.com",
  			'password' => "flow2011",
  			'ssl' => 'ssl',
  			'port' => 465
  	);
  	 
  	$smtpTransport = new Zend_Mail_Transport_Smtp('smtp.gmail.com',$smtpOptions);
  	$this->setBodyHtml($html,$this->getCharset(),$encoding);
  	$this->send($smtpOptions);
  }
 
  public function setViewParam($property,$value){
  	$this->_view->__set($property,$value);
  
  	return $this;
  }
  

}