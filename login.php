<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	
	if ($_REQUEST['currentUser']!="" && $_REQUEST['site_id']!="") {
		
		$current_user 	= $_REQUEST['currentUser']; 
		$site_name 		= $_REQUEST['site_id'];
		
		$loginToWebsite=preg_replace( "/[^a-zA-Z0-9\-\.\_]/",'',$site_name);
		
		
		$websiteLocation='edit/'.$current_user.'/'.$loginToWebsite;
		
		// use temporary key to login
		$loginKey=md5(microtime());
		
		$websiteLocation='../edit/'.$current_user;
		
		
		if(!is_dir($websiteLocation)){
			mkdir($websiteLocation,0755);
		}
		
		$websiteLocation .= '/'.$site_name;
		
		if(!is_dir($websiteLocation.'/data')){
			mkdir($websiteLocation.'/data',0755);
		}
		
		
		file_put_contents($websiteLocation.'/data/key.'.$loginKey.'.txt','');
		
		$wlocation 	= 'https://builder.snapps.ai/edit/'.$current_user.'/'.$site_name;
		$url		=  $wlocation.'/admin.php?key='.$loginKey;	 
		response($url, 200, 'success');
		
	}else{
		response(NULL, 400, 'Unauthorize access');
	}

function response($url,$response_code,$msg){
	$response['redirect_url'] 	= $url;
	$response['response_code'] 	= $response_code;
	$response['message'] 		= $msg;
	
	$json_response = json_encode($response);
	echo $json_response;
}
?>