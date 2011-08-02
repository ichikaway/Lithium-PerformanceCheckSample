<?php

namespace app\controllers;

use app\models\Posts;

class PostsController extends \lithium\action\Controller {

	public function index() {
		$posts = Posts::all();
		return compact('posts');
	}

	public function view($id) {
		$post = Posts::first($id);
		return compact('post');
	}

	public function add() {
		$post = Posts::create();

		if (($this->request->data) && $post->save($this->request->data)) {
			$this->redirect(array('Posts::view', 'args' => array($post->id)));
		}
		return compact('post');
	}

	public function edit() {
		$post = Posts::find($this->request->id);

		if (!$post) {
			$this->redirect('Posts::index');
		}
		if (($this->request->data) && $post->save($this->request->data)) {
			$this->redirect(array('Posts::view', 'args' => array($post->id)));
		}
		return compact('post');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Posts::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Posts::find($this->request->id)->delete();
		$this->redirect('Posts::index');
	}
}

?>