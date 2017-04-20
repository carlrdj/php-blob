<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\BlogPost;
use Sirius\Validation\Validator;

class PostController extends BaseController{
	public function getIndex()
	{
		/*
		// admin/post or admin/post/index
		global $pdo;
		$sql = "SELECT * FROM blog_posts ORDER BY id DESC";
		$query = $pdo -> prepare($sql);
		$query -> execute();
		$blogPosts = $query -> fetchAll(\PDO::FETCH_ASSOC);
		*/
		$blogPosts = BlogPost::all();
		return $this -> render('admin/posts.twig', ['blogPosts' => $blogPosts]);
	}
	public function getCreate()
	{
		// admin/post/create or admin/post/create/index
		return $this -> render('admin/insert-post.twig', []);
	}
	public function postCreate()
	{
		/*
		global $pdo;
		// admin/post/create or admin/post/create/index
		$titulo = $_POST['title'];
		$contenido = $_POST['content'];
		$sql = 'INSERT INTO blog_posts (titulo, contenido) VALUES (:titulo, :contenido)';

		$query = $pdo -> prepare($sql);
		$result = $query -> execute([
			'titulo' => $titulo,
			'contenido' => $contenido
		]);
		*/
		$titulo = $_POST['title'];
		$contenido = $_POST['content'];
		$img_url = $_POST['img'];
		$blogPost = new BlogPost([
			'titulo' => $titulo,
			'contenido' => $contenido
		]);
		if ($img_url) {
			$blogPost -> img_url = $img_url;
		}

		$blogPost -> save();
		$result = true;
		return $this -> render('admin/insert-post.twig', ['result' => $result]);
	}

	public function getUpdate($id){
		$result = false;
		$blogPost = BlogPost::where('id', $id) -> first();
		return $this -> render('admin/update-post.twig', ['result' => $result, 'blogPost' => $blogPost]);
	}

	public function postUpdate($id){
		$errors = [];
		$result = false;

		$validator = new Validator();
		$validator -> add('titulo', 'required');
		$validator -> add('contenido', 'required');		
		if($validator -> validate($_POST)){
			$id = $_POST['id'];
			$titulo = $_POST['titulo'];
			$contenido = $_POST['contenido'];
			$img_url = $_POST['img_url'];
				
			$result = BlogPost::where('id', $id ) -> update([
				'titulo' => $titulo,
				'contenido' => $contenido,
				'img_url' => $img_url
			]);

			$result = true;

			$blogPost = BlogPost::where('id', $id) -> first();
			return $this -> render('admin/update-post.twig', ['result' => $result, 'blogPost' => $blogPost]);
		}else{
			$errors = $validator -> getMessages();
		}
	}
	public function postIndex(){		
		$id = $_POST['id'];
		print($id);
		BlogPost::where('id', $id ) -> delete();
		header('location:' . BASEURL . 'admin/posts');
	}
}