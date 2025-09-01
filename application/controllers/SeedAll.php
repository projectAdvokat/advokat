<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeedAll extends CI_Controller {

    public function run()
    {
        $this->load->database();


        $users = [
            [
                'id'=>1,
                'name'=>'Admin',
                'email'=>'admin@example.com',
                'phone'=>'081234567890',
                'role'=>'admin',
                'password_hash'=>password_hash('admin123', PASSWORD_DEFAULT),
                'ref_code'=>'ADM12ABCDE',
                'referrer_id'=>NULL,
                'status'=>'active'
            ],
            [
                'id'=>2,
                'name'=>'Lawyer One',
                'email'=>'lawyer1@example.com',
                'phone'=>'081234567891',
                'role'=>'lawyer',
                'password_hash'=>password_hash('lawyer123', PASSWORD_DEFAULT),
                'ref_code'=>'LAW12ABCDE',
                'referrer_id'=>1,
                'status'=>'active'
            ],
            [
                'id'=>3,
                'name'=>'Client One',
                'email'=>'client1@example.com',
                'phone'=>'081234567892',
                'role'=>'client',
                'password_hash'=>password_hash('client123', PASSWORD_DEFAULT),
                'ref_code'=>'CLI12ABCDE',
                'referrer_id'=>2,
                'status'=>'active'
            ]
        ];
        foreach($users as $u){
            if(!$this->db->get_where('users',['id'=>$u['id']])->row()){
                $this->db->insert('users',$u);
            }
        }

        $lawyers = [
            [
                'user_id'=>2,
                'years_experience'=>5,
                'specialties'=>'Contract Law, Criminal Law',
                'price_30m'=>150.00,
                'bio'=>'Berpengalaman menangani kasus kontrak dan pidana',
                'is_online'=>1,
                'verified_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($lawyers as $l){
            if(!$this->db->get_where('lawyers',['user_id'=>$l['user_id']])->row()){
                $this->db->insert('lawyers',$l);
            }
        }


        $articles = [
            [
                'id'=>1,
                'owner_id'=>NULL,
                'title'=>'Panduan Konsultasi Hukum',
                'slug'=>'panduan-konsultasi-hukum',
                'cover_url'=>'',
                'excerpt'=>'Tips konsultasi hukum efektif',
                'body'=>'Isi artikel lengkap...',
                'published_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($articles as $a){
            if(!$this->db->get_where('articles',['id'=>$a['id']])->row()){
                $this->db->insert('articles',$a);
            }
        }

        if(!$this->db->get_where('referral_config',['id'=>1])->row()){
            $this->db->insert('referral_config', [
                'id'=>1,
                'platform_fee_pct'=>30.00,
                'company_pct_of_fee'=>50.00,
                'l1_pct_of_pool'=>50.00,
                'l2_pct_of_pool'=>33.333,
                'l3_pct_of_pool'=>16.667
            ]);
        }


        $wallets = [
            ['user_id'=>1,'balance'=>100000.00],
            ['user_id'=>2,'balance'=>50000.00],
            ['user_id'=>3,'balance'=>20000.00]
        ];
        foreach($wallets as $w){
            if(!$this->db->get_where('wallets',['user_id'=>$w['user_id']])->row()){
                $this->db->insert('wallets',$w);
            }
        }


        $bookings = [
            [
                'id'=>1,
                'client_id'=>3,
                'lawyer_id'=>2,
                'duration_minutes'=>30,
                'price_snapshot'=>150.00,
                'status'=>'pending',
                'pg_ref'=>NULL,
                'paid_at'=>NULL,
                'created_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($bookings as $b){
            if(!$this->db->get_where('bookings',['id'=>$b['id']])->row()){
                $this->db->insert('bookings',$b);
            }
        }


        $payments = [
            [
                'id'=>1,
                'booking_id'=>1,
                'gateway'=>'midtrans',
                'pg_tx_id'=>'TX123456',
                'amount'=>150.00,
                'status'=>'created',
                'raw_json'=>'{}',
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($payments as $p){
            if(!$this->db->get_where('payments',['id'=>$p['id']])->row()){
                $this->db->insert('payments',$p);
            }
        }


        $chats = [
            [
                'id'=>1,
                'booking_id'=>1,
                'client_id'=>3,
                'lawyer_id'=>2,
                'opened_at'=>date('Y-m-d H:i:s'),
                'start_time'=>NULL,
                'end_time'=>NULL,
                'closed_reason'=>NULL
            ],
            [
                'id'=>1,
                'booking_id'=>1,
                'client_id'=>3,
                'lawyer_id'=>2,
                'opened_at'=>date('Y-m-d H:i:s'),
                'start_time'=>date('Y-m-d H:i:s'),
                'end_time'=>date('Y-m-d H:i:s'),
                'closed_reason'=>'manual'
            ]
        ];
        foreach($chats as $c){
            if(!$this->db->get_where('chats',['id'=>$c['id']])->row()){
                $this->db->insert('chats',$c);
            }
        }

        $messages = [
            [
                'id'=>1,
                'chat_id'=>1,
                'sender_id'=>3,
                'text'=>'Halo, saya ingin konsultasi.',
                'attachment_url'=>NULL,
                'created_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($messages as $m){
            if(!$this->db->get_where('messages',['id'=>$m['id']])->row()){
                $this->db->insert('messages',$m);
            }
        }

        $ledger = [
            [
                'id'=>1,
                'user_id'=>1,
                'ref_type'=>'adjustment',
                'ref_id'=>0,
                'amount'=>100000,
                'note'=>'Initial balance',
                'created_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($ledger as $l){
            if(!$this->db->get_where('wallet_ledger',['id'=>$l['id']])->row()){
                $this->db->insert('wallet_ledger',$l);
            }
        }

        $commissions = [
            [
                'id'=>1,
                'booking_id'=>1,
                'gross_price'=>150,
                'platform_fee'=>30,
                'company_amount'=>50,
                'l1_user_id'=>1,
                'l1_amount'=>50,
                'l2_user_id'=>NULL,
                'l2_amount'=>0,
                'l3_user_id'=>NULL,
                'l3_amount'=>0,
                'created_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($commissions as $c){
            if(!$this->db->get_where('commissions',['id'=>$c['id']])->row()){
                $this->db->insert('commissions',$c);
            }
        }


        $actions = [
            [
                'id'=>1,
                'admin_id'=>1,
                'target_type'=>'user',
                'target_id'=>3,
                'action'=>'created',
                'reason'=>'Initial setup',
                'created_at'=>date('Y-m-d H:i:s')
            ]
        ];
        foreach($actions as $a){
            if(!$this->db->get_where('admin_actions',['id'=>$a['id']])->row()){
                $this->db->insert('admin_actions',$a);
            }
        }

        echo "Semua seed berhasil dijalankan!";
    }
}
