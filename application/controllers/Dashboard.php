<?php

class Dashboard extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // ini wajib
        $this->load->helper(['form', 'url']);
    }
    
    public function AllUsers(){
        $this->load->model('User_Model','user');
        $allUser = $this->user->get_all();
        $this->load->view('layouts/dashboard', ['content' => 'dashboard/admin/users/index','title' => 'users', 'users' => $allUser]);






    }



    public function index() {
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('user_role');

        if($user_id){
            $this->load->view('layouts/dashboard', ['content' => 'dashboard/index','title' => 'Dashboard']);
        } else {
            redirect(base_url('login'));
        }
    }

//  my articles tanpa pagination

    // public function MyArticles(){
    //     $this->load->model('Article_Model');
    //     $owner_id = $this->session->userdata('user_id');
    //     $user_role = $this->session->userdata('user_role');
    //     $myArticle = $this->Article_Model->get_by_owner_id($owner_id);


    //     if($user_role==='admin'){
    //         $all_articles = api_get('api/articles?owner=all');
    //         $this->load->view('layouts/dashboard', ['content' => 'dashboard/admin/articles/index','title' => 'Articles', 'articles' => $all_articles]);
    //     }else if($user_role==='lawyer'){
    //         $this->load->view('layouts/dashboard', ['content' => 'dashboard/my_articles','title' => 'My Articles', 'articles' => $myArticle]);

    //     }
        
    //     // untuk edit page articles ada di /view/dashboard/my_articles.php


    // }

    // myArticles pake pagination

    public function MyArticles($offset = 0) {
    $this->load->model('Article_Model');
    $this->load->library('pagination');

    $owner_id = $this->session->userdata('user_id');
    $user_role = $this->session->userdata('user_role');

    $per_page = 6; // jumlah artikel per halaman

    if ($user_role === 'admin') {
        // API ambil semua artikel
        $all_articles = api_get('api/articles?owner=all&limit='.$per_page.'&offset='.$offset);

        // total_rows bisa didapat dari API kalau ada, sementara pakai count()
        $total_rows = isset($all_articles['total']) ? $all_articles['total'] : count($all_articles['data']);

        // Konfigurasi pagination
        $config['base_url'] = site_url('dashboard/MyArticles');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 3;

        // Bootstrap 5 style
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $this->load->view('layouts/dashboard', [
            'content' => 'dashboard/admin/articles/index',
            'title' => 'Articles',
            'articles' => $all_articles['data'],
            'pagination' => $this->pagination->create_links()
        ]);

    } else if ($user_role === 'lawyer') {
        // Ambil artikel berdasarkan owner_id dengan limit + offset
        $myArticle = $this->Article_Model->get_by_owner_id($owner_id, $per_page, $offset);
        $total_rows = $this->Article_Model->count_by_owner_id($owner_id);

        // Konfigurasi pagination
        $config['base_url'] = site_url('dashboard/MyArticles');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '« Prev';
$config['next_link'] = 'Next »';

        $this->pagination->initialize($config);

        $this->load->view('layouts/dashboard', [
            'content' => 'dashboard/articles/my_articles',
            'title' => 'My Articles',
            'articles' => $myArticle,
            'pagination' => $this->pagination->create_links()
        ]);
    }
}


    public function chats(){
        $this->load->model('Chats_Model');
        $this->load->helper('api');

        $user_id   = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('user_role');

        // hanya lawyer yang bisa akses
        if (!$user_id || $user_role !== 'lawyer') {
            $this->session->set_flashdata('error', 'Hanya lawyer yang bisa mengakses roomchat.');
            redirect('dashboard');
            return;
        }

        // kirim request ke API
        $url = base_url('Api/Chat/my_chats');

    // CURL ke API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['lawyer_id' => $user_id]));

    $result = curl_exec($ch);

    if ($result === false) {
        $error = curl_error($ch);
        curl_close($ch);
        show_error("Curl Error: " . $error);
        return;
    }

    curl_close($ch);

    $response = json_decode($result, true);

        $data['chats'] = [];
        if ($response && isset($response['ok']) && $response['ok'] === true) {
            $data['chats'] = $response['data'];
        } else {
            $data['error'] = isset($response['message']) ? $response['message'] : 'Gagal mengambil data chat.';
        }

        $this->load->view('layouts/dashboard', ['content' => 'dashboard/chats', 'chats' => $data['chats']]);
    }

    // public function chats(){
    //     $this->load->model('Chats_Model');
    //     $this->load->helper('api');

    //     $user_id   = $this->session->userdata('user_id');
    //     $user_role = $this->session->userdata('user_role');

    //     // hanya lawyer yang bisa akses
    //     if (!$user_id || $user_role !== 'lawyer') {
    //         $this->session->set_flashdata('error', 'Hanya lawyer yang bisa mengakses roomchat.');
    //         redirect('dashboard');
    //         return;
    //     }

    //     // kirim request ke API
    //     $url = 'localhost/advokat/Api/Chat/my_chats';

    // // CURL ke API
    // $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //     'Content-Type: application/json',
    // ]);
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['lawyer_id' => $user_id]));

    // $result = curl_exec($ch);

    // if ($result === false) {
    //     $error = curl_error($ch);
    //     curl_close($ch);
    //     show_error("Curl Error: " . $error);
    //     return;
    // }

    // curl_close($ch);

    // $response = json_decode($result, true);

    //     $data['chats'] = [];
    //     if ($response && isset($response['ok']) && $response['ok'] === true) {
    //         $data['chats'] = $response['data'];
    //     } else {
    //         $data['error'] = isset($response['message']) ? $response['message'] : 'Gagal mengambil data chat.';
    //     }

    //     $this->load->view('layouts/dashboard', ['content' => 'dashboard/chats', 'chats' => $data['chats']]);
    // }

    public function create()
    {
        $this->load->view('dashboard/articles/create_article');
    }

    private function request($api_url, $post_data)
    {
        // Request ke API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, base_url($api_url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        $result = json_decode($response, true);


        return [$httpcode, $result];
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
                $coverUrl   = $uploadData['file_name'];
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


        $req = $this->request('/Api/Articles/create', $postData);

        // var_dump($req); exit;

        if (in_array($req[0], [200, 201])) {
            $this->session->set_flashdata('success', 'Artikel berhasil dibuat.');
            redirect('dashboard/articles');
        } else {
            $errorMsg = isset($req[1]['message']) ? $req[1]['message'] : 'Gagal membuat artikel';
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

public function get_by_slug($slug)
{
    $post_data = [
            'slug'     => $slug
    ];

    $req = $this->request('Api/Articles/show_by_slug', $post_data);


    if($req[0] == 200 || !empty($req[1]['message']))
        $this->load->view('dashboard/articles/edit_article.php', ['article' => $req[1]['data']]);
    else
        $this->session->set_flashdata('error', 'Gagal menghapus artikel.');

}   

public function update_article($id)
{
    $this->load->library('upload');
    $this->load->model('Article_Model');

    // 🔹 Ambil data artikel lama dari DB
    $article = $this->Article_Model->get_by_id($id);

    // Ambil cover lama
    $coverOld = $article['cover_url'];
    $coverNew = $coverOld;

    // Jika ada file baru
    if (!empty($_FILES['cover']['name'])) {
        $config['upload_path']   = './uploads/articles/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name']     = time() . '_' . $_FILES['cover']['name'];

        $this->upload->initialize($config);

        if ($this->upload->do_upload('cover')) {
            $uploadData = $this->upload->data();
            $coverNew   = $uploadData['file_name'];

            $oldPath = FCPATH . 'uploads/articles/' . $article['cover_url'];
            if (is_file($oldPath)) {
                unlink($oldPath);
            }

        } else {
            // Kalau gagal upload
            $error = $this->upload->display_errors();
            show_error("Upload gagal: $error");
        }
    }
    

    // Data untuk API
    $payload = [
        'title'       => $this->input->post('title'),
        'excerpt'     => $this->input->post('excerpt'),
        'body'        => $this->input->post('body'),
        'cover_url'   => $coverNew ,
    ];


    // 🔥 Panggil API pakai CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, base_url("Api/Articles/update/$id"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    
    if ($result['ok']) {
        redirect('dashboard/articles');
    } else {
        show_error("Gagal update: " . $result['message']);
    }
}



public function booking(){
  $role =  $this->session->userdata('user_role');



  if($role ==='admin'){
    $this->load->model('Booking_Model','booking');
    $allBooking = $this->booking->get_all();
    $this->load->view('layouts/dashboard', ['content' => 'dashboard/admin/booking/index','title' => 'Booking', 'bookings' => $allBooking]);
  }
  else{
    // $this->session->set_flashdata('error', 'Hanya admin yang bisa mengakses booking.');
    redirect(base_url('dashboard'));
    return;
  }


    

    

}








}
