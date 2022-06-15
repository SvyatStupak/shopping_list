<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct(){
      parent::__construct();
      $this->load->helper('url');
      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->database();
    }

  public function index()
  {
    $categories = $this->db->get('categories')->result();
    $title = 'All Category';
    $this->load->view('category/index', ['categories' => $categories, 'title' => $title]);
    $this->load->view('layout/header', ['title' => $title]);       
    $this->load->view('layout/footer');
  }

  public function create()
  {
    $title = "Create Category";
    $this->load->view('category/create', ['title' => $title]);
    $this->load->view('layout/header', ['title' => $title]);       
    $this->load->view('layout/footer');
  }

  public function edit($id)
  {
    $category = $this->db->where(['id' => $id])->get('categories')->row();
    $title = 'Edit Category';
    $this->load->view('category/edit', ['category' => $category, 'title' => $title]);
    $this->load->view('layout/header', ['title' => $title]);       
    $this->load->view('layout/footer');
  }

  public function store()
  {
      $this->form_validation->set_rules('title', 'Title', 'required');

      if ($this->form_validation->run()) {
        $category = array (
          'title' => $this->input->post('title'),
        );

        $this->db->insert('categories', $category);
      } else {
        $errors = $this->form_validation->error_array();
        $this->session->set_flashdata('errors', $errors);
        redirect(base_url('category/create'));
      }

      redirect('/category');
  }

  public function update($id)
  {
    $this->form_validation->set_rules('title', 'Title', 'required');

    if ($this->form_validation->run()) {
      $category = array (
        'title' => $this->input->post('title'),
      );

       $this->db->where(['id' => $id])->update('categories', $category);
    } else {
      $errors = $this->form_validation->error_array();
      $this->session->set_flashdata('errors', $errors);
      redirect(base_url('category/edit/'. $id));
    }

     redirect('/category');
  }

  public function show($id) {
    $category = $this->db->where(['id' => $id])->get('categories')->row();
    $title = 'Show Category';
    $this->load->view('category/show',['category' => $category, 'title' => $title]);
    $this->load->view('layout/header', ['title' => $title]);       
    $this->load->view('layout/footer');
  }

  public function delete($id)
  {
     $this->db->where(['id' => $id])->delete('categories');

     redirect('/category');
  }

}