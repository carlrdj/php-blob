<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\User;

class IndexController extends BaseController{
	public function getIndex()
	{
		/*if(isset($_SESSION['userId'])){
			$userId = $_SESSION['userId'];
			$user = User::find($userId);
			if($user){
				return $this -> render('admin/index.twig', ['user' => $user]);
			}
		}else {
			header('location:' . BASEURL . 'auth/login');
		}*/
		$userId = $_SESSION['userId'];
		$user = User::find($userId);
		return $this -> render('admin/index.twig', ['user' => $user]);

	}
}
