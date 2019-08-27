<?php
	function redirectTo($url){
		header("Location: $url");
		exit;
	}

	function makeActive(){
		return "active";
	}

	function uploadPicture($file = ''){
		$file = $_FILES[$file];
		$maxFileSize = (int)ini_get('upload_max_filesize') * 1024 * 1024;

		if($file['size'] <= $maxFileSize){
			if(($file['type'] == "image/jpeg") || ($file['type'] == "image/pjpeg") || ($file['type'] == "image/gif") || ($file['type'] == "image/png")){

				if($file['type'] == "image/jpeg" || $file['type'] == "image/pjpeg"){
					$ext = ".jpg";
				}elseif($file['type'] == "image/png"){
					$ext = ".png";
				}elseif($file['type'] == "image/gif"){
					$ext = ".gif";
				}

				if($file['error'] > 0){
					//Error has occured
					return false;
				}else{
					$hand = $file['name'];
					$handle = sha1($hand) . time() .$ext;
					if(file_exists("images/uploads/" . $handle)){
						//File already exists
						return false;
					}else{
						move_uploaded_file($file['tmp_name'], "images/uploads/" . $handle);
						return $handle;
					}
				}
			}else{
				//File type not allowed, please select another file
				return false;
			}
		}else{
			//File size exceeds allowed maximum
			return false;
		}
	}

	function uploadPictureAdmin($file = ''){
		$file = $_FILES[$file];
		$maxFileSize = (int)ini_get('upload_max_filesize') * 1024 * 1024;

		if($file['size'] <= $maxFileSize){
			if(($file['type'] == "image/jpeg") || ($file['type'] == "image/pjpeg") || ($file['type'] == "image/gif") || ($file['type'] == "image/png")){

				if($file['type'] == "image/jpeg" || $file['type'] == "image/pjpeg"){
					$ext = ".jpg";
				}elseif($file['type'] == "image/png"){
					$ext = ".png";
				}elseif($file['type'] == "image/gif"){
					$ext = ".gif";
				}

				if($file['error'] > 0){
					//Error has occured
					return false;
				}else{
					$hand = $file['name'];
					$handle = sha1($hand) . time() .$ext;
					if(file_exists("../images/uploads/" . $handle)){
						//File already exists
						return false;
					}else{
						move_uploaded_file($file['tmp_name'], "../images/uploads/" . $handle);
						return $handle;
					}
				}
			}else{
				//File type not allowed, please select another file
				return false;
			}
		}else{
			//File size exceeds allowed maximum
			return false;
		}
	}


	function uploadFile($file = ''){
		$file = $_FILES[$file];
		$uploadMaxFileSize = (int)ini_get('upload_max_filesize') * 1024 * 1024;
		$postMaxFileSize = (int)ini_get('post_max_size') * 1024 * 1024;
		$return = array('error' => 0, 'url' => '');

		if($file['size'] <= $uploadMaxFileSize){
			if($file['size'] <= $postMaxFileSize){
					if($file['error'] > 0){
						//Error has occured
						$return['error'] = 'Error opening file, please try again';
						return $return;
					}else{
						$handle = $file['name'];
						if(file_exists("uploads/" . $handle)){
							//File already exists
							$return['error'] = 'File already exists, please rename the file, and re-upload';
							return $return;
						}else{
							move_uploaded_file($file['tmp_name'], "uploads/" . $handle);
							$return['url'] = $handle;
							return $return;
						}
					}
			}else{
				//File size exceeds allowed maximum
				$return['error'] = 'The selected file exceeds the allowed filesize of ' . ini_get('post_max_size') . 'B';
				return $return;
			}


		}else{
			//File size exceeds allowed maximum
			$return['error'] = 'The selected file exceeds the allowed filesize of ' . ini_get('upload_max_filesize') . 'B';
			return $return;
		}
	}
?>
