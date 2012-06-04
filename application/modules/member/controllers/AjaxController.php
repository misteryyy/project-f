<?php
class Member_AjaxController extends  Boilerplate_Controller_Action_Abstract
{
	
	public function init() {
		$this->_em = Zend_Registry::get ( 'em' );
		if (Zend_Controller_Action_HelperBroker::hasHelper('layout')) {
			$this->_helper->layout->disableLayout();
		}
		$this->_helper->viewRenderer->setNoRender(true);
		parent::init();
	}
    public function indexAction()
    { 
    		
    }
    /**
     * Updates Project Picture
     */
    public function updateProjectThumbnailAction(){
    	
    	if($this->_request->isPost()){
    		try{
    		// check if the project exists
    			
    			$facadeProject = new \App\Facade\ProjectFacade($this->_em);
    			$project = $facadeProject->findProjectForUser($this->_member_id,$_POST['id']);
    			
    			if($project){
    				$upload = new Zend_File_Transfer();
    				$adapter = new Zend_File_Transfer_Adapter_Http();
    				$config = Zend_Registry::get('config');
    				
    				$pathToTheProjectDir =$config['app']['storage']['project'].$project->dir.'/';
    				
    				// setting upload file
      				$adapter->setDestination($pathToTheProjectDir);
           				$adapter->addValidator('Size', false, 4*10*102400)
    	  				->addValidator('Count', false, 1)
	      				->addValidator('Extension', false, 'jpg,jpeg,png');
    				
    				$i= 1;
    				foreach ($adapter->getFileInfo() as $file => $info) {
    					// check if uploaded
    					if (!$adapter->isUploaded($file)) {
    						$errorMessage = "You haven't choose the file. Try it again :D.";
    						$this->_response->setBody(json_encode(array("error" => $errorMessage)));
    						break;
    					}
    				
    					// validators are ok ?
      					if (!$adapter->isValid($file)) {
      						$errorMessage = "Please check the file: ".$info["name"] . ".";
      						$this->_response->setBody(json_encode(array("error" => $adapter->getMessages())));
      						break;
      					}
    					
    					//$pathToCurrentPicture = $pathToTheProjectDir.$project->getPicture('orig');
    					
    				
    					$ext = substr(strrchr($info['name'],'.'), 1);
    					$fileName = 'project'.sha1("s@4d".$this->_member_id);
    				
    					// resolution path
    					$path = $pathToTheProjectDir.$fileName.'.'.$ext;
    					$web_url = $config['app']['storage']['project_web'].$project->dir.'/'.$fileName.'_large.'.$ext;
    				
    				
    					$adapter->addFilter('Rename',
    							array('target' => $path,
    									'overwrite' => true));
    					
    					// receiving files
    					if(!$adapter->receive($file)){
    						$this->_response->setBody(json_encode(array("error" =>  $adapter->getMessages())));
    						break;
    					}
    					 
    					// Processing new image and delete old images
    					
    					$facadeProject->updateProjectPicture($this->_member_id, $_POST['id'],$path,$fileName.'.'.$ext);
    					
    					
    					$response = array('web_url' => $web_url,"fileName" => $fileName.'.'.$ext,'success' => "Picture uploaded successfully.");
    					$this->_response->setBody(json_encode($response)); 
    					$i++; // increment file
    				} // end foreach through all files
    				
    				   
    			} else {
    				$this->_response->setBody(json_encode(array("error" => "Project for this user not found")));	
    			}
    			
    		}catch(\Exception $e){
    			$this->_response->setBody(json_encode(array("error" => $e->getMessage())));
    			
    		}
    		
    	}
    	
    }
    /**
     * Use for creating the thumbnail for project
     */
    public function createThumbnailAction()
    {
    	if($this->_request->isPost()){
    		try{
    			
    		//delete previous file
    		if(Zend_Session::namespaceIsset('projectStep2')){
    				$session = Zend_Session::namespaceGet('projectStep2');
    				if(is_file($session['secondFormData']['absolutPath'])){
    					unlink($session['secondFormData']['absolutPath']);
    				}
    				Zend_Session::namespaceUnset('projectStep2'); 
    				// restart the namespace    				 
    		}	


    		$upload = new Zend_File_Transfer();
    		// Returns all known internal file information
    		$adapter = new Zend_File_Transfer_Adapter_Http();
    		$config = Zend_Registry::get('config');
    		$tempPath = $config['app']['storage']['project_temp'];
    		$tempWebPath = $config['app']['storage']['project_web_temp'];
    		
    	 
    		// setting upload file
    		$adapter->setDestination($tempPath);
    		$adapter->addValidator('Size', false, 4*10*102400)
    		->addValidator('Count', false, 1)
    		->addValidator('Extension', false, 'jpg,jpeg,png');
    		
    		$i= 1;
    		foreach ($adapter->getFileInfo() as $file => $info) {
    			// check if uploaded
    			if (!$adapter->isUploaded($file)) {
    				$errorMessage = "You haven't choose the file. Try it again :D.";
    				//$this->_response->setHttpResponseCode(503);
    				$this->_response->setBody(json_encode(array("error" => $user->$errorMessage)));
    				break;
    			}
    		
    			// validators are ok ?
    			if (!$adapter->isValid($file)) {
    				//$this->_response->setHttpResponseCode(503);
    				$errorMessage = "Please check the file: ".$info["name"] . ".";
    				//$errorMessage .= implode("\n<br\>", $adapter->getMessages());
    				$this->_response->setBody(json_encode(array("error" => $adapter->getMessages())));
    				break;
    			}
    			
    			$ext = substr(strrchr($info['name'],'.'), 1);
    			
    			$fileName = 'project'.sha1("s@4d".$this->_member_id);
    			 
    			// resolution path
    			$path = $tempPath.$fileName.'.'.$ext;
    			$web_url = $tempWebPath.$fileName.'.'.$ext;
    			 
    			 
    			$adapter->addFilter('Rename',
    					array('target' => $path,
    							'overwrite' => true));
    			 
    			// receiving files
    			if(!$adapter->receive($file)){
    				//$this->_response->setHttpResponseCode(503);
    				$this->_response->setBody(json_encode(array("error" =>  $adapter->getMessages())));
    				break;
    			}
    			
    			//PROCESSING OF IMAGE
    			$imageManager = new \Boilerplate_Util_ImageManager($path);
    			$imageManager->resizeImage(480, 320, 'crop');
    			$imageManager->saveImage($path, 100);
		
    			if(Zend_Session::namespaceIsset('projectStep2')){
    				$session = Zend_Session::namespaceGet('projectStep2');
    				$session['secondFormData'] = array("absolutPath" => $path,"webUrl" => $web_url,"fileName" => $fileName.'.'.$ext );
    			
    			}else {
    				// create session with link to picture
    				$session_step2 = new Zend_Session_Namespace('projectStep2');
    				$session_step2->secondFormData = array("absolutPath" => $path,"webUrl" => $web_url ,"fileName" => $fileName.'.'.$ext);
    			};
    			
    			// response
    			$response = array("path" => $path,'web_url' => $web_url,"fileName" => $fileName.'.'.$ext,'success' => "Picture uploaded successfully.");
    			$this->_response->setBody(json_encode($response));
    			 
   		
    		   $i++; // increment file
    		} // end foreach through all files
    		
    	} catch (Exception $e){
    		$this->_response->setHttpResponseCode(503);
    		$this->_response->setBody(json_encode($e->getMessage()));
    	}
    		
    }
    		
    }	

}





