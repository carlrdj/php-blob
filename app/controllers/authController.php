<?php
namespace App\Controllers;
session_start();
use App\Models\User;
use Sirius\Validation\Validator;

class AuthController extends BaseController{
	public function getLogin(){				
		return $this -> render('login.twig', []);
	}
	public function postLogin(){	
		$errors = [];

		$validator = new Validator();
		$validator -> add('email', 'required');
		$validator -> add('email', 'email');
		$validator -> add('password', 'required');

		if($validator -> validate($_POST)){
			$email = $_POST['email'];
			$password = $_POST['password'];			
			$user = User::where('email', $email) -> first();
			if($user){
				if(password_verify($password, $user -> password)){
					$_SESSION['userId'] = $user -> id;
					header('location:' . BASEURL . 'admin');
					return null;
				}
			}
			$validator -> addMessage('email', 'Username and/or password does not match');
		}else{
			$errors = $validator -> getMessages();
		}

		
		return $this -> render('login.twig', [
			'errors' => $errors]);
	}


	public function getLogout(){
		unset($_SESSION['userId']);
		header('location:' . BASEURL . 'auth/login');
	}
}
