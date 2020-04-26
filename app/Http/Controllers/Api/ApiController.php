<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\User_tokens;
use Illuminate\Support\Str;

class ApiController extends Controller
{

	private $accessToken;

	public function __construct()
	{
		$this->accessToken = Str::random(65);
	}

	# Register
	public function register(Request $request)
	{
	    $rules = ['name' => 'required|min:3', 'email' => 'required|email|unique:users', 'password' => 'required|min:6'];

	    $validator = Validator::make($request->all(), $rules);
	    if ($validator->fails()) {
	      	return response()->json(['message' => $validator->messages()]);
	    } else {
	      	$data = ['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'created_at' => now(), 'updated_at' => now()];

	      	$user = User::insert($data);
	      	if($user) {
	        	return response()->json(['message' => ['name' => $request->name, 'email' => $request->email]]);
	      	} else {
	        	return response()->json(['message' => 'Registration failed, try again.']);
	      	}

	    }
	}

	# Login
	public function login(Request $request)
	{
    	$rules = ['email' => 'required|email', 'password' => 'required|min:6'];
    
    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
      		return response()->json(['message' => $validator->messages()]);
    	} 
    	else {
	      	$user = User::where('email', $request->email)->first();
	      	if($user) {
	        	if( password_verify($request->password, $user->password) ) {
		          	$data = ['user_id' => $user->id, 'access_token' => $this->accessToken, 'expires_at' => now()->addDays(30), 'created_at' => now(), 'updated_at' => now()];

	      			$accessToken = User_tokens::insert($data);
		          	if($accessToken) {
						return response()->json(['message' => ['name' => $user->name, 'email' => $user->email, 'access_token' => $this->accessToken]]);
		          	}
	        	}
	        	else {
	          		return response()->json(['message' => 'Invalid password.']);
	        	}
	      	}
	      	else {
	        	return response()->json(['message' => 'User not found.']);
	      	}
	    }
	}

	# Create token
	public function create(Request $request) 
	{
		$token = $request->access_token;

		$userToken = User_tokens::where('access_token', $token)->where('expires_at', '>=', now())->first();
		if($userToken) {
			$isVerified = User::where('is_verified', true)->where('id', $userToken->user_id)->first();
			if($isVerified) {
				$data = ['user_id' => $isVerified->id, 'access_token' => $this->accessToken, 'expires_at' => now()->addDays(30), 'created_at' => now(), 'updated_at' => now()];

				$accessToken = User_tokens::insert($data);
	          	if($accessToken) {
					return response()->json(['message' => ['access_token' => $this->accessToken]]);
	          	}
			} else {
				return response()->json(['message' => 'User is not verified.']);
			}
		} else {
			return response()->json(['message' => 'User not found.']);
		}
	}

	# Delete token
	public function delete(Request $request) 
	{
		$tokenHeader = $request->header('Auth');

		$userToken = User_tokens::where('access_token', $tokenHeader)->where('expires_at', '>=', now())->first();
		if($userToken) {
			$isVerified = User::where('is_verified', true)->where('id', $userToken->user_id)->first();
			if($isVerified) {
				$deleteToken = User_tokens::where('access_token', $request->token)->where('user_id', $isVerified->id)->delete();
	      		if($deleteToken) {
	        		return response()->json(['message' => 'Token is deleted.']);
	      		} else {
	      			return response()->json(['message' => 'Token data do not match.']);
	      		}
			} else {
				return response()->json(['message' => 'User is not verified.']);
			}
		} else {
			return response()->json(['message' => 'User not found.']);
		}
	}

   	# Logout
  	public function logout(Request $request)
  	{
    	$tokenHeader = $request->header('Auth');

    	$userToken = User_tokens::where('access_token', $tokenHeader)->where('expires_at', '>=', now())->first();
    	if($userToken) {
      		$logout = User_tokens::where('access_token', $tokenHeader)->delete();
      		if($logout) {
        		return response()->json(['message' => 'Logout is successful.']);
      		}
    	} else {
      		return response()->json(['message' => 'User not found.']);
    	}
  	}

}