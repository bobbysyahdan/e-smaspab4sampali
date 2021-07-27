<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookIdentity extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Book_identity_model');
        $this->load->model('Book_stock_model');
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

	public function index()
	{   
        $data['title'] = "Book Identity";
        $data['model'] = $this->Book_identity_model;
        $data['book_identities'] = $this->Book_identity_model->getAll();
        // $book_identities = $this->Book_identity_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        // $this->load->view('book_identity/index', [
        //     'book_identities' => $book_identities,
        // ]);
        $this->load->view('book_identity/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['book_identity'] = $this->Book_identity_model->getByIdBookIdentity($id);
        $data['title'] = 'Detail Data';
        if(isset($data['book_identity'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_identity/show', $data);
            $this->load->view('layouts/footer');
        }
    }

    public function create()
	{   
        $data['title'] = "Create New Book Identity";
        $data['categories'] = $this->ref_book_category_model->getAll();
        $data['package_editions'] = $this->ref_package_edition_model->getAll();
        $this->form_validation->set_rules('isbn', 'ISBN', 'required|is_unique[book_identities.isbn]|max_length[30]');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('author', 'Author', 'required');
        $this->form_validation->set_rules('publisher', 'Publisher', 'required');
        $this->form_validation->set_rules('publication_year', 'Publication Year', 'required');
        $this->form_validation->set_rules('pages', 'Pages', 'required|numeric');
        $this->form_validation->set_rules('id_package_edition', 'Package Edition', 'required');
        $this->form_validation->set_rules('id_category', 'Category', 'required');
        
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_identity/create', $data);
            $this->load->view('layouts/footer');
        } else {
            if (empty($_FILES['file_uploaded']['name']))
            {
                $this->session->set_flashdata('failed', 'Upload Book File (PDF) is required.');
                redirect('/bookIdentity/create/'.$id_book_identity);
            } else {
                if($_FILES['file_uploaded']['type'] != 'application/pdf') {
                    $this->session->set_flashdata('failed', 'Upload Book File must PDF file.');
                    redirect('/bookIdentity/create/'.$id_book_identity);
                } else {
                    $this->Book_identity_model->create();
                    $this->session->set_flashdata('success', 'Data has been saved successfully.');
                    redirect('/bookIdentity');
                }
            }
            
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Book Identity";
        $data['categories'] = $this->ref_book_category_model->getAll();
        $data['package_editions'] = $this->ref_package_edition_model->getAll();
        $this->form_validation->set_rules('isbn', 'ISBN', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('author', 'Author', 'required');
        $this->form_validation->set_rules('publisher', 'Publisher', 'required');
        $this->form_validation->set_rules('publication_year', 'Publication Year', 'required');
        $this->form_validation->set_rules('pages', 'Pages', 'required|numeric');
        $this->form_validation->set_rules('id_package_edition', 'Package Edition', 'required');
        $this->form_validation->set_rules('id_category', 'Category', 'required');

        if($this->form_validation->run() == FALSE) {
            $data['book_identity'] = $this->Book_identity_model->getByIdBookIdentity($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_identity/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Book_identity_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/bookIdentity');
        }
    }

    public function delete($id)
    {
        $this->Book_identity_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/bookIdentity');  
    }

    public function test()
    {
        $pdf_file = "./upload/content_book/test.pdf";
        $save_to = './upload/content_book/test.jpg';
        $imagick = new Imagick();
        $imagick->readImage($pdf_file);
        $x = $imagick->getNumberImages();

        echo "<pre>";
        print_r($x);
        echo "</pre>";
        exit();
        // $imagick->writeImages($save_to, false);
        // $data['title'] = "Create New Book Identity";
        // if($this->form_validation->run() == FALSE) {
        //     $this->load->view('layouts/header', $data);
        //     $this->load->view('layouts/menu');
        //     $this->load->view('book_identity/test', $data);
        //     $this->load->view('layouts/footer');
        // } else {
        //     $file_uploaded = $this->uploadFile();
        //     $pdf_file = "test.pdf";
        //     $save_to = 'demo.jpg';
        //     $imagick = new Imagick();
        //     $imagick->readImage($pdf_file);
        //     $imagick->writeImages('converted.jpg', false);
        //     $this->session->set_flashdata('success', 'Data has been saved successfully.');
        //     redirect('/bookIdentity');
        // }   
    }

    public function bookContentImages($id_book_identity) {
        $book_identity = $this->Book_identity_model->getByIdBookIdentity($id_book_identity);
        $data['id_book_identitiy'] = $id_book_identity;
        $data['title'] = 'Content Book Images - '.$book_identity['title'].' ('.$book_identity['isbn'].')';
        $data['model'] = $this->Book_content_images_model;
        $data['book_content_images'] = $this->Book_content_images_model->getAllByBookIdentity($id_book_identity);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('book_identity/book_content_images', $data);
        $this->load->view('layouts/footer');
    }
}
