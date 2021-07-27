<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookContentImages extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Book_identity_model');
        $this->load->model('Book_content_images_model');
        $this->load->model('ref_book_category_model');
        $this->load->model('ref_package_edition_model');
        $this->load->model('Purchase_model');
        $this->load->model('Transaction_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

    public function show($id)
    {
        $data['book_identity'] = $this->Book_identity_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['book_identity'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_identity/show', $data);
            $this->load->view('layouts/footer');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Book Identity";
        $data['categories'] = $this->ref_book_category_model->getAll();
        $data['package_editions'] = $this->ref_package_edition_model->getAll();
        // $this->form_validation->set_rules('isbn', 'ISBN', 'required|is_unique[book_identities.isbn]');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('author', 'Author', 'required');
        $this->form_validation->set_rules('publisher', 'Publisher', 'required');
        $this->form_validation->set_rules('publication_year', 'Publication Year', 'required');
        $this->form_validation->set_rules('pages', 'Pages', 'required|numeric');
        $this->form_validation->set_rules('id_package_edition', 'Package Edition', 'required');
        $this->form_validation->set_rules('id_category', 'Category', 'required');

        if($this->form_validation->run() == FALSE) {
            $data['book_identity'] = $this->Book_identity_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_identity/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Book_identity_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/bookContentImages/book'.$id_book_identity);
        }
    }

    public function book($id_book_identity) {
        $book_identity = $this->Book_identity_model->getById($id_book_identity);
        $data['id_book_identitiy'] = $id_book_identity;
        $data['title'] = 'Content Book Images - '.$book_identity['title'].' ('.$book_identity['isbn'].')';
        $data['model'] = $this->Book_content_images_model;
        $data['book_content_images'] = $this->Book_content_images_model->getAllByBookIdentity($id_book_identity);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('book_content_images/index', $data);
        $this->load->view('layouts/footer');
    }

    public function create($id_book_identity) {
        $data['id_book_identity'] = $id_book_identity;
        $book_identity = $this->Book_identity_model->getById($id_book_identity);
        $data['title_book_identity'] = $book_identity['title'].' (ISBN: '.$book_identity['isbn'].')';
        $data['title'] = 'Create Content Book Images';
        $this->form_validation->set_rules('book_identity', 'Book Identity', 'required');
         

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_content_images/create', $data);
            $this->load->view('layouts/footer');
        } else {
            
            if (empty($_FILES['file_pdf_uploaded']['name']))
            {
                $this->session->set_flashdata('failed', 'Upload File PDF is required.');
                redirect('/bookContentImages/create/'.$id_book_identity);
            } else {
                if($_FILES['file_pdf_uploaded']['type'] != 'application/pdf') {
                    $this->session->set_flashdata('failed', 'Upload File must PDF file.');
                    redirect('/bookContentImages/create/'.$id_book_identity);
                } else {
                    $this->Book_content_images_model->create($id_book_identity);
                    $this->session->set_flashdata('success', 'Data has been updated successfully.');
                    redirect('/bookContentImages/book/'.$id_book_identity);
                }
            }
        }
    }


    public function delete($id)
    {
        $id_book_identity = $this->Book_content_images_model->getById($id)['id_book_identity'];
        $book_identity = $this->Book_identity_model->getById($id_book_identity);
        $this->Book_content_images_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/bookContentImages/book'.$id_book_identity);  
    }

    public function test()
    {
        $pdf_file = "./upload/content_book/test.pdf";
        $save_to = './upload/content_book/test.jpg';
        $imagick = new Imagick();
        $imagick->readImage($pdf_file);
        $imagick->writeImages($save_to, false);
    }
    

    public function uploadFile()
    {
        $config2['upload_path']          = './upload/book/';
        $config2['allowed_types']        = 'pdf|doc|docx';
        $config2['file_name']            = 'file'.time();
        $config2['overwrite']			= true;
        // $config['max_size']             = 1024; // 1MB
        $config2['max_size']             = 50000; 
        // $this->load->library('upload', $config2);
        $this->upload->initialize($config2);
        
        if ($this->upload->do_upload('file_uploaded')) {
            return $this->upload->data("file_name");
        } else {
            return "default.pdf";
        }
    }
}
