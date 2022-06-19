<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct(){
      parent::__construct();
      $this->load->helper('url');
      $this->load->library('session');
      $this->load->library('form_validation');
      // $this->load->database();
      $this->load->model('Category_model', 'category', TRUE);
    }

  public function index()
  {
    $data['title'] = "CodeIgniter Category Manager";
    $this->load->view('category', $data);
  }

  public function show_all()
  {

    $categories = $this->category->get_all();
    header('Content-Type: application/json');
    echo json_encode($categories);
  }

  public function edit($id)
  {
    $category = $this->category->get($id);
    header('Content-Type: application/json');
    echo json_encode($category);  
  }

  public function store()
  {
    $this->form_validation->set_rules('title', 'Title', 'required');
      
    if (!$this->form_validation->run())
    {
      http_response_code(412);
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 'error',
        'errors' => validation_errors()
      ]);
    } else {
       $this->category->store();
       header('Content-Type: application/json');
       echo json_encode(['status' => "success"]);
    }

    
  }

  public function update($id)
  {
    $this->form_validation->set_rules('title', 'Title', 'required');
     
    if (!$this->form_validation->run())
    {
      http_response_code(412);
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 'error',
        'errors' => validation_errors()
      ]);
    } else {
       $this->category->update($id);
       header('Content-Type: application/json');
       echo json_encode(['status' => "success"]);
    }
  }

  public function show($id) {
    $category = $this->category->get($id);
    header('Content-Type: application/json');
    echo json_encode($category);
  }

  public function delete($id)
  {
    $this->category->delete($id);
    header('Content-Type: application/json');
    echo json_encode(['status' => "success"]);
  }

}