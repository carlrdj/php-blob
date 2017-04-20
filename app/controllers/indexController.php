<?php
namespace App\Controllers;
use App\Models\BlogPost;
class IndexController extends BaseController{
	public function getIndex($numpag = null){
		/*
		global $pdo;
		$sql = "SELECT * FROM blog_posts ORDER BY id DESC";
		$query = $pdo -> prepare($sql);
		$query -> execute();
		$blogPosts = $query -> fetchAll(\PDO::FETCH_ASSOC);*/

		//$blogPosts = BlogPost::query() -> orderBy('id', 'desc') -> get();
		$pag = $numpag;
		$ctaspags=BlogPost::count();
		$filaxpag = 3;
		$ctaspags = (($ctaspags % $filaxpag) == 0) ? ($ctaspags / $filaxpag) : ($ctaspags / $filaxpag) + 1;
    $ctaspags = (int)$ctaspags;
		$numpag = $numpag==null ? 0 : $numpag -1;
		

		$blogPosts = BlogPost::query() -> orderBy('id', 'desc') -> offset($numpag * $filaxpag) -> limit($filaxpag) -> get();
		return $this -> render('index.twig', ['blogPosts' => $blogPosts, 'ctaspags'=>$ctaspags, 'pag' => $pag]);
	}

	public function getBlog($imagen){
		$blogPost = BlogPost::where('titulo', $imagen ) -> first();
		//$blogPost = BlogPost::find(3);
		return $this -> render('blog.twig', ['blogPost' => $blogPost]);
	}
}
