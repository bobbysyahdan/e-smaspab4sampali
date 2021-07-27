<?php

class Midtrans_model extends CI_model {
    
    private $_midtrans;
    private $_auth;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('User_model');
        $this->load->model('User_identity_model');

        $this->_midtrans = [
            'app' => 'https://app.sandbox.midtrans.com',
            'api' => 'https://api.sandbox.midtrans.com/v2',
            // 'auth' => 'Basic U0ItTWlkLXNlcnZlci1CcU4xaHN5ajVTRlFlcHRyVF90ZHVOWjU6'
        ];
        $this->_auth = 'Basic U0ItTWlkLXNlcnZlci1zeTB2SDh1RTNITTJEQUJEaVZybFAyRmg6';
    }

    public function paymentMidtrans($id_transaction)
    {
        $total_price = 0;
        $transaction = $this->Transaction_model->getById($id_transaction);
        if($transaction['book_type'] == 1) {
            $total_price = $transaction['total_price'];
        } else {
            $shipping_book = $this->Shipping_book_model->getByIdTransaction($id_transaction);
            $total_price = $transaction['total_price'] + $shipping_book['shipping_price'];
        }
        $id_user = $this->session->userdata('id');
        $headers = array(
            "Accept: application/json",
            "Authorization:  $this->_auth",
            "Content-Type: application/json",
        );
        $body = [
            'transaction_details' =>  [
                'order_id' =>  $transaction['no_order'],
                'gross_amount' =>  $total_price,
            ], 
            'credit_card' => [
                'secure'  =>  true
            ],
            'customer_details' =>  [
                'first_name' =>  $this->User_model->getById($id_user)['username'],
                'last_name' =>  '',
                'email' =>  $this->User_model->getById($id_user)['email'],
                'phone' => '',
            ],
        ];
        $body = json_encode($body);
        // $response = $client->request('POST', $midtrans['app'].'/snap/v1/midtrans_notificantions', $headers, $body)->send();
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->_midtrans['app'].'/snap/v1/transactions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => $headers,
        ));
       
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
        }
        return $response;
    }

    public function notificationMidtrans($no_order)
    {
        $id_user = $this->session->userdata('id');
        $headers = array(
            "Accept: application/json",
            "Authorization:  $this->_auth",
            "Content-Type: application/json",
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->_midtrans['api'].'/'.$no_order.'/status',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        // CURLOPT_POSTFIELDS => $body ,
        CURLOPT_HTTPHEADER => $headers,
        ));
       
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
        }
        return $response;
    }

    public function cancelMidtrans($no_order)
    {
        $id_user = $this->session->userdata('id');
        $headers = array(
            "Accept: application/json",
            "Authorization:  $this->_auth",
            "Content-Type: application/json",
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->_midtrans['api'].'/'.$no_order.'/cancel' ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        // CURLOPT_POSTFIELDS => $body ,
        CURLOPT_HTTPHEADER => $headers,
        ));
       
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
        }
        return $response;
    }


    public function getAll()
    {
        $query = $this->db->get('midtrans_notifications');
        return $query->result_array();
    }

    public function getById($id)
    {
        $query = $this->db->get_where('midtrans_notifications', ['id' => $id]);
        return $query->row_array();
    }

    public function getByOrderId($order_id)
    {
        $query = $this->db->get_where('midtrans_notifications', ['order_id' => $order_id]);
        return $query->row_array();
    }
}

?>