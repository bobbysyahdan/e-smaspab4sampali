<?php 

class User_model extends CI_model {
    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }
    // API
    public function registerUser()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        
        $data = [
            "username" => htmlspecialchars($this->input->post('username', true)),
            "email" => htmlspecialchars($this->input->post('email', true)),
            "password" => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            "role" => 2,
            "is_active" => 1,
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('users', $data);
        $data = $this->User_model->getByEmail($data['email']);
        return $data;
    }

    public function login($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id" => $id,
            "is_login" => 1,
            "device_model" => $this->input->post('device_model', true),
            "device_token" => $this->input->post('device_token', true),
            "device_version" => $this->input->post('device_version', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return $data;
    }

    public function logout($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "is_login" => 0,
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    public function checkUserLogin($id_user)
    {
        $this->db->where('id', $id_user);
        $this->db->where('is_login', 1);
        $query = $this->db->get('users')->result();
        return $query;
    }

    // Dashboard
    public function getAll()
    {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function getAllUser()
    {
        $query = $this->db->get_where('users', ['role' => 2]);
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        
        $data = [
            "username" => htmlspecialchars($this->input->post('username', true)),
            "email" => htmlspecialchars($this->input->post('email', true)),
            "password" => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            "role" => $this->input->post('role', true),
            "is_active" => $this->input->post('is_active', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('users', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "username" => htmlspecialchars($this->input->post('username', true)),
            "email" => htmlspecialchars($this->input->post('email', true)),
            // "password" => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            "role" => $this->input->post('role', true),
            "is_active" => $this->input->post('is_active', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    public function resetPassword($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "password" => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    public function getById($id)
    {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row_array();
    }

    public function getByEmail($email)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row_array();
    }

    public function getByRememberToken($remember_token)
    {
        $query = $this->db->get_where('users', ['remember_token' => $remember_token]);
        return $query->row_array();
    }

    public function getRoles()
    {
        $roles = [
            [
                "id" => 1,
                "name" => "admin",
            ],
            [
                "id" => 2,
                "name" => "user",
            ],
        ];

        return $roles;
    }

    public function getStatus()
    {
        $status = [
            [
                "id" => 1,
                "name" => "active",
            ],
            [
                "id" => 0,
                "name" => "non-active",
            ],
        ];
        
        return $status;   
    }

    public function lastLogin($id_user)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            'lastlogin' => $date_time,
        ];
        $this->db->where('id', $id_user);
        $this->db->update('users', $data);
    }

    public function deleteRememberToken($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            'remember_token' => NULL,
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sendEmailResetPassword($email)
    {
        $user = $this->User_model->getByEmail($email);
        if($user) {
            $email = $user['email'];
            $remember_token = $this->User_model->generateRandomString(25);
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/akun/resetPassword/'.$remember_token;
            date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
            $data = [
                'remember_token' => $remember_token,
                "updated_at" => $date_time,
            ];
            $this->db->where('id', $user['id']);
            $this->db->update('users', $data);

            $message = "
            <html>
            <head>
                <title>Reset Password</title>
            </head>
            <body>
                <p>Hello $email,</p>
                <p>Berikut link untuk reset password akun anda : $url</p>
                
            </body>
            </html>";
            $config = array();
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'mail.iopri.org';
            $config['smtp_user'] = 'publikasi@iopri.org';
            $config['smtp_pass'] = 'IOPRI2021#';
            $config['smtp_port'] = 587;
            $this->email->initialize($config);

            $this->email->set_newline("\r\n");
            $this->email->from('publikasi@iopri.org', ' Publikasi PPKS');
            $this->email->to($email);
            // $this->email->cc('another@another-example.com');
            // $this->email->bcc('them@their-example.com');

            $this->email->subject('Reset Password '.$user['email']);
            $this->email->message($message);
            $this->email->set_mailtype("html");

            if ($this->email->send()) {
                return 'The email has successfully been send.';
            } else {
                return show_error($this->email->print_debugger());
            }
        } else {
            return 'No email were found';
        }
    }

    public function getNotificationAdmin()
    {
        $this->db->select('*,
        DATE_FORMAT(users.updated_at, "%d-%m-%Y %H:%i:%s") AS waktu');
        $this->db->from('users');
        $this->db->where('users.dibaca_admin', 0);
        $this->db->order_by('users.updated_at','DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateDibaca()
    {
        $users = $this->User_model->getAll();
        foreach($users as $user) {
            date_default_timezone_set('Asia/Jakarta');
            $date_time = date('y-m-d H:i:s');
            $data = [
                "dibaca_admin" => 1,
                "updated_at" => $date_time,
            ];
            $this->db->where('id', $user['id']);
            $this->db->update('users', $data);
        }
    }
}

?>