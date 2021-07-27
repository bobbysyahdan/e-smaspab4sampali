<?php 

class Book_identity_model extends CI_model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
    }
    // API
    public function getAllAvailable($page, $limit)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
        $this->db->select("*, book_identities.id AS id, concat('$url', book_identities.cover_image) AS url_cover_image, concat('$url', book_identities.file_uploaded) AS url_file_uploaded");
        $this->db->from('book_identities');
        $this->db->order_by('book_identities.id','ASC');
        $this->db->where('book_stocks.is_available', 1);
        $this->db->join('ref_book_categories', 'ref_book_categories.id = book_identities.id_category');
        $this->db->join('book_stocks', 'book_stocks.id_book = book_identities.id');
        
        if ($limit != null && $page != null) {
            if($page == 1) {
                $offset = 0;
            } else {
                $offset = ($page-1) * $limit;
            }

            // if($limit == 1) {
            //     $offset = $page - 1;
            // }

            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get()->result();
        // $query['url_cover_image'] = 'https://bidlit.iopri.org/upload/book/';
        return $query;
    }

    public function getBySearchTitle($page, $limit, $keyword)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
        $this->db->select("*, book_identities.id AS id, concat('$url', book_identities.cover_image) AS url_cover_image, concat('$url', book_identities.file_uploaded) AS url_file_uploaded");
        $this->db->from('book_identities');
        $this->db->order_by('book_identities.id','ASC');
        $this->db->like('book_identities.title', $keyword);
        $this->db->where('book_stocks.is_available', 1);
        $this->db->join('book_stocks', 'book_stocks.id_book = book_identities.id');
        $this->db->join('ref_book_categories', 'ref_book_categories.id = book_identities.id_category');

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

    public function getByCategory($page, $limit, $id_category)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
        $this->db->select("*, book_identities.id AS id, concat('$url', book_identities.cover_image) AS url_cover_image, concat('$url', book_identities.file_uploaded) AS url_file_uploaded");
        $this->db->from('book_identities');
        $this->db->order_by('book_identities.id','ASC');
        $this->db->where('book_stocks.is_available', 1);
        $this->db->where('ref_book_categories.id', $id_category);
        $this->db->join('book_stocks', 'book_stocks.id_book = book_identities.id');
        $this->db->join('ref_book_categories', 'ref_book_categories.id = book_identities.id_category');

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

    public function getBookPerCategory($page, $limit)
    {
        $ref_categories = $this->Ref_book_category_model->getAll();
        $books = [];
        $categories = [];
        $arr_books = [];
        $arr_categories = [];
        $count = 0;

        if(count($ref_categories) > 0) {
            foreach($ref_categories as $category) {
                $get_books = $this->Book_identity_model->getByCategory($page,$limit,$category['id']);
                if(count($get_books) > 0) {
                    foreach($get_books as $book) {
                        array_push($books, $book);
                    }
                }

                $count = 0;
                if(count($books) > 0) {
                    $arr_books = [];
                    
                    foreach($books as $book) {    
                                          
                        if($book->id_category == $category['id']) {
                            array_push($arr_books, $book);
                        }
                    }
                    $arr_categories['id_category'] = $category['id'];
                    $arr_categories['category'] = $category['category'];
                    $arr_categories['books'] = $arr_books;

                    if($count < 1) {
                        $count += 1;  
                        if($arr_categories['books'] != []){
                            array_push($categories, $arr_categories);
                        }
                    }
                }
            }
        }

        return $categories;
    }

    // Dashboard
    public function getAll()
    {
        $this->db->order_by('book_identities.created_at', 'DESC');
        $query = $this->db->get('book_identities');
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $cover_image = $this->uploadCoverImage();
        $file_uploaded = $this->uploadFile();
        $data = [
            "isbn" => $this->input->post('isbn', true),
            "title" => $this->input->post('title', true),
            "author" => $this->input->post('author', true),
            "publisher" => $this->input->post('publisher', true),
            "publication_year" => $this->input->post('publication_year', true),
            "pages" => $this->input->post('pages', true),
            "id_category" => $this->input->post('id_category', true),
            "id_package_edition" => $this->input->post('id_package_edition', true),
            "description" => $this->input->post('description', true),
            "amount_subscribe" => 0,
            "cover_image" => $cover_image,
            "file_uploaded" => $file_uploaded,
            "id_admin" => $this->session->userdata('id'),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('book_identities', $data);
        $id_book_identity = $this->db->insert_id();
        $isbn = $this->input->post('isbn', true);

        if($file_uploaded != 'default.pdf') {
            $file_name = 'content_book_images'.'_'.$isbn.'_'.time();
            $pdf_file = "./upload/book/$file_uploaded";
            $save_to = "./upload/content_book/$file_name.jpg";
            $imagick = new Imagick();
            $imagick->setResolution(300,300);
            $imagick->readImage($pdf_file);
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompression(imagick::COMPRESSION_JPEG); 
            $imagick->setImageCompressionQuality(100);
            $number_images = $imagick->getNumberImages();
            $imagick->writeImages($save_to, false);
            $imagick->clear();
            $imagick->destroy();
            for($i=0; $i < $number_images; $i++) {
                $data_book_content_images = [
                    "id_book_identity" => $id_book_identity,
                    "file_image" => $file_name.'-'.$i.'.jpg',
                    "created_at" => $date_time,
                    "updated_at" => $date_time,
                ];
                $this->db->insert('book_content_images', $data_book_content_images);
            }

            $book_content_images = $this->Book_content_images_model->getAllByBookIdentity($id_book_identity);
            $content = "";
            foreach($book_content_images as $book_content_image) {
                $file_book_content_image = $book_content_image['file_image'];
                $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/content_book';
                $content .= "<p><img src='$url/$file_book_content_image' alt='' /></p>";
            }

            $data_content = [
                'content' => $content,
            ];

            $this->db->where('id', $id_book_identity);
            $this->db->update('book_identities', $data_content);
        }
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $upload_file = $this->uploadFile();
        if($upload_file == 'default.pdf') {
            $file = $this->input->post('old_file', true);
        } else {
            // $book_stocks = $this->book_stock_model->getByBookIdentity($id);
            // if(count($book_stocks) > 0) {
            //     foreach($book_stocks as $value) {
            //         $this->db->where('id', $value['id']);
            //         $this->db->delete('book_stocks'); 
            //     }
            // }

            // $book_stocks = $this->book_content_images_model->getByBookIdentity($id);
            // if(count($book_stocks) > 0) {
            //     foreach($book_stocks as $value) {
            //         $this->db->where('id', $value['id']);
            //         $this->db->delete('book_stocks'); 
            //     }
            // }
            $this->deleteFile($id);
            $file = $upload_file;
            $book_content_images = $this->Book_content_images_model->getAllByBookIdentity($id);
            if(count($book_content_images) > 0) {
                $this->deleteBookContentImages($id);
                foreach($book_content_images as $value) {
                    $this->db->where('id', $value['id']);
                    $this->db->delete('book_content_images'); 
                }
            }
            $isbn = $this->input->post('isbn', true);
            $file_name = 'content_book_images'.'_'.$isbn.'_'.time();
            $pdf_file = "./upload/book/$upload_file";
            $save_to = "./upload/content_book/$file_name.jpg";
            $imagick = new Imagick();
            $imagick->setResolution(300,300);
            $imagick->readImage($pdf_file);
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompression(imagick::COMPRESSION_JPEG); 
            $imagick->setImageCompressionQuality(100);
            $number_images = $imagick->getNumberImages();
            $imagick->writeImages($save_to, false);
            $imagick->clear();
            $imagick->destroy();
            for($i=0; $i < $number_images; $i++) {
                $data_book_content_images = [
                    "id_book_identity" => $id,
                    "file_image" => $file_name.'-'.$i.'.jpg',
                    "created_at" => $date_time,
                    "updated_at" => $date_time,
                ];
                $this->db->insert('book_content_images', $data_book_content_images);
            }

            $book_content_images = $this->Book_content_images_model->getAllByBookIdentity($id);
            $content = "";
            foreach($book_content_images as $book_content_image) {
                $file_book_content_image = $book_content_image['file_image'];
                $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/content_book';
                $content .= "<p><img src='$url/$file_book_content_image' alt='' /></p>";
            }

            $data_content = [
                'content' => $content,
            ];

            $this->db->where('id', $id);
            $this->db->update('book_identities', $data_content);
        }

        $upload_cover_image = $this->uploadCoverImage();
            if($upload_cover_image == 'default.jpg') {
                $cover_image = $this->input->post('old_cover_image', true);
            } else {
                $this->deleteCoverImage($id);
                $cover_image = $upload_cover_image;
            }


        $data = [
            "isbn" => $this->input->post('isbn', true),
            "title" => $this->input->post('title', true),
            "author" => $this->input->post('author', true),
            "publisher" => $this->input->post('publisher', true),
            "publication_year" => $this->input->post('publication_year', true),
            "pages" => $this->input->post('pages', true),
            "id_category" => $this->input->post('id_category', true),
            "id_package_edition" => $this->input->post('id_package_edition', true),
            "description" => $this->input->post('description', true),
            "amount_subscribe" => 0,
            "id_admin" => $this->session->userdata('id'),
            "file_uploaded" => $file,
            "cover_image" => $cover_image,
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('book_identities', $data);
    }
    
    public function delete($id)
    {
        $this->deleteCoverImage($id);
        $this->deleteFile($id);
        $this->deleteBookContentImages($id);
        $book_stocks = $this->Book_stock_model->getByBookIdentity($id);
        if(count($book_stocks) > 0) {
            foreach($book_stocks as $value) {
                $this->db->where('id', $value['id']);
                $this->db->delete('book_stocks'); 
            }
        }

        $book_content_images = $this->Book_content_images_model->getAllByBookIdentity($id);
        if(count($book_content_images) > 0) {
            foreach($book_content_images as $value) {
                $this->db->where('id', $value['id']);
                $this->db->delete('book_content_images'); 
            }
        }
        $this->db->where('id', $id);
        $this->db->delete('book_identities');
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('book_identities');
        $this->db->where('book_identities.id', $id);
        $this->db->join('ref_book_categories', 'ref_book_categories.id = book_identities.id_category');
        $this->db->join('book_stocks', 'book_stocks.id_book = book_identities.id');
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getByIdBookIdentity($id)
    {
        $this->db->select('*');
        $this->db->from('book_identities');
        $this->db->where('book_identities.id', $id);
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getCategory($id_category)
    {
        $query = $this->db->get_where('ref_book_categories',['id' =>  $id_category]);
        return $query->row_array()['category'];
    }

    public function getPackageEdition($id_package_edition)
    {
        $query = $this->db->get_where('ref_package_editions',['id' =>  $id_package_edition]);
        return $query->row_array()['package_edition'];
    }

    public function uploadFile()
    {
        $config2['upload_path']          = './upload/book/';
        $config2['allowed_types']        = 'pdf';
        $config2['file_name']            = 'file_'.time();
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

    public function deleteFile($id)
    {
        $query = $this->Book_identity_model->getByIdBookIdentity($id);
        if ($query['file_uploaded'] != "default.pdf") {
            $filename = explode(".", $query['file_uploaded'])[0];
            return array_map('unlink', glob(FCPATH."upload/book/$filename.*"));
        }
    }

    public function getFile($id)
    {
        $query = $this->getById($id);
        return base_url('upload/book/'.$query['file_uploaded']);
    }

    public function uploadCoverImage()
    {
        $config1['upload_path']          = './upload/book/';
        $config1['allowed_types']        = 'jpg|png|jpeg';
        $config1['file_name']            = 'img_'.time();
        $config1['overwrite']			= true;
        // $config['max_size']             = 1024; // 1MB
        $config1['max_size']             = 20000; 
        // $this->load->library('upload', $config1);
        $this->upload->initialize($config1);

        if ($this->upload->do_upload('cover_image')) {
            return $this->upload->data("file_name");
        } else {
            return "default.jpg";
        } 
    }

    public function deleteCoverImage($id)
    {
        $query = $this->Book_identity_model->getByIdBookIdentity($id);
        if ($query['cover_image'] != "default.jpg") {
            $filename = explode(".", $query['cover_image'])[0];
            return array_map('unlink', glob(FCPATH."upload/book/$filename.*"));
        }
    }

    public function deleteBookContentImages($id)
    {
        $book_content_images = $this->Book_content_images_model->getAllByBookIdentity($id);
        if(count($book_content_images) > 0) {
            foreach($book_content_images as $book_content_image) {
                $filename = explode(".", $book_content_image['file_image'])[0];
                array_map('unlink', glob(FCPATH."upload/content_book/$filename.*"));
            }
        }

        return true;
    }

    public function getCoverImage($id)
    {
        $query = $this->getById($id);
        return base_url('upload/book/'.$query['cover_image']);
    }

    public function getReadBook($id)
    {
        $query = $this->getById($id);
        return $query['content'];
    }

    public function getSearchBook()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('title', $keyword);
        return $this->db->get('book_identities')->result_array();
    }
}

?>