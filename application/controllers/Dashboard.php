<?php

class Dashboard extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // ini wajib
        $this->load->helper(['form', 'url']);
    }

    public function index() {
        $this->load->view('layouts/dashboard', ['content' => 'dashboard/index','title' => 'Dashboard']);
    }

    public function MyArticles(){
        $this->load->model('Article_Model');
        $owner_id = $this->session->userdata('user_id');
        $myArticle = $this->Article_Model->get_by_owner_id($owner_id);

        // untuk edit page articles ada di /view/dashboard/my_articles.php
        $this->load->view('layouts/dashboard', ['content' => 'dashboard/my_articles','title' => 'My Articles', 'articles' => $myArticle]);

    }

    public function create()
    {
        $this->load->view('dashboard/create_article');
    }

    // Simpan artikel baru (request ke API)
    public function store()
    {
        $ownerId   = $this->session->userdata('user_id'); // ambil dari session login
        $title     = $this->input->post('title');
        $slug      = $this->input->post('slug');
        $excerpt   = $this->input->post('excerpt');
        $body      = $this->input->post('body');
        $status    = $this->input->post('status');
        $published = $this->input->post('published_at');

        // Handle upload cover
        $coverUrl = null;
        if (!empty($_FILES['coverUrl']['name'])) {
            $config['upload_path']   = './uploads/articles/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('coverUrl')) {
                $uploadData = $this->upload->data();
                $coverUrl   = base_url('uploads/articles/' . $uploadData['file_name']);
            } else {
                $error = $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('dashboard/articles/create');
                return;
            }
        }

        // Data untuk dikirim ke API
        $postData = [
            'ownerId'     => $ownerId,
            'title'       => $title,
            'slug'        => $slug,
            'cover_url'    => $coverUrl,
            'excerpt'     => $excerpt,
            'body'        => $body,
            'status'      => $status,
            'published_at'=> $published
        ];

        // Request ke API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, site_url('/api/articles/create'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if (in_array($httpcode, [200, 201])) {
            $this->session->set_flashdata('success', 'Artikel berhasil dibuat.');
            redirect('dashboard/articles');
        } else {
            $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal membuat artikel';
            $this->session->set_flashdata('error', $errorMsg);
            redirect('dashboard/articles/create');
        }
    }

    public function delete($slug)
{
    $this->load->model('Article_Model');
    $user_id = $this->session->userdata('user_id');
    $user_role = $this->session->userdata('user_role');

    if (!$user_id) {
        $this->session->set_flashdata('error', 'Anda harus login terlebih dahulu.');
        redirect('dashboard/articles');
        return;
    }

    if ($user_role != "lawyer" && $user_role != "admin") {
        $this->session->set_flashdata('error', 'Hanya Lawyer dan Admin Yang Boleh Menghapus Article');
        redirect('dashboard/articles');
        return;
    }

    $article = $this->Article_Model->get_by_slug($slug);

    if (!$article) {
        $this->session->set_flashdata('error', 'Artikel tidak ditemukan.');
        redirect('dashboard/articles');
        return;
    }

    if ($article['owner_id'] != $user_id) {
        $this->session->set_flashdata('error', 'Anda hanya bisa menghapus artikel sendiri.');
        redirect('dashboard/articles');
        return;
    }

    if (!empty($article['cover_url'])) {
        $filePath = FCPATH . str_replace(base_url(), '', $article['cover_url']);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }

    $deleted = $this->Article_Model->delete_by_slug($slug);

    if ($deleted) {
        $this->session->set_flashdata('success', 'Artikel berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus artikel.');
    }

    redirect('dashboard/articles');
}


public function MyClient($client_id){




}

}
