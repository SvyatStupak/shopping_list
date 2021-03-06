<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ShoppingList extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->model('ShoppingList_model', 'shoppingList', TRUE);
    $this->load->model('Category_model', 'category', TRUE);
    // $this->load->database();
  }

  public function index() {
    $data['title'] = "Shhoping List Manager";
    $this->load->view('shoppingList', $data);
  }

  public function show_all()
  {
    $data['shoppingLists'] =$this->shoppingList->get_all();
    $data['category'] = $this->category->get_all();
    $data['category_lists'] = $this->db->select('lists.id as list_id, categories.title as cat_title')
    ->from('categories')->join('lists', 'categories.id = lists.category_id')
    ->get()->result();
    $data['title'] = 'All list';
    echo json_encode($data);
  }

  public function edit($id)
  {
    $shoppingList = $this->shoppingList->get($id);
    header('Content-Type: application/json');
    echo json_encode($shoppingList); 
  }

  public function store()
  {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category_id', 'Category_id', 'required');
     
    if (!$this->form_validation->run())
    {
      http_response_code(412);
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 'error',
        'errors' => validation_errors()
      ]);
    } else {
       $this->shoppingList->store();
       header('Content-Type: application/json');
       echo json_encode(['status' => "success"]);
    }
  }

  public function update($id)
  {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category_id', 'Category_id', 'required');
    $this->form_validation->set_rules('status', 'Status', '');

    if (!$this->form_validation->run())
    {
      http_response_code(412);
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 'error',
        'errors' => validation_errors()
      ]);
    } else {
       $this->shoppingList->update($id);
       header('Content-Type: application/json');
       echo json_encode(['status' => "success"]);
    }
  }

  public function show($id)
  {
    $shoppingList = $this->shoppingList->get($id);
    header('Content-Type: application/json');
    echo json_encode($shoppingList);
  }

  public function delete($id)
  {
    $item = $this->shoppingList->delete($id);
    header('Content-Type: application/json');
    echo json_encode(['status' => "success"]);
  }
}
