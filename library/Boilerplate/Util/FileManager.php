<?php

class Boilerplate_Util_FileManager
{	

		// *** Class variables
		private $file;
		private $type;
		private $uploadDir; // path from the web root
		private $absolutPath; // absolut path to the root
		private $webPath;
		private $project; // project entity
		
		function __construct($project,$uploadDir,$fileName)
		{
			$this->project = $project;
			$this->absolutPath = APPLICATION_PATH .  '/../public/'.$uploadDir.'/';
			$this->webPath = $uploadDir."/".$fileName;
		}
		
		/**
		 * Upload Files From Post Data
		 * @throws \Exception
		 */	
		function uploadFileFromPost(){			
					$upload = new Zend_File_Transfer();
					$adapter = new Zend_File_Transfer_Adapter_Http();
				
					// setting upload file
					$adapter->setDestination($this->absolutPath);
					$adapter->addValidator('Size', false, 4*10*102400)
					->addValidator('Count', false, 5)
					->addValidator('Extension', false, 'pdf,doc,docx,odt,jpg,jpeg,png');
				
					// validate files	
					$i= 1;
					foreach ($adapter->getFileInfo() as $file => $info) {
 						// check if uploaded
 						if ($adapter->isUploaded($file)) {
 										// validators are ok ?
 							 			if (!$adapter->isValid($file)) {	 							 				
 							 				throw new \Exception($file . " is not valid. ");
 							 			}
 						}
 						$i++; // increment file
					}
					
					// copying and renaming files
					$i= 1;
					foreach ($adapter->getFileInfo() as $file => $info) {
						if ($adapter->isUploaded($file)) {
							$ext = substr(strrchr($info['name'],'.'), 1);
							$fileName = 'f'.time().$i;
							$path = $this->absolutPath.$fileName.'.'.$ext;
							$files[] = array('file' => $fileName.'.'.$ext, 'type' => $info['type'],'size'=> $info['size']);	
					
							$adapter->addFilter('Rename',
	 								array('target' => $path,
	 										'overwrite' => true));
								
 						// receiving files
	 						if(!$adapter->receive($file)){
								throw new \Exception("Can't upload file ".$file);		
	 						}					
						
						}
						$i++; // increment file
					}
					return $files;
		}

/*
 * Updated, recognition by mimetype
 */
private function openImage($file)
{
		//$extension = strtolower(strrchr($file, '.'));	
		$info = getimagesize($file);
		switch($info['mime'])
		{
				case 'image/jpeg':
				$img = imagecreatefromjpeg($file);
				break;
				case 'image/gif':
				$img = imagecreatefromgif($file);
				break;
				case 'image/png':
				$img = imagecreatefrompng($file);
				break;
				default:
				$img = false;
				break;
		}
		return $img;
}
	
				## --------------------------------------------------------
	
				public function resizeImage($newWidth, $newHeight, $option="auto")
				{
				// *** Get optimal width and height - based on $option
					$optionArray = $this->getDimensions($newWidth, $newHeight, $option);
	
					$optimalWidth  = $optionArray['optimalWidth'];
					$optimalHeight = $optionArray['optimalHeight'];
	
	
					// *** Resample - create image canvas of x, y size
				$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
				imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
	
	
				// *** if option is 'crop', then crop too
				if ($option == 'crop') {
				$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
				}
				}
	
				## --------------------------------------------------------
					
				private function getDimensions($newWidth, $newHeight, $option)
				{
	
				switch ($option)
				{
				case 'exact':
					$optimalWidth = $newWidth;
						$optimalHeight= $newHeight;
						break;
						case 'portrait':
						$optimalWidth = $this->getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
						break;
						case 'landscape':
						$optimalWidth = $newWidth;
						$optimalHeight= $this->getSizeByFixedWidth($newWidth);
						break;
						case 'auto':
						$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
						case 'crop':
						$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
					}
					return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
				}
	
				## --------------------------------------------------------
	
					private function getSizeByFixedHeight($newHeight)
					{
						$ratio = $this->width / $this->height;
						$newWidth = $newHeight * $ratio;
						return $newWidth;
						}
	
						private function getSizeByFixedWidth($newWidth)
						{
						$ratio = $this->height / $this->width;
						$newHeight = $newWidth * $ratio;
						return $newHeight;
						}
	
						private function getSizeByAuto($newWidth, $newHeight)
						{
						if ($this->height < $this->width)
							// *** Image to be resized is wider (landscape)
					{
						$optimalWidth = $newWidth;
						$optimalHeight= $this->getSizeByFixedWidth($newWidth);
						}
						elseif ($this->height > $this->width)
						// *** Image to be resized is taller (portrait)
				{
						$optimalWidth = $this->getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
						}
						else
							// *** Image to be resizerd is a square
							{
						if ($newHeight < $newWidth) {
						$optimalWidth = $newWidth;
						$optimalHeight= $this->getSizeByFixedWidth($newWidth);
						} else if ($newHeight > $newWidth) {
						$optimalWidth = $this->getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
						} else {
						// *** Sqaure being resized to a square
							$optimalWidth = $newWidth;
							$optimalHeight= $newHeight;
						}
						}
	
						return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
						}
	
						## --------------------------------------------------------
	
						private function getOptimalCrop($newWidth, $newHeight)
						{
	
						$heightRatio = $this->height / $newHeight;
						$widthRatio  = $this->width /  $newWidth;
	
						if ($heightRatio < $widthRatio) {
						$optimalRatio = $heightRatio;
						} else {
						$optimalRatio = $widthRatio;
						}
	
						$optimalHeight = $this->height / $optimalRatio;
						$optimalWidth  = $this->width  / $optimalRatio;
	
						return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
						}
	
						## --------------------------------------------------------
	
						private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
						{
						// *** Find center - this will be used for the crop
							$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
							$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );
	
							$crop = $this->imageResized;
							//imagedestroy($this->imageResized);
	
						// *** Now crop from center to exact requested size
						$this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
						imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
						}
	
						
						/**
						 * Save Image
						 * @param unknown_type $savePath
						 * @param unknown_type $imageQuality
						 */
						public function saveImage($savePath, $imageQuality="100")
						{
							
						// *** Get extension
						$extension = strrchr($savePath, '.');
						$extension = strtolower($extension);
	
						switch($extension)
						{
							case '.jpg':
							case '.jpeg':
								if (imagetypes() & IMG_JPG) {
									imagejpeg($this->imageResized, $savePath, $imageQuality);
								}
								break;
	
							case '.gif':
								if (imagetypes() & IMG_GIF) {
									imagegif($this->imageResized, $savePath);
								}
								break;
	
							case '.png':
								// *** Scale quality from 0-100 to 0-9
								$scaleQuality = round(($imageQuality/100) * 9);
	
								// *** Invert quality setting as 0 is best, not 9
								$invertScaleQuality = 9 - $scaleQuality;
	
								if (imagetypes() & IMG_PNG) {
								 imagepng($this->imageResized, $savePath, $invertScaleQuality);
								}
								break;
							default:
								// *** No extension - No save.
								break;
						}
	
						imagedestroy($this->imageResized);
						}

	
			}
