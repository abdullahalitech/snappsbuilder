<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	
	if ($_REQUEST['currentUser']!="" && $_REQUEST['site_id']!="") {
		
		$current_user 	= $_REQUEST['currentUser'];
		$site_name 		= $_REQUEST['site_id'];
		
		//$createNewWebsite=preg_replace( "/[^a-zA-Z0-9\-\.\_]/",'',$site_name);
		$parent = 'edit';
		
		
		$websiteLocation='../edit/'.$current_user;
		
		
		if(!is_dir($websiteLocation)){
			mkdir($websiteLocation,0755);
		}
		
		$websiteLocation .= '/'.$site_name;
		
		if(!is_dir($websiteLocation)){
			mkdir($websiteLocation,0755);
		}
			 

		// create base files:
		file_put_contents($websiteLocation.'/.htaccess','
		#BEGIN-Kopage
		RewriteEngine on
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteRule ^(.*)?$ index.php?p=$1 [QSA,L]
		#END-Kopage');

		file_put_contents($websiteLocation.'/index.php','<?php 

		// load custom configuration from home folder
		include("../../../kopage.custom-configuration.php");
		
		// define where Kopage system files are
		define("FilexLocation","../../../kopage_files/");
		
		// load Kopage
		include(FilexLocation."index.php");');

		file_put_contents($websiteLocation.'/admin.php','<?php 

		// load custom configuration from home folder
		include("../../../kopage.custom-configuration.php");
		
		// define where Kopage system files are
		define("FilexLocation","../../../kopage_files/");
		
		// load Kopage
		include(FilexLocation."admin.php");');
		
		
		response($_REQUEST['currentUser'], $_REQUEST['site_name'], 200, 'success');
		
	}else{
		response(NULL, NULL, 400, 'empty fields');
	}

function response($current_user,$site_id,$response_code,$msg){
	$response['current_user'] 	= $current_user;
	$response['site_id'] 		= $site_id;
	$response['response_code'] 	= $response_code;
	$response['message'] 		= $msg;
	
	$json_response = json_encode($response);
	echo $json_response;
}
?>