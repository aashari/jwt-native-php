<?php 

/* 
 * this is an endpoint to generate a JWT Token
 */

include('../../vendor/autoload.php');

use \Firebase\JWT\JWT;

$config = file_get_contents("../../config.json");
$config = json_decode($config);

$response = [];

if(isset($_POST['username']) && isset($_POST['password'])){

	//TODO: do check username and password below

	//for example purpose, we use below dataset for users
	//key represent username and value represent password
	$users = [
		'aashari' => 'qweqwe123',
		'andi.mqa' => 'adminadmin'
	];

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(isset($users[$username]) && $users[$username]==$password){

		$jwtPayload = [
			'username' => $username,
			'iat' => time(),
			'exp' => time() + $config->jwt_token_lifetime
		];


		$jwt = JWT::encode($jwtPayload,$config->jwt_secret);

		$response['status'] = true;
		$response['jwt'] = [
			'payload' => $jwtPayload,
			'token' => $jwt
		];

	}else{
		$response['status'] = false;
		$response['payload'] = [
			'message' => 'invalid username and password'
		];
	}

}else{
	$response['status'] = false;
	$response['payload'] = [
		'message' => 'username & password is required'
	];
}

header("Content-Type: application/json");
echo json_encode($response);