
<?php

class Articles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Article_Model', 'article');
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->library('session');
        $this->output->set_content_type('application/json');
        
    }

    public function index() {
              $owner = $this->input->get('owner');

        $articles = $this->article->get_by_owner($owner);
            api_response(true, $articles);

    }

public function create()
    {
        $input = json_decode($this->input->raw_input_stream, true);
        $user_id = $this->session->userdata('user_id') ?? $input['ownerId'];
        $user_role = $this->session->userdata('user_role') ?? 'lawyer';


        if (!$user_id || !in_array($user_role, ['admin', 'lawyer'])) {
            return $this->_response(['error' => true, 'message' => 'Forbidden'], 403);
        }

        // Lawyers max 50 articles
        if ($user_role === 'lawyer') {
            $count = $this->article->count_by_owner_id($user_id);
            if ($count >= 50) {
                return $this->_response(['error' => true, 'message' => 'You have reached the maximum of 50 articles.'], 400);
            }
        }

        if (empty($input['title']) || empty($input['body'])) {
            return $this->_response(['error' => true, 'message' => 'Title and body are required.'], 422);
        }

        $slug = url_title(convert_accented_characters($input['title']), 'dash', true);

        $article = [
            'owner_id'     => $user_id,
            'title'        => $input['title'],
            'slug'         => $slug,
            'cover_url'    => isset($input['cover_url']) ? $input['cover_url'] : null,
            'excerpt'      => isset($input['excerpt']) ? $input['excerpt'] : null,
            'body'         => $input['body'],
            'published_at' => date('Y-m-d H:i:s'),
        ];

        $id = $this->article->insert($article);

        // return $this->_response(array_merge(['id' => $id], $article), 201);
        return api_response($article, 'berhasil ambil data articles');
    }

    public function update($id)
    {
        // --- 1. Coba ambil dari form-data ---
        $title   = $this->input->post('title');
        $body    = $this->input->post('body');
        $excerpt = $this->input->post('excerpt');
        $cover = $this->input->post('cover_url');

        // --- 2. Kalau kosong, coba ambil dari raw JSON ---
        if (empty($title) && empty($body)) {
            $input = json_decode($this->input->raw_input_stream, true);

            if ($input) {
                $title   = isset($input['title']) ? $input['title'] : null;
                $body    = isset($input['body']) ? $input['body'] : null;
                $excerpt = isset($input['excerpt']) ? $input['excerpt'] : null;
                $cover = isset($input['cover_url']) ? $input['cover_url'] : null;
            }
        }
        $data = [];

        if(empty($title) || $title == '')
            api_response(false, null, 'kolom title harus ada isinya');
        
        if(empty($excerpt) || $excerpt == '')
            api_response(false, null, 'kolom excerpt harus ada isinya');

        if(empty($body) || $body == '')
            api_response(false, null, 'tabel body harus ada isinya');

        $data = [
            'title' => $title,
            'excerpt' => $excerpt,
            'body' => $body,
            'cover_url' => $cover
        ];


        $result = $this->article->update($id, $data);

        return api_response(true, $data, 'berhasil mengupdate data');
    }

    public function delete($slug = null) {
    // Cek login
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
        return $this->_response(['error' => true, 'message' => 'Unauthorized'], 401);
    }

    if (!$slug) {
        return $this->_response(['error' => true, 'message' => 'Slug required'], 422);
    }

    // Ambil artikel dari DB
    $article = $this->article->get_by_slug($slug);

    if (!$article) {
        return $this->_response(['error' => true, 'message' => 'Article not found'], 404);
    }

    // Pengecekan hak akses: hanya owner sendiri
    if ($article['owner_id'] != $user_id) {
        return $this->_response(['error' => true, 'message' => 'Forbidden: you can only delete your own article'], 403);
    }

    // Hapus artikel
    $deleted = $this->article->delete_by_slug($slug);

    if ($deleted) {
        return $this->_response(['success' => true, 'message' => 'Article deleted'], 200);
    } else {
        return $this->_response(['error' => true, 'message' => 'Failed to delete'], 500);
    }
}

    public function show($id) {
              
        $article = $this->article->get_by_id($id);
            api_response(true, $article);
          
    }

    public function show_by_slug() {
        $input = json_decode(file_get_contents('php://input'), true);
        $slug = $input['slug'];
        $article = $this->article->get_by_slug($slug);
        api_response(true, $article);
          
    }


}