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

    public function createThumbnailAction()
    {
    	
    	if($this->_request->isPost()){
    		try{
    		//pr($_FILES);
    		$upload = new Zend_File_Transfer();
    		// Returns all known internal file information
    		$adapter = new Zend_File_Transfer_Adapter_Http();
    		$config = new Zend_Config(Zend_Registry::get('config'));
    		$tempPath = $config->app->storage->project_temp;
    		$tempWebPath = $config->app->storage->project_web_temp;
    		
    	 
    		// setting upload file
    		$adapter->setDestination($tempPath);
    		$adapter->addValidator('Size', false, 4*10*102400)
    		->addValidator('Count', false, 1)
    		->addValidator('Extension', false, 'jpg,jpeg,png')
    		->addValidator('IsImage', false);
    		
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
    			
    			// rename the file
    			$ext = findexts($info['name']);
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
    				$session['secondFormData'] = array("absolutPath" => $path,"webUrl" => $web_url );
    			
    			}else {
    				// create session with link to picture
    				$session_step2 = new Zend_Session_Namespace('projectStep2');
    				$session_step2->secondFormData = array("absolutPath" => $path,"webUrl" => $web_url);
    			};
    			
    			// response
    			$response = array("path" => $path,'web_url' => $web_url,'success' => "Picture uploaded successfully.");
    			$this->_response->setBody(json_encode($response));
    			 
   		
    		   $i++; // increment file
    		} // end foreach through all files
    		
    	} catch (Exception $e){
    		$this->_response->setHttpResponseCode(503);
    		$this->_response->setBody(json_encode($e->getMessage()));
    	}
    		
    }
    		
    }	
    		
    		
    		
    		
  
    	
//     	$path = "uploads/";
    	
//     	$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
//     	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
//     	{
//     		$name = $_FILES['photoimg']['name'];
//     		$size = $_FILES['photoimg']['size'];
//     		if(strlen($name))
//     		{
//     			list($txt, $ext) = explode(".", $name);
//     			if(in_array($ext,$valid_formats))
//     			{
//     				if($size<(1024*1024)) // Image size max 1 MB
//     				{
//     					$actual_image_name = time().$session_id.".".$ext;
//     					$tmp = $_FILES['photoimg']['tmp_name'];
//     					if(move_uploaded_file($tmp, $path.$actual_image_name))
//     					{
//     						mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
//     						echo "<img src='uploads/".$actual_image_name."' class='preview'>";
//     					}
//     					else
//     						echo "failed";
//     				}
//     				else
//     					echo "Image file size max 1 MB";
//     			}
//     			else
//     				echo "Invalid file format..";
//     		}
//     		else
//     			echo "Please select image..!";
    	
    	
    	
    
//     }
  //  }
   

}





