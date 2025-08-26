
<?php

class Articles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Article_Model', 'article');
    }

    public function index() {
              $owner = $this->input->get('owner');

        $articles = $this->article->get_by_owner($owner);
            api_response(true, $articles);





    }

}