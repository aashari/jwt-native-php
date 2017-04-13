<?php 

/* 
 * include this file for every php script that requires token
 */

include('../../vendor/autoload.php');
 
use \Firebase\JWT\JWT;

$config = file_get_contents("../../config.json");
$config = json_decode($config);

$jwtPayload = [];

//validate is HTTP_X_ACCESS_TOKEN is exists then validate the token,
//otherwise, break the page and return an error message
if(isset($_SERVER['HTTP_X_ACCESS_TOKEN'])){
	try{	
		
		$token = $_SERVER['HTTP_X_ACCESS_TOKEN'];
		
		$payload = JWT::decode($token,$config->jwt_secret,(array)$config->jwt_signing_alg);
		
		$newToken = $payload;
		$newToken->iat = time();
		$newToken->exp = time()+$config->jwt_token_lifetime;

		$newToken = JWT::encode($newToken,$config->jwt_secret);

		$jwtPayload = [
			'payload' => $payload,
			'token' => $newToken
		];

	}catch(\Exception $e){
		//if token is invalid, then return the error message
		$response['status'] = false;
		$response['payload'] = [
			'message' => $e->getMessage()
		];
		header("Content-Type: application/json");
		echo json_encode($response);
		exit();
	}
}else{
	$response['status'] = false;
	$response['payload'] = [
		'message' => 'token is required'
	];
	header("Content-Type: application/json");
	echo json_encode($response);
	exit();
}