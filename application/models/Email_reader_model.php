<?php 

class Email_Reader_model extends CI_model {

    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }
    public function getAll()
    {
        $query = $this->db->get('email_readers');
        return $query->result_array();
    }

    // API
    
    public function getAllEmailReader($page, $limit, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $this->db->select('*, email_readers.id AS id_email');
            $this->db->from('email_readers');
            $this->db->where('email_readers.id_user', $id_user);
            $this->db->order_by('email_readers.id','ASC');
            $this->db->join('transactions', 'transactions.id = email_readers.id_transaction');
            $this->db->join('users', 'users.id = email_readers.id_user');
            
            if ($limit != null && $page != null) {
                if($page == 1) {
                    $offset = 0;
                } else {
                    $offset = ($page-1) * $limit;
                }
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get()->result();
            return $query;
        }
    }

    public function getReferenceEmailReader($page, $limit, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $this->db->select('*, email_readers.id AS id_email');
            $this->db->from('email_readers');
            $this->db->where('email_readers.id_user', $id_user);
            $this->db->group_by('email_readers.email');
            $this->db->order_by('email_readers.id','ASC');
            $this->db->join('transactions', 'transactions.id = email_readers.id_transaction');
            $this->db->join('users', 'users.id = email_readers.id_user');
            
            if ($limit != null && $page != null) {
                if($page == 1) {
                    $offset = 0;
                } else {
                    $offset = ($page-1) * $limit;
                }
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get()->result();
            return $query;
        }
    }
    
    public function addEmailReaderAPI($id_user, $id_transaction)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_user" => $id_user,
            "email" => $this->input->post('email', true),
            "id_transaction" => $id_transaction,
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('email_readers', $data);
        return $data;
    }

    // Dashboard
    public function addEmailReader($id_transaction)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_user" => $this->session->userdata('id'),
            "email" => $this->input->post('email', true),
            "id_transaction" => $id_transaction,
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('email_readers', $data);
    }

    // public function create()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
    //     $data = [
    //         "email" => $this->input->post('email', true),
    //         "created_at" => $date_time,
    //         "updated_at" => $date_time,
    //     ];
    //     $this->db->insert('email_readers', $data);
    // }

    // public function update($id)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
    //     $data = [
    //         "email" => $this->input->post('email', true),
    //         "updated_at" => $date_time,
    //     ];
    //     $this->db->where('id', $id);
    //     $this->db->update('email_readers', $data);
    // }
    

    // public function delete($id)
    // {
    //     $this->db->where('id', $id);
    //     $this->db->delete('email_readers'); 
    // }

    public function getById($id)
    {
        $query = $this->db->get_where('email_readers', ['id' => $id]);
        return $query->row_array();
    }
    public function getByIdTransaction($id_transaction)
    {
        $query = $this->db->get_where('email_readers', ['id_transaction' => $id_transaction]);
        return $query->row_array();
    }

    public function sendEmail($email, $id_book)
    {
        // $verified_book = $this->Verified_book_model->getById($id_verified_book);
        // echo "<pre>";
        // print_r($verified_book);
        // echo "</pre>";
        // exit();
        
        $verified_book = $this->Verified_book_model->getByEmailIdBook($email, $id_book);
        $book = $this->Purchase_model->getByIdUserIdBookIdStatus($verified_book['id_user'], $verified_book['id_book'], 3);
        $fullname = $verified_book['fullname'];
        $title = $verified_book['title'];
        $isbn = $verified_book['isbn'];
        $publisher = $verified_book['publisher'];
        $author = $verified_book['author'];
        $publication_year = $verified_book['publication_year'];
        $fullname = $verified_book['fullname'];
        $serial_number = $verified_book['serial_number'];
        $no_order = $book['no_order'];

        $message = "
        <html>
        <head>
            <title>your title</title>
        </head>
        <body>
            <p>Hello $fullname,</p>
            <p>Terimakasih sudah membeli buku <strong>$title</strong> di <strong>Bidlit</strong>. </p>
            <p>Berikut detail pembelian buku anda dan serial number yang dapat digunakan untuk mengakses buku yang anda beli :</p>
            <tr>
                <td>Invoice</td>
                <td>:</td>
                <td>$no_order</td>
            </tr>
            <tr>
                <td>ISBN</td>
                <td>:</td>
                <td>$isbn</td>
            </tr>
            <tr>
                <td>Judul</td>
                <td>:</td>
                <td>$title</td>
            </tr>
            <tr>
                <td>Penulis</td>
                <td>:</td>
                <td>$author</td>
            </tr>
            <tr>
                <td>Penerbit</td>
                <td>:</td>
                <td>$publisher</td>
            </tr>
            <tr>
                <td>Tahun Terbit</td>
                <td>:</td>
                <td>$publication_year</td>
            </tr>
            <tr>
                <td>Nomor Seri</td>
                <td>:</td>
                <td>$serial_number</td>
            </tr>
            
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

        $this->email->subject('Serial Number Pembelian Buku '.$verified_book['title']);
        $this->email->message($message);
        $this->email->set_mailtype("html");

        if ($this->email->send()) {
            return 'The email has successfully been send.';
        } else {
            return show_error($this->email->print_debugger());
        }
    }
}

?>