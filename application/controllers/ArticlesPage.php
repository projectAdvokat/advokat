

<?php

class ArticlesPage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->model('Article_Model', 'article');
    }

    public function index() {
        $articles = api_get('/api/articles?owner=all')['data'];
        
        $this->load->view('articles/index', ['articles' => $articles]);
    }
    public function show($id) {

        $article = api_get('api/articles/show/'.$id)['data'];

        
        $this->load->view('articles/show', ['article' => $article,'id'=>$id]);
    }

}